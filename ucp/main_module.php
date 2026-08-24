<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\ucp;

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

		$manager = $phpbb_container->get('verturin.inmemorium.legacy_manager');
		$config  = $phpbb_container->get('config');
		$helper  = $phpbb_container->get('controller.helper');

		$language->add_lang('ucp_inmemorium', 'verturin/inmemorium');

		$this->tpl_name   = 'ucp_inmemorium_legacy';
		$this->page_title = $language->lang('UCP_INMEMORIUM_LEGACY');

		add_form_key('inmemorium_ucp');

		$user_id = (int) $user->data['user_id'];
		$errors  = [];

		if (empty($config['inmemorium_legacy_enabled']))
		{
			trigger_error($language->lang('UCP_INMEMORIUM_DISABLED'));
		}

		if ($request->is_set_post('submit') || $request->is_set_post('delete'))
		{
			if (!check_form_key('inmemorium_ucp'))
			{
				$errors[] = $language->lang('FORM_INVALID');
			}

			if (empty($errors) && $request->is_set_post('delete'))
			{
				$manager->delete_legacy($user_id);
				meta_refresh(3, $this->u_action);
				trigger_error($language->lang('UCP_INMEMORIUM_DELETED') . '<br><br>' .
					$language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'));
			}

			if (empty($errors))
			{
				$name  = $request->variable('legacy_name', '', true);
				$email = strtolower(trim($request->variable('legacy_email', '')));

				if (utf8_clean_string($name) === '')
				{
					$errors[] = $language->lang('UCP_INMEMORIUM_NAME_REQUIRED');
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
					$errors[] = $language->lang('UCP_INMEMORIUM_EMAIL_SELF');
				}

				if (empty($errors))
				{
					$previous = $manager->get_legacy($user_id);
					$manager->set_legacy($user_id, $name, $email);

					// Prevenir la personne designee, sauf si rien n'a change :
					// on evite de la relancer a chaque enregistrement.
					$is_new = !$previous || strtolower($previous['legacy_email']) !== $email;

					if ($is_new && !empty($config['inmemorium_notify_legacy']))
					{
						$this->notify_legacy($helper, $config, $user, $name, $email);
					}

					meta_refresh(3, $this->u_action);
					trigger_error($language->lang('UCP_INMEMORIUM_SAVED') . '<br><br>' .
						$language->lang('RETURN_UCP', '<a href="' . $this->u_action . '">', '</a>'));
				}
			}
		}

		$legacy = $manager->get_legacy($user_id);

		$template->assign_vars([
			'ERROR'        => !empty($errors) ? implode('<br>', $errors) : '',
			'LEGACY_NAME'  => $legacy ? $legacy['legacy_name'] : '',
			'LEGACY_EMAIL' => $legacy ? $legacy['legacy_email'] : '',
			'S_HAS_LEGACY' => (bool) $legacy,
			'LEGACY_DATE'  => $legacy ? $user->format_date($legacy['legacy_time']) : '',
			'S_UCP_ACTION' => $this->u_action,
		]);
	}

	/**
	 * Informe la personne designee, et lui transmet l'adresse du formulaire
	 * qu'elle devra utiliser le moment venu.
	 */
	protected function notify_legacy($helper, $config, $user, $name, $email)
	{
		global $phpbb_root_path, $phpEx;

		if (!class_exists('messenger'))
		{
			include $phpbb_root_path . 'includes/functions_messenger.' . $phpEx;
		}

		$request_url = generate_board_url() . '/' . ltrim(
			$helper->route('inmemorium_legacy_request', [], false),
			'/'
		);

		$messenger = new \messenger(false);
		$messenger->template('@verturin_inmemorium/legacy_designated', $config['default_lang']);
		$messenger->to($email, $name);
		$messenger->anti_abuse_headers($config, $user);
		$messenger->assign_vars([
			'LEGACY_NAME' => htmlspecialchars_decode($name),
			'MEMBER_NAME' => htmlspecialchars_decode($user->data['username']),
			'REQUEST_URL' => $request_url,
		]);
		$messenger->send(NOTIFY_EMAIL);
	}
}
