<?php
/**
 * In Memoriam extension for phpBB - Francais (ACP).
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

	'ACP_INMEMORIUM_DECEASED_EXPLAIN' => 'Ajoutez ici les membres pour lesquels un bandeau commémoratif doit être affiché sur leur profil et leurs messages.',
	'ACP_INMEMORIUM_MARK_DECEASED'    => 'Ajouter un membre',
	'ACP_INMEMORIUM_LIST'             => 'Membres commémorés',

	'ACP_INMEMORIUM_USERNAME'              => 'Nom d’utilisateur',
	'ACP_INMEMORIUM_USERNAME_EXPLAIN'      => 'Le membre concerné. Si une fiche existe déjà, elle sera mise à jour.',
	'ACP_INMEMORIUM_DEATH_DATE'            => 'Date de disparition',
	'ACP_INMEMORIUM_DEATH_DATE_EXPLAIN'    => 'Facultatif. Laissez vide pour ne rien afficher.',
	'ACP_INMEMORIUM_MEMORIAL_TEXT'         => 'Texte commémoratif',
	'ACP_INMEMORIUM_MEMORIAL_TEXT_EXPLAIN' => 'Facultatif. Un texte par défaut est utilisé si ce champ reste vide.',
	'ACP_INMEMORIUM_BANNER_COLOR'          => 'Couleur du bandeau',
	'ACP_INMEMORIUM_BANNER_COLOR_EXPLAIN'  => 'Couleur de fond du bandeau affiché sur le profil.',
	'ACP_INMEMORIUM_ACTIONS'               => 'Actions',
	'ACP_INMEMORIUM_REMOVE'                => 'Retirer',

	'ACP_INMEMORIUM_SETTINGS_EXPLAIN'          => 'Configuration générale de l’extension In Memoriam.',
	'ACP_INMEMORIUM_ENABLE'                    => 'Activer l’affichage',
	'ACP_INMEMORIUM_ENABLE_EXPLAIN'            => 'Désactive l’affichage des bandeaux sans désinstaller l’extension.',
	'ACP_INMEMORIUM_DEFAULT_COLOR'             => 'Couleur par défaut',
	'ACP_INMEMORIUM_DEFAULT_COLOR_EXPLAIN'     => 'Couleur proposée par défaut lors de l’ajout d’un membre.',
	'ACP_INMEMORIUM_SHOW_DEATH_DATE'           => 'Afficher la date',
	'ACP_INMEMORIUM_SHOW_DEATH_DATE_EXPLAIN'   => 'Affiche la date de disparition sur le bandeau du profil.',
	'ACP_INMEMORIUM_SHOW_BADGE'                => 'Afficher le badge',
	'ACP_INMEMORIUM_SHOW_BADGE_EXPLAIN'        => 'Affiche une mention « In Memoriam » sous l’auteur de chaque message.',

	'ACP_INMEMORIUM_SAVED'          => 'Le membre a été enregistré.',
	'ACP_INMEMORIUM_REMOVED'        => 'Le bandeau a été retiré.',
	'ACP_INMEMORIUM_SETTINGS_SAVED' => 'Les réglages ont été enregistrés.',
	'ACP_INMEMORIUM_CONFIRM_REMOVE' => 'Êtes-vous sûr de vouloir retirer ce bandeau commémoratif ?',
	'ACP_INMEMORIUM_NO_DECEASED'    => 'Aucun membre commémoré pour le moment.',
	'ACP_INMEMORIUM_NO_USER'        => 'Le membre « %s » est introuvable.',
	'ACP_INMEMORIUM_REQUESTS_EXPLAIN' => 'Demandes soumises par les personnes légataires. Une demande n’apparaît comme « en attente » qu’après validation du code de sécurité par la personne légataire. Comparez la clé de référence qu’elle vous communique avec celle attendue avant d’approuver.',
	'ACP_INMEMORIUM_RQ_EMAIL'         => 'Courriel de la personne légataire',
	'ACP_INMEMORIUM_RQ_DATE'          => 'Date de la demande',
	'ACP_INMEMORIUM_RQ_ATTEMPTS'      => 'Tentatives de saisie du code',
	'ACP_INMEMORIUM_RQ_KEY'           => 'Clé de référence',
	'ACP_INMEMORIUM_RQ_KEY_EXPLAIN'   => 'Saisissez la clé communiquée par la personne légataire. Elle doit correspondre exactement.',
	'ACP_INMEMORIUM_RQ_APPROVE'       => 'Approuver',
	'ACP_INMEMORIUM_RQ_REFUSE'        => 'Refuser',
	'ACP_INMEMORIUM_RQ_NONE'          => 'Aucune demande enregistrée.',
	'ACP_INMEMORIUM_RQ_BAD_KEY'       => 'La clé de référence saisie ne correspond pas.',
	'ACP_INMEMORIUM_RQ_NOT_PENDING'   => 'Cette demande n’est pas en attente de décision.',
	'ACP_INMEMORIUM_RQ_APPROVED'      => 'La demande a été approuvée.',
	'ACP_INMEMORIUM_RQ_REFUSED'       => 'La demande a été refusée.',
	'ACP_INMEMORIUM_ST_SENT'          => 'Code envoyé',
	'ACP_INMEMORIUM_ST_VALIDATED'     => 'En attente de décision',
	'ACP_INMEMORIUM_ST_APPROVED'      => 'Approuvée',
	'ACP_INMEMORIUM_ST_REFUSED'       => 'Refusée',
	'ACP_INMEMORIUM_ST_CANCELLED'     => 'Annulée',
	'ACP_INMEMORIUM_LEGACY_ENABLE'         => 'Autoriser la désignation d’un légataire',
	'ACP_INMEMORIUM_LEGACY_ENABLE_EXPLAIN' => 'Affiche l’onglet correspondant dans le panneau de l’utilisateur et active les pages publiques.',
	'ACP_INMEMORIUM_EXPIRE'                => 'Validité d’une demande (jours)',
	'ACP_INMEMORIUM_EXPIRE_EXPLAIN'        => 'Au-delà de ce délai, le code de sécurité devient inutilisable.',
	'ACP_INMEMORIUM_MAX_ATTEMPTS'          => 'Tentatives autorisées',
	'ACP_INMEMORIUM_MAX_ATTEMPTS_EXPLAIN'  => 'Nombre d’essais sur le code avant blocage de la demande.',
	'ACP_INMEMORIUM_CT_EXPLAIN'     => 'Liste des personnes légataires désignées par les membres depuis leur panneau personnel. Ces désignations sont faites par les membres eux-mêmes ; vous pouvez les consulter et les retirer, mais pas les créer à leur place.',
	'ACP_INMEMORIUM_CT_LIST'        => 'Désignations enregistrées (%d)',
	'ACP_INMEMORIUM_CT_NAME'        => 'Personne désignée',
	'ACP_INMEMORIUM_CT_EMAIL'       => 'Adresse de courriel',
	'ACP_INMEMORIUM_CT_DATE'        => 'Désignée le',
	'ACP_INMEMORIUM_CT_NONE'        => 'Aucune désignation enregistrée.',
	'ACP_INMEMORIUM_CT_IS_DECEASED' => 'Membre déjà commémoré',
	'ACP_INMEMORIUM_CT_DELETED'     => 'La désignation a été supprimée.',
	'ACP_INMEMORIUM_CT_CONFIRM'     => 'Supprimer cette désignation ? Le membre devra en enregistrer une nouvelle lui-même.',
	'ACP_INMEMORIUM_CT_PRIVACY'     => 'Ces informations relèvent de la vie privée des membres. Ne les communiquez qu’aux personnes habilitées, et supprimez les désignations devenues sans objet.',
	'ACP_INMEMORIUM_GROUP'                 => 'Groupe « InMemoriam »',
	'ACP_INMEMORIUM_GROUP_SYNC'            => 'Alimenter le groupe automatiquement',
	'ACP_INMEMORIUM_GROUP_SYNC_EXPLAIN'    => 'Les membres commémorés rejoignent le groupe « InMemoriam » et en sortent lorsque leur bandeau est retiré.',
	'ACP_INMEMORIUM_NOTIFY_LEGACY'         => 'Prévenir la personne légataire',
	'ACP_INMEMORIUM_NOTIFY_LEGACY_EXPLAIN' => 'Envoie un courriel à la personne désignée pour l’informer et lui transmettre l’adresse du formulaire.',
	'ACP_INMEMORIUM_NOTIFY_ADMIN'         => 'Prévenir l’administration',
	'ACP_INMEMORIUM_NOTIFY_ADMIN_EXPLAIN' => 'Envoie un courriel à l’adresse de contact du forum dès qu’une demande attend une décision. La clé de référence n’y figure pas : elle doit vous être communiquée par la personne légataire.',
	'ACP_INMEMORIUM_NOTIFY_PM'         => 'Prévenir aussi par message privé',
	'ACP_INMEMORIUM_NOTIFY_PM_EXPLAIN' => 'Envoie un message privé aux fondateurs et aux membres du groupe des administrateurs. Plus fiable qu’un courriel unique : le message reste visible dans le forum jusqu’à sa lecture.',
]);
