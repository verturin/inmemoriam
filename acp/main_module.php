<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\acp;

if (!defined('IN_PHPBB'))
{
	exit;
}

class main_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string */
	protected $table_deceased;

	/** @var string */
	protected $table_logs;

	public function main($id, $mode)
	{
		global $phpbb_container, $language, $template, $request, $user;

		$this->db             = $phpbb_container->get('dbal.conn');
		$prefix               = $phpbb_container->getParameter('core.table_prefix');
		$this->table_deceased = $prefix . 'inmemoriam_deceased';
		$this->table_logs     = $prefix . 'inmemoriam_logs';

		$language->add_lang('acp_inmemoriam', 'verturin/inmemoriam');

		add_form_key('inmemoriam_acp');

		switch ($mode)
		{
			case 'deceased':
				$this->tpl_name   = 'acp_inmemoriam_deceased';
				$this->page_title = $language->lang('ACP_INMEMORIAM_DECEASED');
				$this->mode_deceased($language, $template, $request, $user);
			break;

			case 'contacts':
				$this->tpl_name   = 'acp_inmemoriam_contacts';
				$this->page_title = $language->lang('ACP_INMEMORIAM_CONTACTS');
				$this->mode_contacts($language, $template, $request, $user, $phpbb_container);
			break;

			case 'legacy':
				$this->tpl_name   = 'acp_inmemoriam_legacy';
				$this->page_title = $language->lang('ACP_INMEMORIAM_REQUESTS');
				$this->mode_legacy($language, $template, $request, $user, $phpbb_container);
			break;

			case 'settings':
			default:
				$this->tpl_name   = 'acp_inmemoriam_settings';
				$this->page_title = $language->lang('ACP_INMEMORIAM_SETTINGS');
				$this->mode_settings($language, $template, $request);
			break;
		}
	}

	/**
	 * Gestion des membres decedes.
	 */
	protected function mode_deceased($language, $template, $request, $user)
	{
		$action = $request->variable('action', '');

		// --- Suppression du bandeau ---
		if ($action === 'delete')
		{
			$deceased_id = $request->variable('id', 0);

			if (confirm_box(true))
			{
				$sql = 'SELECT user_id FROM ' . $this->table_deceased . '
					WHERE deceased_id = ' . (int) $deceased_id;
				$result = $this->db->sql_query($sql);
				$row    = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				if ($row)
				{
					$this->db->sql_query('DELETE FROM ' . $this->table_deceased . '
						WHERE deceased_id = ' . (int) $deceased_id);

					// Le membre quitte le groupe « InMemoriam ».
					$GLOBALS['phpbb_container']->get('verturin.inmemoriam.group_manager')->remove_user((int) $row['user_id']);

					$this->add_log((int) $row['user_id'], 'BANNER_REMOVED', (int) $user->data['user_id']);
				}

				trigger_error($language->lang('ACP_INMEMORIAM_REMOVED') . adm_back_link($this->u_action));
			}
			else
			{
				confirm_box(false, $language->lang('ACP_INMEMORIAM_CONFIRM_REMOVE'), build_hidden_fields([
					'action' => 'delete',
					'id'     => $deceased_id,
				]));
			}
		}

		// --- Ajout / mise a jour ---
		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('inmemoriam_acp'))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$username      = $request->variable('username', '', true);
			$death_date    = $request->variable('death_date', '');
			$memorial_text = $request->variable('memorial_text', '', true);
			$banner_color  = $request->variable('banner_color', '#000000');

			// Resolution du nom d'utilisateur -> user_id
			$sql = 'SELECT user_id FROM ' . USERS_TABLE . "
				WHERE username_clean = '" . $this->db->sql_escape(utf8_clean_string($username)) . "'";
			$result = $this->db->sql_query($sql);
			$row    = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!$row)
			{
				trigger_error($language->lang('ACP_INMEMORIAM_NO_USER', $username) . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$user_id = (int) $row['user_id'];

			// Couleur hexadecimale valide uniquement
			if (!preg_match('/^#[0-9a-fA-F]{6}$/', $banner_color))
			{
				$banner_color = '#000000';
			}

			$data = [
				'user_id'       => $user_id,
				'death_date'    => $death_date ? (int) strtotime($death_date) : 0,
				'marked_by'     => (int) $user->data['user_id'],
				'marked_date'   => time(),
				'memorial_text' => $memorial_text,
				'banner_color'  => $banner_color,
			];

			// Deja present ? -> UPDATE, sinon INSERT (evite l'erreur sur la cle UNIQUE)
			$sql = 'SELECT deceased_id FROM ' . $this->table_deceased . '
				WHERE user_id = ' . $user_id;
			$result   = $this->db->sql_query($sql);
			$existing = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if ($existing)
			{
				$this->db->sql_query('UPDATE ' . $this->table_deceased . '
					SET ' . $this->db->sql_build_array('UPDATE', $data) . '
					WHERE deceased_id = ' . (int) $existing['deceased_id']);
			}
			else
			{
				$this->db->sql_query('INSERT INTO ' . $this->table_deceased . ' ' .
					$this->db->sql_build_array('INSERT', $data));
			}

			// Le membre rejoint le groupe « InMemoriam ».
			$GLOBALS['phpbb_container']->get('verturin.inmemoriam.group_manager')->add_user($user_id);

			$this->add_log($user_id, 'MARKED_DECEASED', (int) $user->data['user_id']);

			trigger_error($language->lang('ACP_INMEMORIAM_SAVED') . adm_back_link($this->u_action));
		}

		// --- Liste ---
		$sql = 'SELECT d.*, u.username, u.user_colour
			FROM ' . $this->table_deceased . ' d
			LEFT JOIN ' . USERS_TABLE . ' u ON (d.user_id = u.user_id)
			ORDER BY d.marked_date DESC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$template->assign_block_vars('deceased', [
				'USER_ID'       => (int) $row['user_id'],
				'USERNAME_FULL' => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'DEATH_DATE'    => $row['death_date'] ? $user->format_date($row['death_date'], 'd/m/Y') : '',
				'MEMORIAL_TEXT' => $row['memorial_text'],
				'BANNER_COLOR'  => $row['banner_color'],
				'U_DELETE'      => $this->u_action . '&amp;action=delete&amp;id=' . (int) $row['deceased_id'],
			]);
		}
		$this->db->sql_freeresult($result);

		$template->assign_vars([
			'U_ACTION'      => $this->u_action,
			'U_FIND_USER'   => append_sid("{$GLOBALS['phpbb_root_path']}memberlist.{$GLOBALS['phpEx']}", 'mode=searchuser&amp;form=inmemoriam&amp;field=username&amp;select_single=true'),
			'DEFAULT_COLOR' => $GLOBALS['config']['inmemoriam_default_color'],
		]);
	}

	/**
	 * Recapitulatif des personnes legataires designees par les membres
	 * depuis leur panneau personnel.
	 */
	protected function mode_contacts($language, $template, $request, $user, $phpbb_container)
	{
		$manager = $phpbb_container->get('verturin.inmemoriam.legacy_manager');
		$prefix  = $phpbb_container->getParameter('core.table_prefix');

		if ($request->variable('action', '') === 'delete')
		{
			$target = $request->variable('u', 0);

			if (confirm_box(true))
			{
				$manager->delete_legacy($target);
				trigger_error($language->lang('ACP_INMEMORIAM_CT_DELETED') . adm_back_link($this->u_action));
			}
			else
			{
				confirm_box(false, $language->lang('ACP_INMEMORIAM_CT_CONFIRM'), build_hidden_fields([
					'action' => 'delete',
					'u'      => $target,
				]));
			}
		}

		$sql = 'SELECT l.*, u.username, u.user_colour, d.deceased_id
			FROM ' . $prefix . 'inmemoriam_legacy l
			LEFT JOIN ' . USERS_TABLE . ' u ON (l.user_id = u.user_id)
			LEFT JOIN ' . $prefix . 'inmemoriam_deceased d ON (l.user_id = d.user_id)
			ORDER BY l.legacy_time DESC';
		$result = $this->db->sql_query($sql);
		$total  = 0;

		while ($row = $this->db->sql_fetchrow($result))
		{
			$total++;
			$template->assign_block_vars('contacts', [
				'USERNAME_FULL' => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'LEGACY_NAME'   => $row['legacy_name'],
				'LEGACY_EMAIL'  => $row['legacy_email'],
				'LEGACY_DATE'   => $user->format_date($row['legacy_time']),
				'WISH'          => $manager->describe_wish($row, $language),
				'S_DECEASED'    => (bool) $row['deceased_id'],
				'U_DELETE'      => $this->u_action . '&amp;action=delete&amp;u=' . (int) $row['user_id'],
			]);
		}
		$this->db->sql_freeresult($result);

		$template->assign_vars([
			'U_ACTION' => $this->u_action,
			'TOTAL'    => $total,
		]);
	}

	/**
	 * Demandes de suppression soumises par les legataires.
	 */
	protected function mode_legacy($language, $template, $request, $user, $phpbb_container)
	{
		$manager       = $phpbb_container->get('verturin.inmemoriam.legacy_manager');
		$prefix        = $phpbb_container->getParameter('core.table_prefix');
		$table_request = $prefix . 'inmemoriam_request';

		// --- Decision de l'administrateur ---
		if ($request->is_set_post('decide'))
		{
			if (!check_form_key('inmemoriam_acp'))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$request_id = $request->variable('request_id', 0);
			$typed_key  = strtoupper(trim($request->variable('admin_key', '')));
			$decision   = $request->variable('decision', '');

			$sql = 'SELECT admin_key, request_status FROM ' . $table_request . '
				WHERE request_id = ' . (int) $request_id;
			$result = $this->db->sql_query($sql);
			$row    = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);

			if (!$row || $row['request_status'] !== 'validated')
			{
				trigger_error($language->lang('ACP_INMEMORIAM_RQ_NOT_PENDING') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			// La cle de reference doit etre saisie a l'identique : c'est le second facteur.
			if (!hash_equals($row['admin_key'], $typed_key))
			{
				trigger_error($language->lang('ACP_INMEMORIAM_RQ_BAD_KEY') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$status  = ($decision === 'approve') ? 'approved' : 'refused';
			$manager->close_request($request_id, $status, (int) $user->data['user_id']);

			trigger_error($language->lang($status === 'approved'
				? 'ACP_INMEMORIAM_RQ_APPROVED'
				: 'ACP_INMEMORIAM_RQ_REFUSED') . adm_back_link($this->u_action));
		}

		// --- Liste des demandes ---
		$prefix_l = $prefix . 'inmemoriam_legacy';
		$sql = 'SELECT r.*, u.username, u.user_colour, l.deletion_mode, l.deletion_months
			FROM ' . $table_request . ' r
			LEFT JOIN ' . USERS_TABLE . ' u ON (r.user_id = u.user_id)
			LEFT JOIN ' . $prefix_l . ' l ON (r.user_id = l.user_id)
			ORDER BY r.request_time DESC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$template->assign_block_vars('requests', [
				'ID'            => (int) $row['request_id'],
				'USERNAME_FULL' => get_username_string('full', $row['user_id'], $row['username'], $row['user_colour']),
				'LEGACY_EMAIL'  => $row['legacy_email'],
				'REQUEST_TIME'  => $user->format_date($row['request_time']),
				'STATUS'        => $language->lang('ACP_INMEMORIAM_ST_' . strtoupper($row['request_status'])),
				'STATUS_RAW'    => $row['request_status'],
				'ATTEMPTS'      => (int) $row['attempts'],
				'WISH'          => $manager->describe_wish($row, $language),
				'S_PENDING'     => ($row['request_status'] === 'validated'),
			]);
		}
		$this->db->sql_freeresult($result);

		$template->assign_vars([
			'U_ACTION' => $this->u_action,
		]);
	}

	/**
	 * Reglages de l'extension.
	 */
	protected function mode_settings($language, $template, $request)
	{
		global $config;

		if ($request->is_set_post('submit'))
		{
			if (!check_form_key('inmemoriam_acp'))
			{
				trigger_error($language->lang('FORM_INVALID') . adm_back_link($this->u_action), E_USER_WARNING);
			}

			$color = $request->variable('inmemoriam_default_color', '#000000');

			if (!preg_match('/^#[0-9a-fA-F]{6}$/', $color))
			{
				$color = '#000000';
			}

			$config->set('inmemoriam_enabled', $request->variable('inmemoriam_enabled', 0));
			$config->set('inmemoriam_default_color', $color);
			$config->set('inmemoriam_show_death_date', $request->variable('inmemoriam_show_death_date', 0));
			$config->set('inmemoriam_show_badge', $request->variable('inmemoriam_show_badge', 0));
			$config->set('inmemoriam_legacy_enabled', $request->variable('inmemoriam_legacy_enabled', 0));
			$config->set('inmemoriam_request_expire', max(1, min(365, $request->variable('inmemoriam_request_expire', 30))));
			$config->set('inmemoriam_max_attempts', max(1, min(20, $request->variable('inmemoriam_max_attempts', 5))));
			$config->set('inmemoriam_notify_legacy', $request->variable('inmemoriam_notify_legacy', 0));
			$config->set('inmemoriam_group_sync', $request->variable('inmemoriam_group_sync', 0));
			$config->set('inmemoriam_notify_admin', $request->variable('inmemoriam_notify_admin', 0));
			$config->set('inmemoriam_notify_pm', $request->variable('inmemoriam_notify_pm', 0));
			$config->set('inmemoriam_anon_site', $request->variable('inmemoriam_anon_site', 0));
			$config->set('inmemoriam_anon_label', $request->variable('inmemoriam_anon_label', '', true));

			trigger_error($language->lang('ACP_INMEMORIAM_SETTINGS_SAVED') . adm_back_link($this->u_action));
		}

		$template->assign_vars([
			'U_ACTION'                   => $this->u_action,
			'INMEMORIAM_ENABLED'         => (bool) $config['inmemoriam_enabled'],
			'INMEMORIAM_DEFAULT_COLOR'   => $config['inmemoriam_default_color'],
			'INMEMORIAM_SHOW_DEATH_DATE' => (bool) $config['inmemoriam_show_death_date'],
			'INMEMORIAM_SHOW_BADGE'      => (bool) $config['inmemoriam_show_badge'],
			'INMEMORIAM_LEGACY_ENABLED'  => (bool) $config['inmemoriam_legacy_enabled'],
			'INMEMORIAM_EXPIRE'          => (int) $config['inmemoriam_request_expire'],
			'INMEMORIAM_MAX_ATTEMPTS'    => (int) $config['inmemoriam_max_attempts'],
			'INMEMORIAM_NOTIFY_LEGACY'   => (bool) $config['inmemoriam_notify_legacy'],
			'INMEMORIAM_GROUP_SYNC'      => (bool) $config['inmemoriam_group_sync'],
			'INMEMORIAM_NOTIFY_ADMIN'    => (bool) $config['inmemoriam_notify_admin'],
			'INMEMORIAM_NOTIFY_PM'       => (bool) $config['inmemoriam_notify_pm'],
			'INMEMORIAM_ANON_SITE'       => (bool) $config['inmemoriam_anon_site'],
			'INMEMORIAM_ANON_LABEL'      => $config['inmemoriam_anon_label'],
		]);
	}

	/**
	 * Journalisation dans la table dediee de l'extension.
	 */
	protected function add_log($user_id, $action, $performed_by)
	{
		$this->db->sql_query('INSERT INTO ' . $this->table_logs . ' ' . $this->db->sql_build_array('INSERT', [
			'user_id'      => (int) $user_id,
			'log_action'   => $action,
			'performed_by' => (int) $performed_by,
			'log_ip'       => (string) $GLOBALS['user']->ip,
			'log_time'     => time(),
			'log_details'  => '',
		]));
	}
}
