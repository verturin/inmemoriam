<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\controller;

use Symfony\Component\HttpFoundation\Response;

class legacy_controller
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\controller\helper */
	protected $helper;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\request\request */
	protected $request;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var \verturin\inmemorium\core\legacy_manager */
	protected $manager;

	/** @var string */
	protected $table_legacy;

	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\controller\helper $helper,
		\phpbb\language\language $language,
		\phpbb\request\request $request,
		\phpbb\template\template $template,
		\phpbb\user $user,
		\verturin\inmemorium\core\legacy_manager $manager,
		$table_prefix
	)
	{
		$this->config       = $config;
		$this->db           = $db;
		$this->helper       = $helper;
		$this->language     = $language;
		$this->request      = $request;
		$this->template     = $template;
		$this->user         = $user;
		$this->manager      = $manager;
		$this->table_legacy = $table_prefix . 'inmemorium_legacy';
	}

	/**
	 * Formulaire public de demande de suppression.
	 */
	public function request_page()
	{
		$this->language->add_lang('common', 'verturin/inmemorium');
		$this->language->add_lang('legacy_inmemorium', 'verturin/inmemorium');

		if (empty($this->config['inmemorium_legacy_enabled']))
		{
			throw new \phpbb\exception\http_exception(404, 'INMEMORIUM_LG_DISABLED');
		}

		add_form_key('inmemorium_request');

		$error = '';
		$sent  = false;

		if ($this->request->is_set_post('submit'))
		{
			if (!check_form_key('inmemorium_request'))
			{
				$error = $this->language->lang('FORM_INVALID');
			}
			else
			{
				$username = $this->request->variable('username', '', true);
				$email    = strtolower(trim($this->request->variable('legacy_email', '')));

				$sql = 'SELECT l.user_id, l.legacy_name, l.legacy_email, u.username
					FROM ' . $this->table_legacy . ' l
					INNER JOIN ' . USERS_TABLE . " u ON (l.user_id = u.user_id)
					WHERE u.username_clean = '" . $this->db->sql_escape(utf8_clean_string($username)) . "'";
				$result = $this->db->sql_query($sql);
				$row    = $this->db->sql_fetchrow($result);
				$this->db->sql_freeresult($result);

				// Reponse volontairement identique en cas de succes ou d'echec :
				// on n'indique jamais si un legataire est enregistre pour ce membre.
				if ($row && hash_equals(strtolower($row['legacy_email']), $email))
				{
					$data = $this->manager->create_request((int) $row['user_id'], $email);
					$this->send_code_email($row, $data);
				}

				$sent = true;
			}
		}

		$this->template->assign_vars([
			'ERROR'    => $error,
			'S_SENT'   => $sent,
			'S_ACTION' => $this->helper->route('inmemorium_legacy_request'),
		]);

		return $this->helper->render('inmemorium_request.html', $this->language->lang('INMEMORIUM_LG_REQUEST_TITLE'));
	}

	/**
	 * Page de validation atteinte via le QR code ou le lien du courriel.
	 */
	public function validate_page($token)
	{
		$this->language->add_lang('common', 'verturin/inmemorium');
		$this->language->add_lang('legacy_inmemorium', 'verturin/inmemorium');

		$req = $this->manager->get_request_by_token($token);

		if (!$req)
		{
			throw new \phpbb\exception\http_exception(404, 'INMEMORIUM_LG_BAD_TOKEN');
		}

		add_form_key('inmemorium_validate');

		$error     = '';
		$validated = ($req['request_status'] === 'validated');
		$admin_key = '';

		if (!$validated && $this->request->is_set_post('submit'))
		{
			if (!check_form_key('inmemorium_validate'))
			{
				$error = $this->language->lang('FORM_INVALID');
			}
			else
			{
				$code   = strtoupper(trim($this->request->variable('security_code', '')));
				$status = $this->manager->verify_code($req, $code);

				switch ($status)
				{
					case 'ok':
						$validated = true;
						$req       = $this->manager->get_request_by_token($token);

						// L'administration doit savoir qu'une demande attend
						// une decision : sans cela, elle resterait invisible.
						// Deux canaux, car un courriel peut se perdre.
						$this->notify_admin($req);
						$this->notify_admin_pm($req);
					break;

					case 'expired':
						$error = $this->language->lang('INMEMORIUM_LG_EXPIRED');
					break;

					case 'locked':
						$error = $this->language->lang('INMEMORIUM_LG_LOCKED');
					break;

					case 'closed':
						$error = $this->language->lang('INMEMORIUM_LG_CLOSED');
					break;

					default:
						$error = $this->language->lang('INMEMORIUM_LG_BAD_CODE');
					break;
				}
			}
		}

		if ($validated)
		{
			$admin_key = $req['admin_key'];
		}

		// Adresse absolue de la page : c'est elle qui sera encodee dans le QR
		// par le navigateur, pour permettre de poursuivre sur un telephone.
		// $is_amp a false : l'adresse part dans un QR code et dans un courriel,
		// les esperluettes ne doivent pas etre encodees en HTML.
		$page_url = generate_board_url() . '/' . ltrim(
			$this->helper->route('inmemorium_legacy_validate', ['token' => $token], false),
			'/'
		);

		$member = '';

		if ($validated)
		{
			$sql = 'SELECT username FROM ' . USERS_TABLE . '
				WHERE user_id = ' . (int) $req['user_id'];
			$result = $this->db->sql_query($sql);
			$mrow   = $this->db->sql_fetchrow($result);
			$this->db->sql_freeresult($result);
			$member = $mrow ? $mrow['username'] : '';
		}

		$this->template->assign_vars([
			'ERROR'        => $error,
			'S_VALIDATED'  => $validated,
			'ADMIN_KEY'    => $admin_key,
			'MEMBER_NAME'  => $member,
			'VALIDATED_ON' => $validated ? $this->user->format_date(time()) : '',
			'PAGE_URL'     => $page_url,
			'S_ACTION'     => $this->helper->route('inmemorium_legacy_validate', ['token' => $token]),
		]);

		return $this->helper->render('inmemorium_validate.html', $this->language->lang('INMEMORIUM_LG_VALIDATE_TITLE'));
	}

	/**
	 * Envoi du courriel contenant le code de securite et le lien de validation.
	 */
	protected function send_code_email($row, $data)
	{
		if (!class_exists('messenger'))
		{
			include $GLOBALS['phpbb_root_path'] . 'includes/functions_messenger.' . $GLOBALS['phpEx'];
		}

		$url = generate_board_url() . '/' . ltrim(
			$this->helper->route('inmemorium_legacy_validate', ['token' => $data['token']], false),
			'/'
		);

		$messenger = new \messenger(false);
		$messenger->template('@verturin_inmemorium/legacy_code', $this->config['default_lang']);
		$messenger->to($row['legacy_email'], $row['legacy_name']);
		$messenger->anti_abuse_headers($this->config, $this->user);
		$messenger->assign_vars([
			'LEGACY_NAME'   => htmlspecialchars_decode($row['legacy_name']),
			'MEMBER_NAME'   => htmlspecialchars_decode($row['username']),
			'SECURITY_CODE' => $data['code'],
			'VALIDATE_URL'  => $url,
			'EXPIRE_DAYS'   => (int) $this->config['inmemorium_request_expire'],
		]);
		$messenger->send(NOTIFY_EMAIL);
	}

	/**
	 * Previent l'administration qu'une demande attend une decision.
	 *
	 * Le message part vers l'adresse de contact du forum. Il ne contient
	 * jamais la cle de reference : celle-ci doit transiter par la personne
	 * legataire, c'est tout l'interet de la double verification.
	 */
	protected function notify_admin($req)
	{
		if (empty($this->config['inmemorium_notify_admin']))
		{
			return;
		}

		$to = !empty($this->config['board_contact'])
			? $this->config['board_contact']
			: $this->config['board_email'];

		if (empty($to))
		{
			return;
		}

		$sql = 'SELECT username FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $req['user_id'];
		$result = $this->db->sql_query($sql);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!class_exists('messenger'))
		{
			include $GLOBALS['phpbb_root_path'] . 'includes/functions_messenger.' . $GLOBALS['phpEx'];
		}

		$messenger = new \messenger(false);
		$messenger->template('@verturin_inmemorium/legacy_pending_admin', $this->config['default_lang']);
		$messenger->to($to);
		$messenger->anti_abuse_headers($this->config, $this->user);
		$messenger->assign_vars([
			'MEMBER_NAME'  => $row ? htmlspecialchars_decode($row['username']) : '#' . (int) $req['user_id'],
			'LEGACY_EMAIL' => $req['legacy_email'],
			'VALIDATED_ON' => $this->user->format_date(time()),
			'ACP_URL'      => generate_board_url() . '/adm/index.' . $GLOBALS['phpEx'],
		]);
		$messenger->send(NOTIFY_EMAIL);
	}

	/**
	 * Previent l'administration par message prive.
	 *
	 * Le courriel part vers une seule adresse, qui peut ne plus etre relevee.
	 * Le message prive touche tous les administrateurs et reste visible dans
	 * le forum jusqu'a sa lecture.
	 */
	protected function notify_admin_pm($req)
	{
		if (empty($this->config['inmemorium_notify_pm']))
		{
			return;
		}

		$recipients = $this->get_admin_ids();

		if (empty($recipients))
		{
			return;
		}

		// L'expediteur est le premier fondateur : un message prive doit
		// provenir d'un compte reel pour s'afficher correctement.
		$sender = reset($recipients);

		$sql = 'SELECT user_id, username FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $sender;
		$result = $this->db->sql_query($sql);
		$from   = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$from)
		{
			return;
		}

		$sql = 'SELECT username FROM ' . USERS_TABLE . '
			WHERE user_id = ' . (int) $req['user_id'];
		$result = $this->db->sql_query($sql);
		$member = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$acp_url = generate_board_url() . '/adm/index.' . $GLOBALS['phpEx'];

		$message = $this->language->lang(
			'INMEMORIUM_PM_BODY',
			$member ? $member['username'] : '#' . (int) $req['user_id'],
			$req['legacy_email'],
			$this->user->format_date(time()),
			$acp_url
		);

		if (!function_exists('submit_pm'))
		{
			include $GLOBALS['phpbb_root_path'] . 'includes/functions_privmsgs.' . $GLOBALS['phpEx'];
		}

		if (!function_exists('generate_text_for_storage'))
		{
			include $GLOBALS['phpbb_root_path'] . 'includes/functions_content.' . $GLOBALS['phpEx'];
		}

		$uid = $bitfield = $options = '';
		generate_text_for_storage($message, $uid, $bitfield, $options, true, true, true);

		$address = [];

		foreach ($recipients as $user_id)
		{
			$address[(int) $user_id] = 'to';
		}

		$data = [
			'from_user_id'     => (int) $from['user_id'],
			'from_username'    => $from['username'],
			'from_user_ip'     => (string) $this->user->ip,
			'enable_sig'       => false,
			'enable_bbcode'    => true,
			'enable_smilies'   => false,
			'enable_urls'      => true,
			'icon_id'          => 0,
			'bbcode_bitfield'  => $bitfield,
			'bbcode_uid'       => $uid,
			'message'          => $message,
			'address_list'     => ['u' => $address],
		];

		submit_pm('post', $this->language->lang('INMEMORIUM_PM_SUBJECT'), $data, false);
	}

	/**
	 * Destinataires : les fondateurs, et les membres du groupe des
	 * administrateurs. Les doublons sont ecartes.
	 */
	protected function get_admin_ids()
	{
		$ids = [];

		$sql = 'SELECT user_id FROM ' . USERS_TABLE . '
			WHERE user_type = ' . USER_FOUNDER . '
			ORDER BY user_id ASC';
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[(int) $row['user_id']] = (int) $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		$sql = 'SELECT ug.user_id
			FROM ' . USER_GROUP_TABLE . ' ug
			INNER JOIN ' . GROUPS_TABLE . " g ON (ug.group_id = g.group_id)
			WHERE g.group_name = 'ADMINISTRATORS'
			AND ug.user_pending = 0";
		$result = $this->db->sql_query($sql);

		while ($row = $this->db->sql_fetchrow($result))
		{
			$ids[(int) $row['user_id']] = (int) $row['user_id'];
		}
		$this->db->sql_freeresult($result);

		return $ids;
	}
}
