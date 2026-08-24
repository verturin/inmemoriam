<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\acp;

if (!defined('IN_PHPBB'))
{
	exit;
}

class main_info
{
	public function module()
	{
		return [
			'filename' => '\verturin\inmemorium\acp\main_module',
			'title'    => 'ACP_INMEMORIUM_TITLE',
			'modes'    => [
				'deceased' => [
					'title' => 'ACP_INMEMORIUM_DECEASED',
					'auth'  => 'ext_verturin/inmemorium && acl_a_inmemorium_manage',
					'cat'   => ['ACP_INMEMORIUM_TITLE'],
				],
				'contacts' => [
					'title' => 'ACP_INMEMORIUM_CONTACTS',
					'auth'  => 'ext_verturin/inmemorium && acl_a_inmemorium_manage',
					'cat'   => ['ACP_INMEMORIUM_TITLE'],
				],
				'legacy' => [
					'title' => 'ACP_INMEMORIUM_REQUESTS',
					'auth'  => 'ext_verturin/inmemorium && acl_a_inmemorium_manage',
					'cat'   => ['ACP_INMEMORIUM_TITLE'],
				],
				'settings' => [
					'title' => 'ACP_INMEMORIUM_SETTINGS',
					'auth'  => 'ext_verturin/inmemorium && acl_a_inmemorium_manage',
					'cat'   => ['ACP_INMEMORIUM_TITLE'],
				],
			],
		];
	}
}
