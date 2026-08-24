<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\core;

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Synchronise le groupe « InMemoriam » avec la liste des membres commemores.
 *
 * C'est le seul endroit de l'extension qui ecrit dans une table de phpBB
 * (la table des appartenances aux groupes). Les fonctions natives sont
 * utilisees plutot qu'une requete directe : elles gerent le groupe par
 * defaut de l'utilisateur, le cache et la journalisation.
 */
class group_manager
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var string */
	protected $root_path;

	/** @var string */
	protected $php_ext;

	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		$root_path,
		$php_ext
	)
	{
		$this->config    = $config;
		$this->db        = $db;
		$this->root_path = $root_path;
		$this->php_ext   = $php_ext;
	}

	/**
	 * Identifiant du groupe, ou 0 si la synchronisation est desactivee
	 * ou si le groupe a ete supprime a la main depuis l'ACP.
	 */
	public function get_group_id()
	{
		if (empty($this->config['inmemorium_group_sync']))
		{
			return 0;
		}

		$group_id = (int) $this->config['inmemorium_group_id'];

		if (!$group_id)
		{
			return 0;
		}

		// Le groupe existe-t-il toujours ?
		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . '
			WHERE group_id = ' . $group_id;
		$result = $this->db->sql_query($sql);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row ? $group_id : 0;
	}

	/**
	 * Ajoute un membre au groupe.
	 */
	public function add_user($user_id)
	{
		$group_id = $this->get_group_id();

		if (!$group_id)
		{
			return false;
		}

		$this->load_functions();

		// Deja membre ? group_user_add renverrait une erreur.
		if ($this->is_member($group_id, $user_id))
		{
			return true;
		}

		group_user_add($group_id, [(int) $user_id]);

		return true;
	}

	/**
	 * Retire un membre du groupe.
	 */
	public function remove_user($user_id)
	{
		$group_id = $this->get_group_id();

		if (!$group_id)
		{
			return false;
		}

		$this->load_functions();

		if (!$this->is_member($group_id, $user_id))
		{
			return true;
		}

		group_user_del($group_id, [(int) $user_id]);

		return true;
	}

	/**
	 * Appartenance deja enregistree ?
	 */
	protected function is_member($group_id, $user_id)
	{
		$sql = 'SELECT user_id FROM ' . USER_GROUP_TABLE . '
			WHERE group_id = ' . (int) $group_id . '
			AND user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return (bool) $row;
	}

	/**
	 * Les fonctions de groupe vivent dans un fichier qui n'est pas
	 * charge partout : il faut l'inclure explicitement.
	 */
	protected function load_functions()
	{
		if (!function_exists('group_user_add'))
		{
			include $this->root_path . 'includes/functions_user.' . $this->php_ext;
		}
	}
}
