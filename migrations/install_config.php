<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\migrations;

class install_config extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemoriam\migrations\install_schema'];
	}

	public function effectively_installed()
	{
		return isset($this->config['inmemoriam_enabled']);
	}

	public function update_data()
	{
		return [
			['config.add', ['inmemoriam_enabled', 1]],
			['config.add', ['inmemoriam_default_color', '#000000']],
			['config.add', ['inmemoriam_show_death_date', 1]],
			['config.add', ['inmemoriam_show_badge', 1]],
		];
	}
}
