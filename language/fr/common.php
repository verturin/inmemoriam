<?php
/**
 * In Memoriam extension for phpBB - Francais.
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
	'INMEMORIUM_DEFAULT_TEXT' => 'À la mémoire d’un membre précieux de notre communauté.',
	'INMEMORIUM_DEATH_DATE'   => 'Disparu(e) le %s',

	// Titres des modules : lus lors de la construction des menus,
	// donc charges globalement via l'evenement core.user_setup.
	'ACP_INMEMORIUM_TITLE'      => 'In Memoriam',
	'ACP_INMEMORIUM_DECEASED'   => 'Membres commémorés',
	'ACP_INMEMORIUM_REQUESTS'   => 'Demandes de suppression',
	'ACP_INMEMORIUM_SETTINGS'   => 'Réglages',
	'UCP_INMEMORIUM'            => 'In Memoriam',
	'UCP_INMEMORIUM_LEGACY'     => 'Personne légataire',
	'ACP_INMEMORIUM_CONTACTS'   => 'Personnes légataires',
]);
