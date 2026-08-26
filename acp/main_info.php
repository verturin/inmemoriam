<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\acp;

if (!defined('IN_PHPBB'))
{
	exit;
}

class main_info
{
	public function module()
	{
		return [
			'filename' => '\verturin\inmemoriam\acp\main_module',
			'title'    => 'ACP_INMEMORIAM_TITLE',
			'modes'    => [
				'deceased' => [
					'title' => 'ACP_INMEMORIAM_DECEASED',
					'auth'  => 'ext_verturin/inmemoriam && acl_a_inmemoriam_manage',
					'cat'   => ['ACP_INMEMORIAM_TITLE'],
				],
				'contacts' => [
					'title' => 'ACP_INMEMORIAM_CONTACTS',
					'auth'  => 'ext_verturin/inmemoriam && acl_a_inmemoriam_manage',
					'cat'   => ['ACP_INMEMORIAM_TITLE'],
				],
				'legacy' => [
					'title' => 'ACP_INMEMORIAM_REQUESTS',
					'auth'  => 'ext_verturin/inmemoriam && acl_a_inmemoriam_manage',
					'cat'   => ['ACP_INMEMORIAM_TITLE'],
				],
				'settings' => [
					'title' => 'ACP_INMEMORIAM_SETTINGS',
					'auth'  => 'ext_verturin/inmemoriam && acl_a_inmemoriam_manage',
					'cat'   => ['ACP_INMEMORIAM_TITLE'],
				],
			],
		];
	}
}
