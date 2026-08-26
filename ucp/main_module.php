<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemoriam\ucp;

if (!defined('IN_PHPBB'))
{
	exit;
}

class main_module
{
	public $u_action;
	public $tpl_name;
	public $page_title;

	public function main($id, $mode)
	{
		global $phpbb_container, $language, $template, $request, $user;

		$manager = $phpbb_container->get('verturin.inmemoriam.legacy_manager');
		$config  = $phpbb_container->get('config');
		$helper  = $phpbb_container->get('controller.helper');

		$language->add_lang('ucp_inmemoriam', 'verturin/inmemoriam');

		$this->tpl_name   = 'ucp_inmemoriam_legacy';
		$this->page_title = $language->lang('UCP_INMEMORIAM_LEGACY');

		add_form_key('inmemoriam_ucp');

		$user_id = (int) $user->data['user_id'];
		$errors  = [];

		if (empty($config['inmemoriam_legacy_enabled']))
		{
			trigger_error($language->lang('UCP_INMEMORIAM_DISABLED'));
		}

		if ($request->is_set_post('submit') || $request->is_set_post('delete'))
		{
			if (!check_form_key('inmemoriam_ucp'))
			{
				$errors[] = $language->lang('FORM_INVALID');
			}

			if (empty($errors) && $request->is_set_post('delete'))
			{
				$manager->delete_legacy($user_id);
				meta_refresh(3, $this->u_action);
				trigger_error($language->lang('UCP_INMEMORIAM_DELETED') . '<br><br>' .
					$language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'));
			}

			if (empty($errors))
			{
				$name  = $request->variable('legacy_name', '', true);
				$email = strtolower(trim($request->variable('legacy_email', '')));

				if (utf8_clean_string($name) === '')
				{
					$errors[] = $language->lang('UCP_INMEMORIAM_NAME_REQUIRED');
				}

				if (!function_exists('validate_data'))
				{
					include $GLOBALS['phpbb_root_path'] . 'includes/functions_user.' . $GLOBALS['phpEx'];
				}

				// Validation du courriel par les regles natives de phpBB.
				$check = validate_data(['email' => $email], ['email' => [
					['string', false, 6, 100],
					['email'],
				]]);

				if (!empty($check))
				{
					foreach ($check as $error)
					{
						$errors[] = $language->lang($error);
					}
				}

				// Le legataire ne peut pas etre le membre lui-meme.
				if ($email === strtolower($user->data['user_email']))
				{
					$errors[] = $language->lang('UCP_INMEMORIAM_EMAIL_SELF');
				}

				if (empty($errors))
				{
					$mode   = $request->variable('deletion_mode', 'board');
					$months = $request->variable('deletion_months', 12);

					$code = $manager->set_legacy($user_id, $name, $email, $mode, $months);

					// Le membre peut preferer remettre la fiche lui-meme :
					// dans ce cas aucun courriel ne part, et le code sera
					// affiche sur la fiche a imprimer.
					$send_mail = $request->variable('send_mail', 0);

					if ($code !== '' && $send_mail && !empty($config['inmemoriam_notify_legacy']))
					{
						$this->notify_legacy($helper, $config, $user, $name, $email, $code, $manager, $language);
					}

					meta_refresh(3, $this->u_action);
					trigger_error($language->lang('UCP_INMEMORIAM_SAVED') . '<br><br>' .
						$language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'));
				}
			}
		}

		// Fiche a imprimer : un nouveau code d'activation est produit et
		// affiche une seule fois. En redemander une invalide la precedente.
		if ($request->variable('action', '') === 'sheet')
		{
			$sheet = $manager->issue_sheet($user_id);

			if ($sheet)
			{
				$row = $manager->get_legacy($user_id);

				$this->tpl_name = 'ucp_inmemoriam_sheet';

				$sheet_url = generate_board_url() . '/' . ltrim(
					$helper->route('inmemoriam_legacy_request', ['token' => $sheet['token']], false),
					'/'
				);

				$template->assign_vars([
					'MEMBER_NAME'     => $user->data['username'],
					'LEGACY_NAME'     => $row['legacy_name'],
					'LEGACY_EMAIL'    => $row['legacy_email'],
					'ACTIVATION_CODE' => $sheet['code'],
					'SHEET_URL'       => $sheet_url,
					'BOARD_LABEL'     => $manager->board_label($language),
					'U_BACK'          => $this->u_action,
				]);

				return;
			}
		}

		$legacy = $manager->get_legacy($user_id);

		$template->assign_vars([
			'ERROR'        => !empty($errors) ? implode('<br>', $errors) : '',
			'LEGACY_NAME'  => $legacy ? $legacy['legacy_name'] : '',
			'LEGACY_EMAIL' => $legacy ? $legacy['legacy_email'] : '',
			'DELETION_MODE'   => $legacy ? $legacy['deletion_mode'] : 'board',
			'DELETION_MONTHS' => $legacy ? (int) $legacy['deletion_months'] : 12,
			'U_SHEET'         => $this->u_action . '&amp;action=sheet',
			'S_HAS_LEGACY' => (bool) $legacy,
			'LEGACY_DATE'  => $legacy ? $user->format_date($legacy['legacy_time']) : '',
			'S_UCP_ACTION' => $this->u_action,
		]);
	}

	/**
	 * Informe la personne designee, et lui transmet l'adresse du formulaire
	 * qu'elle devra utiliser le moment venu.
	 */
	protected function notify_legacy($helper, $config, $user, $name, $email, $code, $manager, $language)
	{
		global $phpbb_root_path, $phpEx;

		if (!class_exists('messenger'))
		{
			include $phpbb_root_path . 'includes/functions_messenger.' . $phpEx;
		}

		$request_url = generate_board_url() . '/' . ltrim(
			$helper->route('inmemoriam_legacy_request', [], false),
			'/'
		);

		$messenger = new \messenger(false);
		$messenger->template('@verturin_inmemoriam/legacy_designated', $config['default_lang']);
		$messenger->to($email, $name);
		$messenger->anti_abuse_headers($config, $user);
		$messenger->assign_vars([
			'LEGACY_NAME' => htmlspecialchars_decode($name),
			'MEMBER_NAME' => htmlspecialchars_decode($user->data['username']),
			'REQUEST_URL'     => $request_url,
			'ACTIVATION_CODE' => $code,
			'BOARD_LABEL'     => $manager->board_label($language),
		]);
		$messenger->send(NOTIFY_EMAIL);
	}
}
