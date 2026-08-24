<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\migrations;

class install_acp_module extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemorium\migrations\install_config'];
	}

	public function update_data()
	{
		return [
			['module.add', [
				'acp',
				'ACP_CAT_DOT_MODS',
				'ACP_INMEMORIUM_TITLE',
			]],
			['module.add', [
				'acp',
				'ACP_INMEMORIUM_TITLE',
				[
					'module_basename' => '\verturin\inmemorium\acp\main_module',
					'modes'           => ['deceased', 'settings'],
				],
			]],

			['permission.add', ['a_inmemorium_manage', true]],
			['permission.permission_set', ['ROLE_ADMIN_FULL', 'a_inmemorium_manage']],
		];
	}

	public function revert_data()
	{
		return [
			['permission.remove', ['a_inmemorium_manage']],
		];
	}
}
