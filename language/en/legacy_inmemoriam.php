<?php
/**
 * In Memoriam extension for phpBB - English (legacy pages).
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
	// Request page
	'INMEMORIAM_LG_REQUEST_TITLE'      => 'Account deletion request',
	'INMEMORIAM_LG_REQUEST_EXPLAIN'    => 'This form is reserved for people designated as legacy contacts by a board member. If the member did designate you, a security code will be emailed to you.',
	'INMEMORIAM_LG_MEMBER'             => 'Member username',
	'INMEMORIAM_LG_MEMBER_EXPLAIN'     => 'The name under which the member is registered on this board.',
	'INMEMORIAM_LG_YOUR_EMAIL'         => 'Your email address',
	'INMEMORIAM_LG_YOUR_EMAIL_EXPLAIN' => 'The address the member registered for you.',
	'INMEMORIAM_LG_PRIVACY_NOTICE'     => 'For security reasons, this form always returns the same response, whether the request succeeds or not. This avoids revealing whether a member has designated a legacy contact.',
	'INMEMORIAM_LG_SENT_TITLE'         => 'Request registered',
	'INMEMORIAM_LG_SENT_BODY'          => 'If the details entered match a registered designation, an email containing the security code has just been sent. Please also check your spam folder.',
	'INMEMORIAM_LG_DISABLED'           => 'This feature is disabled on this board.',

	// Validation page
	'INMEMORIAM_LG_VALIDATE_TITLE'   => 'Security code validation',
	'INMEMORIAM_LG_VALIDATE_EXPLAIN' => 'Enter the security code you received by email. This code is strictly personal.',
	'INMEMORIAM_LG_CODE'             => 'Security code',
	'INMEMORIAM_LG_CODE_EXPLAIN'     => 'Four groups of five characters, separated by hyphens.',
	'INMEMORIAM_LG_VALIDATE_BTN'     => 'Validate code',
	'INMEMORIAM_LG_BAD_TOKEN'        => 'This validation link is invalid or has expired.',
	'INMEMORIAM_LG_BAD_CODE'         => 'The code entered is incorrect.',
	'INMEMORIAM_LG_EXPIRED'          => 'This request has expired. You will need to submit a new one.',
	'INMEMORIAM_LG_LOCKED'           => 'Too many failed attempts. This request is locked: please contact a board administrator.',
	'INMEMORIAM_LG_CLOSED'           => 'This request has already been processed.',

	// Outcome
	'INMEMORIAM_LG_OK_TITLE'          => 'Code validated',
	'INMEMORIAM_LG_OK_BODY'           => 'Your identity has been confirmed. The request is now submitted to a board administrator.',
	'INMEMORIAM_LG_ADMIN_KEY'         => 'Reference key',
	'INMEMORIAM_LG_ADMIN_KEY_EXPLAIN' => 'Keep this key. The administrator will compare it with the one shown on the member record before proceeding with the deletion. Only disclose it to a board administrator.',
	'INMEMORIAM_LG_SHEET_TITLE'     => 'Validation sheet',
	'INMEMORIAM_LG_SHEET_MEMBER'    => 'Account concerned: %s',
	'INMEMORIAM_LG_SHEET_DATE'      => 'Code validated on %s',
	'INMEMORIAM_LG_QR_ALT'          => 'QR code leading to this validation page',
	'INMEMORIAM_LG_QR_CAPTION'      => 'Scan to reopen this page.',
	'INMEMORIAM_LG_CONTINUE_MOBILE' => 'Prefer to continue on your phone? Scan this code.',
	'INMEMORIAM_LG_PRINT'           => 'Print this sheet',
	'INMEMORIAM_LG_PRINT_EXPLAIN'   => 'In the print dialog, choose "Save as PDF" to keep this sheet.',
	'INMEMORIAM_LG_ACTIVATION'         => 'Activation code',
	'INMEMORIAM_LG_ACTIVATION_EXPLAIN' => 'The code from the email you received when you were designated. It was sent to you only once.',
	'INMEMORIAM_PM_STARTED_SUBJECT' => 'Legacy procedure started',
	'INMEMORIAM_PM_STARTED_BODY'    => "A legacy contact has just requested the deletion of an account. A security code has been emailed to them.\n\n[b]Account concerned:[/b] %1\$s\n[b]Legacy contact:[/b] %2\$s\n[b]Request submitted on:[/b] %3\$s\n\nNo action is required from you at this stage. You will be notified again once that person has entered their code, and that is when you will be able to decide.\n\nRequest overview: %4\$s\nExtensions → In Memoriam → Deletion requests\n\nIf this request looks suspicious to you, you can refuse it from that screen.",
	'INMEMORIAM_PM_PENDING_SUBJECT' => 'Account deletion request awaiting decision',
	'INMEMORIAM_PM_PENDING_BODY'    => "A legacy contact has just validated their security code. An account deletion request is awaiting a decision.\n\n[b]Account concerned:[/b] %1\$s\n[b]Legacy contact:[/b] %2\$s\n[b]Validated on:[/b] %3\$s\n\nTo decide: %4\$s\nExtensions → In Memoriam → Deletion requests\n\nYou will need to enter the reference key that the legacy contact will give you. It is deliberately absent from this message: that is what makes it a second check.\n\nOnly approve the request once you have obtained that key through a channel you trust, and have satisfied yourself that the death is genuine.",
]);
