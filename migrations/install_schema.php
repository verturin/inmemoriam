<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\migrations;

class install_schema extends \phpbb\db\migration\migration
{
	// Aucune dependance vers une migration du coeur : la version minimale de
	// phpBB est deja verifiee par is_enableable() dans ext.php. Declarer ici
	// une classe du coeur exposerait a une erreur si son nom changeait.

	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'inmemorium_deceased');
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				$this->table_prefix . 'inmemorium_deceased' => [
					'COLUMNS' => [
						'deceased_id'   => ['UINT', null, 'auto_increment'],
						'user_id'       => ['UINT', 0],
						'death_date'    => ['TIMESTAMP', 0],
						'marked_by'     => ['UINT', 0],
						'marked_date'   => ['TIMESTAMP', 0],
						'memorial_text' => ['TEXT_UNI', ''],
						'banner_color'  => ['VCHAR:7', '#000000'],
					],
					'PRIMARY_KEY' => 'deceased_id',
					'KEYS' => [
						'im_user_id' => ['UNIQUE', 'user_id'],
					],
				],

				$this->table_prefix . 'inmemorium_logs' => [
					'COLUMNS' => [
						'log_id'       => ['UINT', null, 'auto_increment'],
						'user_id'      => ['UINT', 0],
						'log_action'   => ['VCHAR:100', ''],
						'performed_by' => ['UINT', 0],
						'log_ip'       => ['VCHAR:40', ''],
						'log_time'     => ['TIMESTAMP', 0],
						'log_details'  => ['TEXT_UNI', ''],
					],
					'PRIMARY_KEY' => 'log_id',
					'KEYS' => [
						'im_log_user' => ['INDEX', 'user_id'],
						'im_log_time' => ['INDEX', 'log_time'],
					],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'inmemorium_deceased',
				$this->table_prefix . 'inmemorium_logs',
			],
		];
	}
}
