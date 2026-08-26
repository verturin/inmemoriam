<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\event;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class main_listener implements EventSubscriberInterface
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\language\language */
	protected $language;

	/** @var \phpbb\template\template */
	protected $template;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $table_deceased;

	/** @var array|null Cache des user_id decedes du sujet courant */
	protected $topic_deceased = null;

	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\language\language $language,
		\phpbb\template\template $template,
		\phpbb\user $user,
		$table_prefix
	)
	{
		$this->config         = $config;
		$this->db             = $db;
		$this->language       = $language;
		$this->template       = $template;
		$this->user           = $user;
		$this->table_deceased = $table_prefix . 'inmemoriam_deceased';
	}

	public static function getSubscribedEvents()
	{
		return [
			'core.user_setup'                  => 'load_language',
			'core.permissions'                 => 'add_permission',
			'core.memberlist_view_profile'     => 'profile_banner',
			'core.viewtopic_modify_post_row'   => 'post_badge',
		];
	}

	/**
	 * Charge le fichier de langue commun sur toutes les pages.
	 *
	 * Indispensable : les titres des modules ACP et UCP sont traduits au
	 * moment de construire les menus, avant que le module concerne ne soit
	 * charge. Sans cela, les cles s'affichent telles quelles.
	 */
	public function load_language($event)
	{
		$lang_set_ext = $event['lang_set_ext'];
		$lang_set_ext[] = [
			'ext_name' => 'verturin/inmemoriam',
			'lang_set' => 'common',
		];
		$event['lang_set_ext'] = $lang_set_ext;
	}

	/**
	 * Declare la permission pour qu'elle s'affiche traduite dans l'ACP.
	 */
	public function add_permission($event)
	{
		$permissions = $event['permissions'];
		$permissions['a_inmemoriam_manage'] = ['lang' => 'ACL_A_INMEMORIAM_MANAGE', 'cat' => 'misc'];
		$event['permissions'] = $permissions;
	}

	/**
	 * Bandeau commemoratif sur la fiche de profil.
	 */
	public function profile_banner($event)
	{
		if (empty($this->config['inmemoriam_enabled']))
		{
			return;
		}

		$row = $this->get_deceased((int) $event['member']['user_id']);

		if (!$row)
		{
			return;
		}

		$this->template->assign_vars([
			'INMEMORIAM_SHOW'       => true,
			'INMEMORIAM_COLOR'      => $row['banner_color'],
			'INMEMORIAM_TEXT'       => $row['memorial_text'] !== ''
				? $row['memorial_text']
				: $this->language->lang('INMEMORIAM_DEFAULT_TEXT'),
			'INMEMORIAM_DEATH_DATE' => (!empty($this->config['inmemoriam_show_death_date']) && $row['death_date'])
				? $this->user->format_date($row['death_date'], 'd/m/Y')
				: '',
		]);
	}

	/**
	 * Badge sur chaque message de l'auteur decede.
	 */
	public function post_badge($event)
	{
		if (empty($this->config['inmemoriam_enabled']) || empty($this->config['inmemoriam_show_badge']))
		{
			return;
		}

		// L'evenement ne fournit pas de variable poster_id : l'auteur du
		// message se lit dans $event['row'].
		$row = $event['row'];
		$deceased = $this->get_deceased((int) $row['user_id']);

		$post_row = $event['post_row'];
		$post_row['INMEMORIAM_BADGE'] = (bool) $deceased;
		$post_row['INMEMORIAM_BADGE_TEXT'] = $deceased
			? $this->language->lang('INMEMORIAM_TITLE')
			: '';
		$event['post_row'] = $post_row;
	}

	/**
	 * Retourne la ligne du membre decede, ou false.
	 */
	protected function get_deceased($user_id)
	{
		if ($user_id <= 0)
		{
			return false;
		}

		// Cache par requete pour eviter une requete SQL par message.
		if (isset($this->topic_deceased[$user_id]))
		{
			return $this->topic_deceased[$user_id];
		}

		$sql = 'SELECT death_date, memorial_text, banner_color
			FROM ' . $this->table_deceased . '
			WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		$this->topic_deceased[$user_id] = $row;

		return $row;
	}
}
