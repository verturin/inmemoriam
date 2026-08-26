<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam;

class ext extends \phpbb\extension\base
{
	/**
	 * L'extension exige phpBB 3.3.0 minimum.
	 *
	 * @return bool
	 */
	public function is_enableable()
	{
		$config = $this->container->get('config');

		return phpbb_version_compare($config['version'], '3.3.0', '>=');
	}
}
