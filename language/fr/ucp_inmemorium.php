<?php
/**
 * In Memoriam extension for phpBB - Francais (UCP).
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

	'UCP_INMEMORIUM_EXPLAIN' => 'Vous pouvez désigner une personne de confiance qui sera autorisée à demander la suppression de votre compte après votre disparition. Cette personne n’obtient aucun droit sur votre compte de votre vivant et ne peut ni s’y connecter, ni le modifier.',

	'UCP_INMEMORIUM_NAME'          => 'Nom de la personne',
	'UCP_INMEMORIUM_EMAIL'         => 'Adresse de courriel',
	'UCP_INMEMORIUM_EMAIL_EXPLAIN' => 'C’est à cette adresse que le code de sécurité sera envoyé. Prévenez cette personne de votre démarche.',

	'UCP_INMEMORIUM_HOWTO_TITLE' => 'Comment la procédure se déroule',
	'UCP_INMEMORIUM_HOWTO_1'     => 'La personne désignée remplit le formulaire public de demande, en indiquant votre nom d’utilisateur et son adresse de courriel.',
	'UCP_INMEMORIUM_HOWTO_2'     => 'Un code de sécurité lui est envoyé par courriel, accompagné d’un lien et d’un QR code.',
	'UCP_INMEMORIUM_HOWTO_3'     => 'Elle saisit ce code sur la page de validation. Une clé de référence lui est alors communiquée.',
	'UCP_INMEMORIUM_HOWTO_4'     => 'Un administrateur confirme cette clé de référence avant que la suppression ne soit effectuée.',

	'UCP_INMEMORIUM_CURRENT'        => 'Une personne légataire est enregistrée depuis le %s.',
	'UCP_INMEMORIUM_SAVED'          => 'La personne légataire a été enregistrée.',
	'UCP_INMEMORIUM_DELETED'        => 'La désignation a été supprimée.',
	'UCP_INMEMORIUM_DELETE'         => 'Supprimer la désignation',
	'UCP_INMEMORIUM_DELETE_CONFIRM' => 'Supprimer la personne légataire désignée ?',
	'UCP_INMEMORIUM_DISABLED'       => 'La désignation d’une personne légataire est désactivée sur ce forum.',

	'UCP_INMEMORIUM_NAME_REQUIRED' => 'Vous devez indiquer le nom de la personne légataire.',
	'UCP_INMEMORIUM_EMAIL_SELF'    => 'L’adresse de la personne légataire doit être différente de la vôtre.',
]);
