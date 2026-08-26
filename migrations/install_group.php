<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\migrations;

class install_group extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemoriam\migrations\install_legacy'];
	}

	public function effectively_installed()
	{
		return isset($this->config['inmemoriam_group_id']);
	}

	public function update_data()
	{
		return [
			['config.add', ['inmemoriam_group_id', 0]],
			['config.add', ['inmemoriam_group_sync', 1]],
			['config.add', ['inmemoriam_notify_legacy', 1]],

			['custom', [[$this, 'create_group']]],

			// Recapitulatif des personnes legataires designees.
			['module.add', [
				'acp',
				'ACP_INMEMORIAM_TITLE',
				[
					'module_basename' => '\verturin\inmemoriam\acp\main_module',
					'modes'           => ['contacts'],
				],
			]],
		];
	}

	/**
	 * Cree le groupe « InMemoriam » s'il n'existe pas deja.
	 */
	public function create_group()
	{
		$name = 'InMemoriam';

		$sql = 'SELECT group_id FROM ' . GROUPS_TABLE . "
			WHERE group_name = '" . $this->db->sql_escape($name) . "'";
		$result = $this->db->sql_query($sql);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if ($row)
		{
			$this->config->set('inmemoriam_group_id', (int) $row['group_id']);

			return;
		}

		$this->db->sql_query('INSERT INTO ' . GROUPS_TABLE . ' ' . $this->db->sql_build_array('INSERT', [
			'group_name'           => $name,
			'group_desc'           => 'Membres commemores du forum.',
			'group_desc_options'   => 7,
			'group_desc_bitfield'  => '',
			'group_desc_uid'       => '',
			'group_type'           => GROUP_CLOSED,
			'group_colour'         => '000000',
			'group_display'        => 0,
			'group_legend'         => 0,
			'group_avatar'         => '',
			'group_avatar_type'    => '',
			'group_avatar_width'   => 0,
			'group_avatar_height'  => 0,
			'group_rank'           => 0,
			'group_sig_chars'      => 0,
			'group_receive_pm'     => 0,
			'group_message_limit'  => 0,
			'group_max_recipients' => 0,
			'group_founder_manage' => 0,
			'group_skip_auth'      => 0,
		]));

		$this->config->set('inmemoriam_group_id', (int) $this->db->sql_nextid());
	}

	/**
	 * Supprime le groupe et ses appartenances lors du retrait des donnees.
	 */
	public function revert_data()
	{
		return [
			['custom', [[$this, 'delete_group']]],
		];
	}

	public function delete_group()
	{
		$group_id = (int) $this->config['inmemoriam_group_id'];

		if (!$group_id)
		{
			return;
		}

		$this->db->sql_query('DELETE FROM ' . USER_GROUP_TABLE . ' WHERE group_id = ' . $group_id);
		$this->db->sql_query('DELETE FROM ' . GROUPS_TABLE . ' WHERE group_id = ' . $group_id);
	}
}
