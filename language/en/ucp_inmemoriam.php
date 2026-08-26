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

	'UCP_INMEMORIAM_EXPLAIN' => 'You may designate a trusted person who will be allowed to request the deletion of your account after your passing. This person gains no rights over your account during your lifetime and can neither sign in to it nor modify it.',

	'UCP_INMEMORIAM_NAME'          => 'Name of the person',
	'UCP_INMEMORIAM_EMAIL'         => 'Email address',
	'UCP_INMEMORIAM_EMAIL_EXPLAIN' => 'The security code will be sent to this address. Please let this person know about your arrangement.',

	'UCP_INMEMORIAM_HOWTO_TITLE' => 'How the procedure works',
	'UCP_INMEMORIAM_HOWTO_1'     => 'The designated person fills in the public request form, giving your username and their email address.',
	'UCP_INMEMORIAM_HOWTO_2'     => 'A security code is emailed to them, together with a link and a QR code.',
	'UCP_INMEMORIAM_HOWTO_3'     => 'They enter this code on the validation page. A reference key is then shown to them.',
	'UCP_INMEMORIAM_HOWTO_4'     => 'An administrator confirms this reference key before the deletion is carried out.',

	'UCP_INMEMORIAM_CURRENT'        => 'A legacy contact has been registered since %s.',
	'UCP_INMEMORIAM_SAVED'          => 'The legacy contact has been saved.',
	'UCP_INMEMORIAM_DELETED'        => 'The designation has been removed.',
	'UCP_INMEMORIAM_DELETE'         => 'Remove designation',
	'UCP_INMEMORIAM_DELETE_CONFIRM' => 'Remove the designated legacy contact?',
	'UCP_INMEMORIAM_DISABLED'       => 'Designating a legacy contact is disabled on this board.',

	'UCP_INMEMORIAM_NAME_REQUIRED' => 'You must provide the name of the legacy contact.',
	'UCP_INMEMORIAM_EMAIL_SELF'    => 'The legacy contact address must differ from your own.',
	'UCP_INMEMORIAM_WISH'         => 'What becomes of your account',
	'UCP_INMEMORIAM_WISH_EXPLAIN' => 'State what you would like to happen to your account and posts once your passing is confirmed. This choice is yours alone and can be changed at any time.',
	'UCP_INMEMORIAM_WISH_CHOICE'  => 'Your wish',
	'UCP_INMEMORIAM_WISH_NOW'     => 'Delete everything immediately',
	'UCP_INMEMORIAM_WISH_DELAY'   => 'Delete everything after',
	'UCP_INMEMORIAM_WISH_BOARD'   => 'Keep the account, under the usual board rules',
	'UCP_INMEMORIAM_MONTHS'       => '%d months',
	'UCP_INMEMORIAM_WISH_PRIVACY' => 'This wish is visible only to you and to the board administrators. The legacy contact does not know it.',
	'UCP_INMEMORIAM_SEND_MAIL'         => 'Notify by email',
	'UCP_INMEMORIAM_SEND_MAIL_EXPLAIN' => 'Uncheck if you would rather hand the sheet over yourself. The activation code will then appear only on the printable sheet.',
	'UCP_INMEMORIAM_SEND_MAIL_YES'     => 'Send the designation email',
	'UCP_INMEMORIAM_SHEET_BTN'         => 'Print the legacy sheet',
	'UCP_INMEMORIAM_SHEET_TITLE'       => 'Legacy sheet',
	'UCP_INMEMORIAM_SHEET_ONCE'        => 'This code is shown only once',
	'UCP_INMEMORIAM_SHEET_ONCE_EXPLAIN'=> 'Print or save this sheet now. The code is not stored in plain form: requesting another sheet will produce a new code and invalidate this one.',
	'UCP_INMEMORIAM_SHEET_HEADING'     => 'Sheet to hand to the legacy contact',
	'UCP_INMEMORIAM_SHEET_INTRO'       => 'This sheet concerns an account registered on %s. Keep it somewhere safe: it will be needed when the time comes.',
	'UCP_INMEMORIAM_SHEET_FOR'         => 'Legacy contact',
	'UCP_INMEMORIAM_SHEET_MEMBER'      => 'Member concerned',
	'UCP_INMEMORIAM_SHEET_CODE'        => 'Activation code',
	'UCP_INMEMORIAM_SHEET_CODE_EXPLAIN'=> 'To be entered on the form, after scanning the code alongside.',
	'UCP_INMEMORIAM_SHEET_QR'          => 'Scan to open the form.',
	'UCP_INMEMORIAM_SHEET_QR_ALT'      => 'QR code leading to the request form',
	'UCP_INMEMORIAM_SHEET_STEPS'       => 'The procedure, when the time comes',
	'UCP_INMEMORIAM_SHEET_STEP1'       => 'Scan the QR code: the form opens, already filled in.',
	'UCP_INMEMORIAM_SHEET_STEP2'       => 'Enter the activation code above and submit.',
	'UCP_INMEMORIAM_SHEET_STEP3'       => 'A security code arrives by email; enter it on the page indicated.',
	'UCP_INMEMORIAM_SHEET_STEP4'       => 'Give the reference key then displayed to an administrator.',
	'UCP_INMEMORIAM_SHEET_PRINT'       => 'Print this sheet',
	'UCP_INMEMORIAM_SHEET_BACK'        => 'Back',
	'UCP_INMEMORIAM_SHEET_PDF'         => 'In the print dialog, choose "Save as PDF" to keep the sheet.',
]);
