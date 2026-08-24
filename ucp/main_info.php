<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\ucp;

if (!defined('IN_PHPBB'))
{
	exit;
}

class main_info
{
	public function module()
	{
		return [
			'filename' => '\verturin\inmemorium\ucp\main_module',
			'title'    => 'UCP_INMEMORIUM',
			'modes'    => [
				'legacy' => [
					'title' => 'UCP_INMEMORIUM_LEGACY',
					'auth'  => 'ext_verturin/inmemorium',
					'cat'   => ['UCP_PROFILE'],
				],
			],
		];
	}
}
