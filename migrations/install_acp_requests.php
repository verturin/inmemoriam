<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\migrations;

class install_acp_requests extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemoriam\migrations\install_sheet'];
	}

	public function update_data()
	{
		return [
			// L'ecran des demandes de suppression etait declare dans
			// main_info.php mais aucun module ne le rendait accessible :
			// l'administrateur n'avait donc nulle part ou valider la cle.
			['module.add', [
				'acp',
				'ACP_INMEMORIAM_TITLE',
				[
					'module_basename' => '\verturin\inmemoriam\acp\main_module',
					'modes'           => ['legacy'],
				],
			]],
		];
	}
}
