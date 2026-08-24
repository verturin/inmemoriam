<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 verturin
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\migrations;

class install_pm_notice extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemorium\migrations\install_ucp_menu'];
	}

	public function effectively_installed()
	{
		return isset($this->config['inmemorium_notify_pm']);
	}

	public function update_data()
	{
		return [
			['config.add', ['inmemorium_notify_pm', 1]],
		];
	}
}
