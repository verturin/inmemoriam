<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\migrations;

class install_sheet extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemoriam\migrations\install_activation'];
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_column_exists($this->table_prefix . 'inmemoriam_legacy', 'sheet_token');
	}

	public function update_schema()
	{
		return [
			'add_columns' => [
				$this->table_prefix . 'inmemoriam_legacy' => [
					// Jeton porte par le QR code de la fiche. Il identifie la
					// designation, mais ne suffit pas : le code d'activation
					// reste exige, et le code de securite part par courriel.
					'sheet_token' => ['CHAR:32', ''],
				],
			],
		];
	}

	public function update_data()
	{
		return [
			// Masquer le nom du forum dans la fiche et les courriels.
			['config.add', ['inmemoriam_anon_site', 0]],
			['config.add', ['inmemoriam_anon_label', '']],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_columns' => [
				$this->table_prefix . 'inmemoriam_legacy' => ['sheet_token'],
			],
		];
	}
}
