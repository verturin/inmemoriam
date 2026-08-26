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
	'INMEMORIAM_TITLE'        => 'In Memoriam',
	'INMEMORIAM_DEFAULT_TEXT' => 'À la mémoire d’un membre précieux de notre communauté.',
	'INMEMORIAM_DEATH_DATE'   => 'Disparu(e) le %s',

	// Titres des modules : lus lors de la construction des menus,
	// donc charges globalement via l'evenement core.user_setup.
	'ACP_INMEMORIAM_TITLE'      => 'In Memoriam',
	'ACP_INMEMORIAM_DECEASED'   => 'Membres commémorés',
	'ACP_INMEMORIAM_REQUESTS'   => 'Demandes de suppression',
	'ACP_INMEMORIAM_SETTINGS'   => 'Réglages',
	'UCP_INMEMORIAM'            => 'In Memoriam',
	'UCP_INMEMORIAM_LEGACY'     => 'Personne légataire',
	'ACP_INMEMORIAM_CONTACTS'   => 'Personnes légataires',
	'INMEMORIAM_WISH_NOW'   => 'Tout supprimer immédiatement',
	'INMEMORIAM_WISH_DELAY' => 'Tout supprimer au bout de %d mois',
	'INMEMORIAM_WISH_BOARD' => 'Conserver le compte selon les règles du forum',
	'INMEMORIAM_ANON_DEFAULT' => 'un forum en ligne',
]);
