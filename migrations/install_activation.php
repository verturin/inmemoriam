<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\migrations;

class install_activation extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemoriam\migrations\install_pm_notice'];
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'inmemoriam_legacy', 'activation_hash');
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'inmemoriam_legacy' => [
					// Troisieme code, transmis dans le courriel de designation
					// et exige au depot de la demande. Stocke en condensat.
					'activation_hash'  => ['CHAR:64', ''],

					// Volonte du membre quant au devenir de son compte.
					// 'now' | 'delay' | 'board'
					'deletion_mode'    => ['VCHAR:10', 'board'],
					'deletion_months'  => ['UINT:3', 0],
				],
			],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'inmemoriam_legacy' => [
					'activation_hash',
					'deletion_mode',
					'deletion_months',
				],
			],
		];
	}
}
