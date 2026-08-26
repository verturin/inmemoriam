<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\ucp;

if (!defined('IN_PHPBB'))
{
	exit;
}

class main_info
{
	public function module()
	{
		return [
			'filename' => '\verturin\inmemoriam\ucp\main_module',
			'title'    => 'UCP_INMEMORIAM',
			'modes'    => [
				'legacy' => [
					'title' => 'UCP_INMEMORIAM_LEGACY',
					'auth'  => 'ext_verturin/inmemoriam',
					'cat'   => ['UCP_PROFILE'],
				],
			],
		];
	}
}
