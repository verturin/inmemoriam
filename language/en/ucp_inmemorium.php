<?php
/**
 * In Memoriam extension for phpBB - English (UCP).
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

	'UCP_INMEMORIUM_EXPLAIN' => 'You may designate a trusted person who will be allowed to request the deletion of your account after your passing. This person gains no rights over your account during your lifetime and can neither sign in to it nor modify it.',

	'UCP_INMEMORIUM_NAME'          => 'Name of the person',
	'UCP_INMEMORIUM_EMAIL'         => 'Email address',
	'UCP_INMEMORIUM_EMAIL_EXPLAIN' => 'The security code will be sent to this address. Please let this person know about your arrangement.',

	'UCP_INMEMORIUM_HOWTO_TITLE' => 'How the procedure works',
	'UCP_INMEMORIUM_HOWTO_1'     => 'The designated person fills in the public request form, giving your username and their email address.',
	'UCP_INMEMORIUM_HOWTO_2'     => 'A security code is emailed to them, together with a link and a QR code.',
	'UCP_INMEMORIUM_HOWTO_3'     => 'They enter this code on the validation page. A reference key is then shown to them.',
	'UCP_INMEMORIUM_HOWTO_4'     => 'An administrator confirms this reference key before the deletion is carried out.',

	'UCP_INMEMORIUM_CURRENT'        => 'A legacy contact has been registered since %s.',
	'UCP_INMEMORIUM_SAVED'          => 'The legacy contact has been saved.',
	'UCP_INMEMORIUM_DELETED'        => 'The designation has been removed.',
	'UCP_INMEMORIUM_DELETE'         => 'Remove designation',
	'UCP_INMEMORIUM_DELETE_CONFIRM' => 'Remove the designated legacy contact?',
	'UCP_INMEMORIUM_DISABLED'       => 'Designating a legacy contact is disabled on this board.',

	'UCP_INMEMORIUM_NAME_REQUIRED' => 'You must provide the name of the legacy contact.',
	'UCP_INMEMORIUM_EMAIL_SELF'    => 'The legacy contact address must differ from your own.',
]);
