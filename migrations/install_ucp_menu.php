<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\migrations;

class install_ucp_menu extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemorium\migrations\install_group'];
	}

	public function update_data()
	{
		return [
			// Le module etait range sous « Profil ». Il est retire de la
			// pour devenir un onglet a part entiere du panneau utilisateur,
			// au meme niveau qu'« Apercu » ou « Messages prives ».
			['module.remove', [
				'ucp',
				'UCP_PROFILE',
				[
					'module_basename' => '\verturin\inmemorium\ucp\main_module',
					'modes'           => ['legacy'],
				],
			]],

			// Categorie de premier niveau.
			['module.add', [
				'ucp',
				0,
				'UCP_INMEMORIUM',
			]],

			// Le module, range dans cette nouvelle categorie.
			['module.add', [
				'ucp',
				'UCP_INMEMORIUM',
				[
					'module_basename' => '\verturin\inmemorium\ucp\main_module',
					'modes'           => ['legacy'],
				],
			]],

			['config.add', ['inmemorium_notify_admin', 1]],
		];
	}
}
