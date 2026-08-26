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

	'UCP_INMEMORIAM_EXPLAIN' => 'Vous pouvez désigner une personne de confiance qui sera autorisée à demander la suppression de votre compte après votre disparition. Cette personne n’obtient aucun droit sur votre compte de votre vivant et ne peut ni s’y connecter, ni le modifier.',

	'UCP_INMEMORIAM_NAME'          => 'Nom de la personne',
	'UCP_INMEMORIAM_EMAIL'         => 'Adresse de courriel',
	'UCP_INMEMORIAM_EMAIL_EXPLAIN' => 'C’est à cette adresse que le code de sécurité sera envoyé. Prévenez cette personne de votre démarche.',

	'UCP_INMEMORIAM_HOWTO_TITLE' => 'Comment la procédure se déroule',
	'UCP_INMEMORIAM_HOWTO_1'     => 'La personne désignée remplit le formulaire public de demande, en indiquant votre nom d’utilisateur et son adresse de courriel.',
	'UCP_INMEMORIAM_HOWTO_2'     => 'Un code de sécurité lui est envoyé par courriel, accompagné d’un lien et d’un QR code.',
	'UCP_INMEMORIAM_HOWTO_3'     => 'Elle saisit ce code sur la page de validation. Une clé de référence lui est alors communiquée.',
	'UCP_INMEMORIAM_HOWTO_4'     => 'Un administrateur confirme cette clé de référence avant que la suppression ne soit effectuée.',

	'UCP_INMEMORIAM_CURRENT'        => 'Une personne légataire est enregistrée depuis le %s.',
	'UCP_INMEMORIAM_SAVED'          => 'La personne légataire a été enregistrée.',
	'UCP_INMEMORIAM_DELETED'        => 'La désignation a été supprimée.',
	'UCP_INMEMORIAM_DELETE'         => 'Supprimer la désignation',
	'UCP_INMEMORIAM_DELETE_CONFIRM' => 'Supprimer la personne légataire désignée ?',
	'UCP_INMEMORIAM_DISABLED'       => 'La désignation d’une personne légataire est désactivée sur ce forum.',

	'UCP_INMEMORIAM_NAME_REQUIRED' => 'Vous devez indiquer le nom de la personne légataire.',
	'UCP_INMEMORIAM_EMAIL_SELF'    => 'L’adresse de la personne légataire doit être différente de la vôtre.',
	'UCP_INMEMORIAM_WISH'         => 'Devenir de votre compte',
	'UCP_INMEMORIAM_WISH_EXPLAIN' => 'Indiquez ce que vous souhaitez qu’il advienne de votre compte et de vos messages une fois la disparition confirmée. Ce choix n’engage que vous et peut être modifié à tout moment.',
	'UCP_INMEMORIAM_WISH_CHOICE'  => 'Votre souhait',
	'UCP_INMEMORIAM_WISH_NOW'     => 'Tout supprimer immédiatement',
	'UCP_INMEMORIAM_WISH_DELAY'   => 'Tout supprimer au bout de',
	'UCP_INMEMORIAM_WISH_BOARD'   => 'Conserver le compte, selon les règles habituelles du forum',
	'UCP_INMEMORIAM_MONTHS'       => '%d mois',
	'UCP_INMEMORIAM_WISH_PRIVACY' => 'Ce souhait n’est visible que par vous et par les administrateurs du forum. La personne légataire ne le connaît pas.',
	'UCP_INMEMORIAM_SEND_MAIL'         => 'Prévenir par courriel',
	'UCP_INMEMORIAM_SEND_MAIL_EXPLAIN' => 'Décochez si vous préférez remettre vous-même la fiche à la personne. Le code d’activation figurera alors uniquement sur la fiche à imprimer.',
	'UCP_INMEMORIAM_SEND_MAIL_YES'     => 'Envoyer le courriel de désignation',
	'UCP_INMEMORIAM_SHEET_BTN'         => 'Imprimer la fiche légataire',
	'UCP_INMEMORIAM_SHEET_TITLE'       => 'Fiche légataire',
	'UCP_INMEMORIAM_SHEET_ONCE'        => 'Ce code n’est affiché qu’une fois',
	'UCP_INMEMORIAM_SHEET_ONCE_EXPLAIN'=> 'Imprimez ou enregistrez cette fiche maintenant. Le code n’est pas conservé en clair : en redemander une fiche produira un nouveau code et invalidera celui-ci.',
	'UCP_INMEMORIAM_SHEET_HEADING'     => 'Fiche à remettre à la personne légataire',
	'UCP_INMEMORIAM_SHEET_INTRO'       => 'Cette fiche concerne un compte inscrit sur %s. Conservez-la en lieu sûr : elle sera nécessaire le moment venu.',
	'UCP_INMEMORIAM_SHEET_FOR'         => 'Personne légataire',
	'UCP_INMEMORIAM_SHEET_MEMBER'      => 'Membre concerné',
	'UCP_INMEMORIAM_SHEET_CODE'        => 'Code d’activation',
	'UCP_INMEMORIAM_SHEET_CODE_EXPLAIN'=> 'À saisir sur le formulaire, après avoir scanné le code ci-contre.',
	'UCP_INMEMORIAM_SHEET_QR'          => 'Scannez pour ouvrir le formulaire.',
	'UCP_INMEMORIAM_SHEET_QR_ALT'      => 'QR code menant au formulaire de demande',
	'UCP_INMEMORIAM_SHEET_STEPS'       => 'La démarche, le moment venu',
	'UCP_INMEMORIAM_SHEET_STEP1'       => 'Scanner le QR code : le formulaire s’ouvre, déjà rempli.',
	'UCP_INMEMORIAM_SHEET_STEP2'       => 'Saisir le code d’activation ci-dessus et valider.',
	'UCP_INMEMORIAM_SHEET_STEP3'       => 'Un code de sécurité arrive par courriel ; le saisir sur la page indiquée.',
	'UCP_INMEMORIAM_SHEET_STEP4'       => 'Transmettre à un administrateur la clé de référence alors affichée.',
	'UCP_INMEMORIAM_SHEET_PRINT'       => 'Imprimer cette fiche',
	'UCP_INMEMORIAM_SHEET_BACK'        => 'Retour',
	'UCP_INMEMORIAM_SHEET_PDF'         => 'Dans la fenêtre d’impression, choisissez « Enregistrer au format PDF » pour conserver la fiche.',
]);
