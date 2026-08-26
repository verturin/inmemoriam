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
	'INMEMORIAM_TITLE'        => 'In Memoriam',
	'INMEMORIAM_DEFAULT_TEXT' => 'In memory of a valued member of our community.',
	'INMEMORIAM_DEATH_DATE'   => 'Passed away on %s',

	// Titres des modules : lus lors de la construction des menus,
	// donc charges globalement via l'evenement core.user_setup.
	'ACP_INMEMORIAM_TITLE'      => 'In Memoriam',
	'ACP_INMEMORIAM_DECEASED'   => 'Memorialised members',
	'ACP_INMEMORIAM_REQUESTS'   => 'Deletion requests',
	'ACP_INMEMORIAM_SETTINGS'   => 'Settings',
	'UCP_INMEMORIAM'            => 'In Memoriam',
	'UCP_INMEMORIAM_LEGACY'     => 'Legacy contact',
	'ACP_INMEMORIAM_CONTACTS'   => 'Legacy contacts',
	'INMEMORIAM_WISH_NOW'   => 'Delete everything immediately',
	'INMEMORIAM_WISH_DELAY' => 'Delete everything after %d months',
	'INMEMORIAM_WISH_BOARD' => 'Keep the account under the board rules',
	'INMEMORIAM_ANON_DEFAULT' => 'an online board',
]);
