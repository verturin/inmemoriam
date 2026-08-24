<?php
/**
 * In Memoriam extension for phpBB - English.
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
	'INMEMORIUM_TITLE'        => 'In Memoriam',
	'INMEMORIUM_DEFAULT_TEXT' => 'In memory of a valued member of our community.',
	'INMEMORIUM_DEATH_DATE'   => 'Passed away on %s',

	// Titres des modules : lus lors de la construction des menus,
	// donc charges globalement via l'evenement core.user_setup.
	'ACP_INMEMORIUM_TITLE'      => 'In Memoriam',
	'ACP_INMEMORIUM_DECEASED'   => 'Memorialised members',
	'ACP_INMEMORIUM_REQUESTS'   => 'Deletion requests',
	'ACP_INMEMORIUM_SETTINGS'   => 'Settings',
	'UCP_INMEMORIUM'            => 'In Memoriam',
	'UCP_INMEMORIUM_LEGACY'     => 'Legacy contact',
	'ACP_INMEMORIUM_CONTACTS'   => 'Legacy contacts',
]);
