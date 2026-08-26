<?php
/**
 * In Memoriam extension for phpBB - Francais (pages legataire).
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
	// Page de demande
	'INMEMORIAM_LG_REQUEST_TITLE'   => 'Demande de suppression d’un compte',
	'INMEMORIAM_LG_REQUEST_EXPLAIN' => 'Ce formulaire est réservé aux personnes désignées comme légataires par un membre du forum. Si le membre vous a bien désigné, un code de sécurité vous sera envoyé par courriel.',
	'INMEMORIAM_LG_MEMBER'          => 'Nom d’utilisateur du membre',
	'INMEMORIAM_LG_MEMBER_EXPLAIN'  => 'Le nom sous lequel le membre est inscrit sur ce forum.',
	'INMEMORIAM_LG_YOUR_EMAIL'      => 'Votre adresse de courriel',
	'INMEMORIAM_LG_YOUR_EMAIL_EXPLAIN' => 'L’adresse que le membre a enregistrée pour vous.',
	'INMEMORIAM_LG_PRIVACY_NOTICE'  => 'Par sécurité, ce formulaire renvoie toujours la même réponse, que la demande aboutisse ou non. Cela évite de révéler si un membre a désigné une personne légataire.',
	'INMEMORIAM_LG_SENT_TITLE'      => 'Demande enregistrée',
	'INMEMORIAM_LG_SENT_BODY'       => 'Si les informations saisies correspondent à une désignation enregistrée, un courriel contenant le code de sécurité vient d’être envoyé. Pensez à vérifier vos courriers indésirables.',
	'INMEMORIAM_LG_DISABLED'        => 'Cette fonctionnalité est désactivée sur ce forum.',

	// Page de validation
	'INMEMORIAM_LG_VALIDATE_TITLE'   => 'Validation du code de sécurité',
	'INMEMORIAM_LG_VALIDATE_EXPLAIN' => 'Saisissez le code de sécurité reçu par courriel. Ce code est strictement personnel.',
	'INMEMORIAM_LG_CODE'             => 'Code de sécurité',
	'INMEMORIAM_LG_CODE_EXPLAIN'     => 'Quatre groupes de cinq caractères, séparés par des tirets.',
	'INMEMORIAM_LG_VALIDATE_BTN'     => 'Valider le code',
	'INMEMORIAM_LG_BAD_TOKEN'        => 'Ce lien de validation est invalide ou a expiré.',
	'INMEMORIAM_LG_BAD_CODE'         => 'Le code saisi est incorrect.',
	'INMEMORIAM_LG_EXPIRED'          => 'Cette demande a expiré. Vous devez en formuler une nouvelle.',
	'INMEMORIAM_LG_LOCKED'           => 'Trop de tentatives infructueuses. Cette demande est bloquée : contactez un administrateur du forum.',
	'INMEMORIAM_LG_CLOSED'           => 'Cette demande a déjà été traitée.',

	// Résultat
	'INMEMORIAM_LG_OK_TITLE'          => 'Code validé',
	'INMEMORIAM_LG_OK_BODY'           => 'Votre identité a été confirmée. La demande est désormais soumise à un administrateur du forum.',
	'INMEMORIAM_LG_ADMIN_KEY'         => 'Clé de référence',
	'INMEMORIAM_LG_ADMIN_KEY_EXPLAIN' => 'Conservez cette clé. L’administrateur devra la confronter à celle affichée sur la fiche du membre avant de procéder à la suppression. Ne la transmettez qu’à un administrateur du forum.',
	'INMEMORIAM_LG_SHEET_TITLE'   => 'Fiche de validation',
	'INMEMORIAM_LG_SHEET_MEMBER'  => 'Compte concerné : %s',
	'INMEMORIAM_LG_SHEET_DATE'    => 'Code validé le %s',
	'INMEMORIAM_LG_QR_ALT'        => 'QR code menant à cette page de validation',
	'INMEMORIAM_LG_QR_CAPTION'    => 'Scannez pour rouvrir cette page.',
	'INMEMORIAM_LG_CONTINUE_MOBILE' => 'Vous préférez poursuivre depuis votre téléphone ? Scannez ce code.',
	'INMEMORIAM_LG_PRINT'         => 'Imprimer cette fiche',
	'INMEMORIAM_LG_PRINT_EXPLAIN' => 'Dans la fenêtre d’impression, choisissez « Enregistrer au format PDF » pour conserver cette fiche.',
	'INMEMORIAM_LG_ACTIVATION'         => 'Code d’activation',
	'INMEMORIAM_LG_ACTIVATION_EXPLAIN' => 'Le code figurant dans le courriel reçu lors de votre désignation. Il ne vous a été transmis qu’une seule fois.',
	'INMEMORIAM_PM_STARTED_SUBJECT' => 'Procédure de succession engagée',
	'INMEMORIAM_PM_STARTED_BODY'    => "Une personne légataire vient de demander la suppression d'un compte. Un code de sécurité lui a été envoyé par courriel.\n\n[b]Compte concerné :[/b] %1\$s\n[b]Personne légataire :[/b] %2\$s\n[b]Demande déposée le :[/b] %3\$s\n\nAucune action ne vous est demandée à ce stade. Vous serez prévenu de nouveau lorsque cette personne aura saisi son code, et c'est à ce moment-là que vous pourrez statuer.\n\nSuivi des demandes : %4\$s\nExtensions → In Memoriam → Demandes de suppression\n\nSi cette demande vous semble suspecte, vous pouvez la refuser depuis cet écran.",
	'INMEMORIAM_PM_PENDING_SUBJECT' => 'Demande de suppression de compte à valider',
	'INMEMORIAM_PM_PENDING_BODY'    => "Une personne légataire vient de valider son code de sécurité. Une demande de suppression de compte attend une décision.\n\n[b]Compte concerné :[/b] %1\$s\n[b]Personne légataire :[/b] %2\$s\n[b]Validation effectuée :[/b] %3\$s\n\nPour statuer : %4\$s\nExtensions → In Memoriam → Demandes de suppression\n\nVous devrez saisir la clé de référence que la personne légataire vous communiquera. Elle ne figure volontairement pas dans ce message : c'est ce qui en fait une seconde vérification.\n\nN'approuvez la demande qu'après avoir obtenu cette clé par un canal dont vous êtes sûr, et vous être assuré de la réalité du décès.",
]);
