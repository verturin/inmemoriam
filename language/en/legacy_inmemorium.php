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
	'INMEMORIUM_LG_REQUEST_TITLE'      => 'Account deletion request',
	'INMEMORIUM_LG_REQUEST_EXPLAIN'    => 'This form is reserved for people designated as legacy contacts by a board member. If the member did designate you, a security code will be emailed to you.',
	'INMEMORIUM_LG_MEMBER'             => 'Member username',
	'INMEMORIUM_LG_MEMBER_EXPLAIN'     => 'The name under which the member is registered on this board.',
	'INMEMORIUM_LG_YOUR_EMAIL'         => 'Your email address',
	'INMEMORIUM_LG_YOUR_EMAIL_EXPLAIN' => 'The address the member registered for you.',
	'INMEMORIUM_LG_PRIVACY_NOTICE'     => 'For security reasons, this form always returns the same response, whether the request succeeds or not. This avoids revealing whether a member has designated a legacy contact.',
	'INMEMORIUM_LG_SENT_TITLE'         => 'Request registered',
	'INMEMORIUM_LG_SENT_BODY'          => 'If the details entered match a registered designation, an email containing the security code has just been sent. Please also check your spam folder.',
	'INMEMORIUM_LG_DISABLED'           => 'This feature is disabled on this board.',

	// Validation page
	'INMEMORIUM_LG_VALIDATE_TITLE'   => 'Security code validation',
	'INMEMORIUM_LG_VALIDATE_EXPLAIN' => 'Enter the security code you received by email. This code is strictly personal.',
	'INMEMORIUM_LG_CODE'             => 'Security code',
	'INMEMORIUM_LG_CODE_EXPLAIN'     => 'Four groups of five characters, separated by hyphens.',
	'INMEMORIUM_LG_VALIDATE_BTN'     => 'Validate code',
	'INMEMORIUM_LG_BAD_TOKEN'        => 'This validation link is invalid or has expired.',
	'INMEMORIUM_LG_BAD_CODE'         => 'The code entered is incorrect.',
	'INMEMORIUM_LG_EXPIRED'          => 'This request has expired. You will need to submit a new one.',
	'INMEMORIUM_LG_LOCKED'           => 'Too many failed attempts. This request is locked: please contact a board administrator.',
	'INMEMORIUM_LG_CLOSED'           => 'This request has already been processed.',

	// Outcome
	'INMEMORIUM_LG_OK_TITLE'          => 'Code validated',
	'INMEMORIUM_LG_OK_BODY'           => 'Your identity has been confirmed. The request is now submitted to a board administrator.',
	'INMEMORIUM_LG_ADMIN_KEY'         => 'Reference key',
	'INMEMORIUM_LG_ADMIN_KEY_EXPLAIN' => 'Keep this key. The administrator will compare it with the one shown on the member record before proceeding with the deletion. Only disclose it to a board administrator.',
	'INMEMORIUM_LG_SHEET_TITLE'     => 'Validation sheet',
	'INMEMORIUM_LG_SHEET_MEMBER'    => 'Account concerned: %s',
	'INMEMORIUM_LG_SHEET_DATE'      => 'Code validated on %s',
	'INMEMORIUM_LG_QR_ALT'          => 'QR code leading to this validation page',
	'INMEMORIUM_LG_QR_CAPTION'      => 'Scan to reopen this page.',
	'INMEMORIUM_LG_CONTINUE_MOBILE' => 'Prefer to continue on your phone? Scan this code.',
	'INMEMORIUM_LG_PRINT'           => 'Print this sheet',
	'INMEMORIUM_LG_PRINT_EXPLAIN'   => 'In the print dialog, choose "Save as PDF" to keep this sheet.',
	'INMEMORIUM_PM_SUBJECT' => 'Account deletion request awaiting decision',
	'INMEMORIUM_PM_BODY'    => "A legacy contact has just validated their security code. An account deletion request is awaiting a decision.\n\n[b]Account concerned:[/b] %1\$s\n[b]Legacy contact:[/b] %2\$s\n[b]Validated on:[/b] %3\$s\n\nTo decide: %4\$s\nExtensions → In Memoriam → Deletion requests\n\nYou will need to enter the reference key that the legacy contact will give you. It is deliberately absent from this message: that is what makes it a second check.\n\nOnly approve the request once you have obtained that key through a channel you trust, and have satisfied yourself that the death is genuine.",
]);
