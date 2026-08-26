<?php
/**
 * In Memoriam extension for phpBB - Francais (permissions).
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

if (!defined('IN_PHPBB'))
{
	exit;
}

if (empty($lang) || !is_array($lang))
{
	$lang = [];
}

$lang = array_merge($lang, [
	'ACL_A_INMEMORIAM_MANAGE' => 'Peut gérer les bandeaux In Memoriam',
]);
