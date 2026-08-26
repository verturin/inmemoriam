<?php
/**
 * In Memoriam extension for phpBB - English (ACP).
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

	'ACP_INMEMORIAM_DECEASED_EXPLAIN' => 'Add here the members for whom a memorial banner should be displayed on their profile and posts.',
	'ACP_INMEMORIAM_MARK_DECEASED'    => 'Add a member',
	'ACP_INMEMORIAM_LIST'             => 'Memorialised members',

	'ACP_INMEMORIAM_USERNAME'              => 'Username',
	'ACP_INMEMORIAM_USERNAME_EXPLAIN'      => 'The member concerned. An existing entry will be updated.',
	'ACP_INMEMORIAM_DEATH_DATE'            => 'Date of passing',
	'ACP_INMEMORIAM_DEATH_DATE_EXPLAIN'    => 'Optional. Leave empty to display nothing.',
	'ACP_INMEMORIAM_MEMORIAL_TEXT'         => 'Memorial text',
	'ACP_INMEMORIAM_MEMORIAL_TEXT_EXPLAIN' => 'Optional. A default text is used if left empty.',
	'ACP_INMEMORIAM_BANNER_COLOR'          => 'Banner colour',
	'ACP_INMEMORIAM_BANNER_COLOR_EXPLAIN'  => 'Background colour of the banner shown on the profile.',
	'ACP_INMEMORIAM_ACTIONS'               => 'Actions',
	'ACP_INMEMORIAM_REMOVE'                => 'Remove',

	'ACP_INMEMORIAM_SETTINGS_EXPLAIN'        => 'General configuration of the In Memoriam extension.',
	'ACP_INMEMORIAM_ENABLE'                  => 'Enable display',
	'ACP_INMEMORIAM_ENABLE_EXPLAIN'          => 'Turns off banner display without uninstalling the extension.',
	'ACP_INMEMORIAM_DEFAULT_COLOR'           => 'Default colour',
	'ACP_INMEMORIAM_DEFAULT_COLOR_EXPLAIN'   => 'Colour pre-filled when adding a member.',
	'ACP_INMEMORIAM_SHOW_DEATH_DATE'         => 'Show date',
	'ACP_INMEMORIAM_SHOW_DEATH_DATE_EXPLAIN' => 'Shows the date of passing on the profile banner.',
	'ACP_INMEMORIAM_SHOW_BADGE'              => 'Show badge',
	'ACP_INMEMORIAM_SHOW_BADGE_EXPLAIN'      => 'Shows an "In Memoriam" note under the author of each post.',

	'ACP_INMEMORIAM_SAVED'          => 'The member has been saved.',
	'ACP_INMEMORIAM_REMOVED'        => 'The banner has been removed.',
	'ACP_INMEMORIAM_SETTINGS_SAVED' => 'Settings have been saved.',
	'ACP_INMEMORIAM_CONFIRM_REMOVE' => 'Are you sure you want to remove this memorial banner?',
	'ACP_INMEMORIAM_NO_DECEASED'    => 'No memorialised member yet.',
	'ACP_INMEMORIAM_NO_USER'        => 'The member "%s" could not be found.',
	'ACP_INMEMORIAM_REQUESTS_EXPLAIN' => 'Requests submitted by legacy contacts. A request only appears as "awaiting decision" once the legacy contact has validated the security code. Compare the reference key they give you with the expected one before approving.',
	'ACP_INMEMORIAM_RQ_EMAIL'         => 'Legacy contact email',
	'ACP_INMEMORIAM_RQ_DATE'          => 'Request date',
	'ACP_INMEMORIAM_RQ_ATTEMPTS'      => 'Code entry attempts',
	'ACP_INMEMORIAM_RQ_KEY'           => 'Reference key',
	'ACP_INMEMORIAM_RQ_KEY_EXPLAIN'   => 'Enter the key provided by the legacy contact. It must match exactly.',
	'ACP_INMEMORIAM_RQ_APPROVE'       => 'Approve',
	'ACP_INMEMORIAM_RQ_REFUSE'        => 'Refuse',
	'ACP_INMEMORIAM_RQ_NONE'          => 'No request recorded.',
	'ACP_INMEMORIAM_RQ_BAD_KEY'       => 'The reference key entered does not match.',
	'ACP_INMEMORIAM_RQ_NOT_PENDING'   => 'This request is not awaiting a decision.',
	'ACP_INMEMORIAM_RQ_APPROVED'      => 'The request has been approved.',
	'ACP_INMEMORIAM_RQ_REFUSED'       => 'The request has been refused.',
	'ACP_INMEMORIAM_ST_SENT'          => 'Code sent',
	'ACP_INMEMORIAM_ST_VALIDATED'     => 'Awaiting decision',
	'ACP_INMEMORIAM_ST_APPROVED'      => 'Approved',
	'ACP_INMEMORIAM_ST_REFUSED'       => 'Refused',
	'ACP_INMEMORIAM_ST_CANCELLED'     => 'Cancelled',
	'ACP_INMEMORIAM_LEGACY_ENABLE'         => 'Allow designating a legacy contact',
	'ACP_INMEMORIAM_LEGACY_ENABLE_EXPLAIN' => 'Shows the matching tab in the user control panel and enables the public pages.',
	'ACP_INMEMORIAM_EXPIRE'                => 'Request validity (days)',
	'ACP_INMEMORIAM_EXPIRE_EXPLAIN'        => 'Beyond this delay the security code becomes unusable.',
	'ACP_INMEMORIAM_MAX_ATTEMPTS'          => 'Allowed attempts',
	'ACP_INMEMORIAM_MAX_ATTEMPTS_EXPLAIN'  => 'Number of code attempts before the request is locked.',
	'ACP_INMEMORIAM_CT_EXPLAIN'     => 'List of legacy contacts designated by members from their own control panel. These designations are made by members themselves; you may review and remove them, but not create them on their behalf.',
	'ACP_INMEMORIAM_CT_LIST'        => 'Registered designations (%d)',
	'ACP_INMEMORIAM_CT_NAME'        => 'Designated person',
	'ACP_INMEMORIAM_CT_EMAIL'       => 'Email address',
	'ACP_INMEMORIAM_CT_DATE'        => 'Designated on',
	'ACP_INMEMORIAM_CT_NONE'        => 'No designation recorded.',
	'ACP_INMEMORIAM_CT_IS_DECEASED' => 'Already memorialised',
	'ACP_INMEMORIAM_CT_DELETED'     => 'The designation has been removed.',
	'ACP_INMEMORIAM_CT_CONFIRM'     => 'Remove this designation? The member will have to register a new one themselves.',
	'ACP_INMEMORIAM_CT_PRIVACY'     => 'This information is personal data. Share it only with authorised people, and remove designations that are no longer relevant.',
	'ACP_INMEMORIAM_GROUP'                 => '"InMemoriam" group',
	'ACP_INMEMORIAM_GROUP_SYNC'            => 'Populate the group automatically',
	'ACP_INMEMORIAM_GROUP_SYNC_EXPLAIN'    => 'Memorialised members join the "InMemoriam" group and leave it when their banner is removed.',
	'ACP_INMEMORIAM_NOTIFY_LEGACY'         => 'Notify the legacy contact',
	'ACP_INMEMORIAM_NOTIFY_LEGACY_EXPLAIN' => 'Sends an email to the designated person to inform them and provide the address of the form.',
	'ACP_INMEMORIAM_NOTIFY_ADMIN'         => 'Notify the administration',
	'ACP_INMEMORIAM_NOTIFY_ADMIN_EXPLAIN' => 'Sends an email to the board contact address as soon as a request awaits a decision. The reference key is not included: it must be given to you by the legacy contact.',
	'ACP_INMEMORIAM_NOTIFY_PM'         => 'Also notify by private message',
	'ACP_INMEMORIAM_NOTIFY_PM_EXPLAIN' => 'Sends a private message to founders and members of the administrators group. More reliable than a single email: the message stays visible on the board until read.',
	'ACP_INMEMORIAM_CT_WISH' => 'Member’s wish',
	'ACP_INMEMORIAM_ANON'               => 'Discretion',
	'ACP_INMEMORIAM_ANON_SITE'          => 'Hide the board name',
	'ACP_INMEMORIAM_ANON_SITE_EXPLAIN'  => 'The legacy contact is outside the board and does not necessarily need to know which site it is. The name is then replaced in emails and on the sheet.',
	'ACP_INMEMORIAM_ANON_LABEL'         => 'Replacement label',
	'ACP_INMEMORIAM_ANON_LABEL_EXPLAIN' => 'Leave empty to use "an online board". Note: the sender address and the board email signature remain visible, so discretion is not complete.',
]);
