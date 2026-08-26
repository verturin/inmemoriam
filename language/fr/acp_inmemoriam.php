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

	'ACP_INMEMORIAM_DECEASED_EXPLAIN' => 'Ajoutez ici les membres pour lesquels un bandeau commémoratif doit être affiché sur leur profil et leurs messages.',
	'ACP_INMEMORIAM_MARK_DECEASED'    => 'Ajouter un membre',
	'ACP_INMEMORIAM_LIST'             => 'Membres commémorés',

	'ACP_INMEMORIAM_USERNAME'              => 'Nom d’utilisateur',
	'ACP_INMEMORIAM_USERNAME_EXPLAIN'      => 'Le membre concerné. Si une fiche existe déjà, elle sera mise à jour.',
	'ACP_INMEMORIAM_DEATH_DATE'            => 'Date de disparition',
	'ACP_INMEMORIAM_DEATH_DATE_EXPLAIN'    => 'Facultatif. Laissez vide pour ne rien afficher.',
	'ACP_INMEMORIAM_MEMORIAL_TEXT'         => 'Texte commémoratif',
	'ACP_INMEMORIAM_MEMORIAL_TEXT_EXPLAIN' => 'Facultatif. Un texte par défaut est utilisé si ce champ reste vide.',
	'ACP_INMEMORIAM_BANNER_COLOR'          => 'Couleur du bandeau',
	'ACP_INMEMORIAM_BANNER_COLOR_EXPLAIN'  => 'Couleur de fond du bandeau affiché sur le profil.',
	'ACP_INMEMORIAM_ACTIONS'               => 'Actions',
	'ACP_INMEMORIAM_REMOVE'                => 'Retirer',

	'ACP_INMEMORIAM_SETTINGS_EXPLAIN'          => 'Configuration générale de l’extension In Memoriam.',
	'ACP_INMEMORIAM_ENABLE'                    => 'Activer l’affichage',
	'ACP_INMEMORIAM_ENABLE_EXPLAIN'            => 'Désactive l’affichage des bandeaux sans désinstaller l’extension.',
	'ACP_INMEMORIAM_DEFAULT_COLOR'             => 'Couleur par défaut',
	'ACP_INMEMORIAM_DEFAULT_COLOR_EXPLAIN'     => 'Couleur proposée par défaut lors de l’ajout d’un membre.',
	'ACP_INMEMORIAM_SHOW_DEATH_DATE'           => 'Afficher la date',
	'ACP_INMEMORIAM_SHOW_DEATH_DATE_EXPLAIN'   => 'Affiche la date de disparition sur le bandeau du profil.',
	'ACP_INMEMORIAM_SHOW_BADGE'                => 'Afficher le badge',
	'ACP_INMEMORIAM_SHOW_BADGE_EXPLAIN'        => 'Affiche une mention « In Memoriam » sous l’auteur de chaque message.',

	'ACP_INMEMORIAM_SAVED'          => 'Le membre a été enregistré.',
	'ACP_INMEMORIAM_REMOVED'        => 'Le bandeau a été retiré.',
	'ACP_INMEMORIAM_SETTINGS_SAVED' => 'Les réglages ont été enregistrés.',
	'ACP_INMEMORIAM_CONFIRM_REMOVE' => 'Êtes-vous sûr de vouloir retirer ce bandeau commémoratif ?',
	'ACP_INMEMORIAM_NO_DECEASED'    => 'Aucun membre commémoré pour le moment.',
	'ACP_INMEMORIAM_NO_USER'        => 'Le membre « %s » est introuvable.',
	'ACP_INMEMORIAM_REQUESTS_EXPLAIN' => 'Demandes soumises par les personnes légataires. Une demande n’apparaît comme « en attente » qu’après validation du code de sécurité par la personne légataire. Comparez la clé de référence qu’elle vous communique avec celle attendue avant d’approuver.',
	'ACP_INMEMORIAM_RQ_EMAIL'         => 'Courriel de la personne légataire',
	'ACP_INMEMORIAM_RQ_DATE'          => 'Date de la demande',
	'ACP_INMEMORIAM_RQ_ATTEMPTS'      => 'Tentatives de saisie du code',
	'ACP_INMEMORIAM_RQ_KEY'           => 'Clé de référence',
	'ACP_INMEMORIAM_RQ_KEY_EXPLAIN'   => 'Saisissez la clé communiquée par la personne légataire. Elle doit correspondre exactement.',
	'ACP_INMEMORIAM_RQ_APPROVE'       => 'Approuver',
	'ACP_INMEMORIAM_RQ_REFUSE'        => 'Refuser',
	'ACP_INMEMORIAM_RQ_NONE'          => 'Aucune demande enregistrée.',
	'ACP_INMEMORIAM_RQ_BAD_KEY'       => 'La clé de référence saisie ne correspond pas.',
	'ACP_INMEMORIAM_RQ_NOT_PENDING'   => 'Cette demande n’est pas en attente de décision.',
	'ACP_INMEMORIAM_RQ_APPROVED'      => 'La demande a été approuvée.',
	'ACP_INMEMORIAM_RQ_REFUSED'       => 'La demande a été refusée.',
	'ACP_INMEMORIAM_ST_SENT'          => 'Code envoyé',
	'ACP_INMEMORIAM_ST_VALIDATED'     => 'En attente de décision',
	'ACP_INMEMORIAM_ST_APPROVED'      => 'Approuvée',
	'ACP_INMEMORIAM_ST_REFUSED'       => 'Refusée',
	'ACP_INMEMORIAM_ST_CANCELLED'     => 'Annulée',
	'ACP_INMEMORIAM_LEGACY_ENABLE'         => 'Autoriser la désignation d’un légataire',
	'ACP_INMEMORIAM_LEGACY_ENABLE_EXPLAIN' => 'Affiche l’onglet correspondant dans le panneau de l’utilisateur et active les pages publiques.',
	'ACP_INMEMORIAM_EXPIRE'                => 'Validité d’une demande (jours)',
	'ACP_INMEMORIAM_EXPIRE_EXPLAIN'        => 'Au-delà de ce délai, le code de sécurité devient inutilisable.',
	'ACP_INMEMORIAM_MAX_ATTEMPTS'          => 'Tentatives autorisées',
	'ACP_INMEMORIAM_MAX_ATTEMPTS_EXPLAIN'  => 'Nombre d’essais sur le code avant blocage de la demande.',
	'ACP_INMEMORIAM_CT_EXPLAIN'     => 'Liste des personnes légataires désignées par les membres depuis leur panneau personnel. Ces désignations sont faites par les membres eux-mêmes ; vous pouvez les consulter et les retirer, mais pas les créer à leur place.',
	'ACP_INMEMORIAM_CT_LIST'        => 'Désignations enregistrées (%d)',
	'ACP_INMEMORIAM_CT_NAME'        => 'Personne désignée',
	'ACP_INMEMORIAM_CT_EMAIL'       => 'Adresse de courriel',
	'ACP_INMEMORIAM_CT_DATE'        => 'Désignée le',
	'ACP_INMEMORIAM_CT_NONE'        => 'Aucune désignation enregistrée.',
	'ACP_INMEMORIAM_CT_IS_DECEASED' => 'Membre déjà commémoré',
	'ACP_INMEMORIAM_CT_DELETED'     => 'La désignation a été supprimée.',
	'ACP_INMEMORIAM_CT_CONFIRM'     => 'Supprimer cette désignation ? Le membre devra en enregistrer une nouvelle lui-même.',
	'ACP_INMEMORIAM_CT_PRIVACY'     => 'Ces informations relèvent de la vie privée des membres. Ne les communiquez qu’aux personnes habilitées, et supprimez les désignations devenues sans objet.',
	'ACP_INMEMORIAM_GROUP'                 => 'Groupe « InMemoriam »',
	'ACP_INMEMORIAM_GROUP_SYNC'            => 'Alimenter le groupe automatiquement',
	'ACP_INMEMORIAM_GROUP_SYNC_EXPLAIN'    => 'Les membres commémorés rejoignent le groupe « InMemoriam » et en sortent lorsque leur bandeau est retiré.',
	'ACP_INMEMORIAM_NOTIFY_LEGACY'         => 'Prévenir la personne légataire',
	'ACP_INMEMORIAM_NOTIFY_LEGACY_EXPLAIN' => 'Envoie un courriel à la personne désignée pour l’informer et lui transmettre l’adresse du formulaire.',
	'ACP_INMEMORIAM_NOTIFY_ADMIN'         => 'Prévenir l’administration',
	'ACP_INMEMORIAM_NOTIFY_ADMIN_EXPLAIN' => 'Envoie un courriel à l’adresse de contact du forum dès qu’une demande attend une décision. La clé de référence n’y figure pas : elle doit vous être communiquée par la personne légataire.',
	'ACP_INMEMORIAM_NOTIFY_PM'         => 'Prévenir aussi par message privé',
	'ACP_INMEMORIAM_NOTIFY_PM_EXPLAIN' => 'Envoie un message privé aux fondateurs et aux membres du groupe des administrateurs. Plus fiable qu’un courriel unique : le message reste visible dans le forum jusqu’à sa lecture.',
	'ACP_INMEMORIAM_CT_WISH' => 'Volonté du membre',
	'ACP_INMEMORIAM_ANON'               => 'Discrétion',
	'ACP_INMEMORIAM_ANON_SITE'          => 'Masquer le nom du forum',
	'ACP_INMEMORIAM_ANON_SITE_EXPLAIN'  => 'La personne légataire est extérieure au forum et n’a pas nécessairement à savoir de quel site il s’agit. Le nom est alors remplacé dans les courriels et sur la fiche.',
	'ACP_INMEMORIAM_ANON_LABEL'         => 'Libellé de remplacement',
	'ACP_INMEMORIAM_ANON_LABEL_EXPLAIN' => 'Laissez vide pour utiliser « un forum en ligne ». Attention : l’adresse d’expédition et la signature des courriels du forum restent visibles, la discrétion n’est donc pas totale.',
]);
