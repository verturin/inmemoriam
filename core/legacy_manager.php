<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\core;

if (!defined('IN_PHPBB'))
{
	exit;
}

/**
 * Regroupe la logique metier du dispositif legataire :
 * generation et verification des deux codes, cycle de vie des demandes.
 */
class legacy_manager
{
	/** @var \phpbb\config\config */
	protected $config;

	/** @var \phpbb\db\driver\driver_interface */
	protected $db;

	/** @var \phpbb\user */
	protected $user;

	/** @var string */
	protected $table_legacy;

	/** @var string */
	protected $table_request;

	/** @var string */
	protected $table_logs;

	public function __construct(
		\phpbb\config\config $config,
		\phpbb\db\driver\driver_interface $db,
		\phpbb\user $user,
		$table_prefix
	)
	{
		$this->config        = $config;
		$this->db            = $db;
		$this->user          = $user;
		$this->table_legacy  = $table_prefix . 'inmemorium_legacy';
		$this->table_request = $table_prefix . 'inmemorium_request';
		$this->table_logs    = $table_prefix . 'inmemorium_logs';
	}

	/**
	 * Legataire designe par un membre, ou false.
	 */
	public function get_legacy($user_id)
	{
		$sql = 'SELECT * FROM ' . $this->table_legacy . '
			WHERE user_id = ' . (int) $user_id;
		$result = $this->db->sql_query($sql);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row;
	}

	/**
	 * Enregistre ou met a jour le legataire d'un membre.
	 */
	public function set_legacy($user_id, $name, $email)
	{
		$data = [
			'user_id'      => (int) $user_id,
			'legacy_name'  => $name,
			'legacy_email' => $email,
			'legacy_time'  => time(),
		];

		$existing = $this->get_legacy($user_id);

		if ($existing)
		{
			$this->db->sql_query('UPDATE ' . $this->table_legacy . '
				SET ' . $this->db->sql_build_array('UPDATE', $data) . '
				WHERE legacy_id = ' . (int) $existing['legacy_id']);
		}
		else
		{
			$this->db->sql_query('INSERT INTO ' . $this->table_legacy . ' ' .
				$this->db->sql_build_array('INSERT', $data));
		}

		$this->log($user_id, 'LEGACY_SET', $user_id);
	}

	/**
	 * Supprime la designation d'un membre.
	 */
	public function delete_legacy($user_id)
	{
		$this->db->sql_query('DELETE FROM ' . $this->table_legacy . '
			WHERE user_id = ' . (int) $user_id);

		$this->log($user_id, 'LEGACY_REMOVED', $user_id);
	}

	/**
	 * Cree une demande de suppression et retourne le code en clair
	 * ainsi que le jeton d'acces. Le code n'est jamais stocke en clair.
	 *
	 * @return array{code: string, token: string, admin_key: string}
	 */
	public function create_request($user_id, $legacy_email)
	{
		// Une seule demande active a la fois : les precedentes sont annulees.
		$this->db->sql_query('UPDATE ' . $this->table_request . "
			SET request_status = 'cancelled', closed_time = " . time() . '
			WHERE user_id = ' . (int) $user_id . "
			AND request_status IN ('sent', 'validated')");

		$code      = $this->generate_code();
		$token     = bin2hex(random_bytes(16));
		$admin_key = $this->generate_admin_key();
		$expire    = time() + ((int) $this->config['inmemorium_request_expire'] * 86400);

		$this->db->sql_query('INSERT INTO ' . $this->table_request . ' ' . $this->db->sql_build_array('INSERT', [
			'user_id'        => (int) $user_id,
			'legacy_email'   => $legacy_email,
			'code_hash'      => hash('sha256', $code),
			'qr_token'       => $token,
			'admin_key'      => $admin_key,
			'request_status' => 'sent',
			'attempts'       => 0,
			'request_time'   => time(),
			'expire_time'    => $expire,
			'request_ip'     => (string) $this->user->ip,
		]));

		$this->log($user_id, 'REQUEST_CREATED', 0);

		return ['code' => $code, 'token' => $token, 'admin_key' => $admin_key];
	}

	/**
	 * Demande active correspondant a un jeton, ou false.
	 */
	public function get_request_by_token($token)
	{
		$sql = 'SELECT * FROM ' . $this->table_request . "
			WHERE qr_token = '" . $this->db->sql_escape($token) . "'";
		$result = $this->db->sql_query($sql);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		return $row;
	}

	/**
	 * Verifie le code de securite saisi par le legataire.
	 *
	 * @return string 'ok' | 'expired' | 'locked' | 'closed' | 'invalid'
	 */
	public function verify_code($request, $code)
	{
		if (!in_array($request['request_status'], ['sent'], true))
		{
			return 'closed';
		}

		if ($request['expire_time'] > 0 && $request['expire_time'] < time())
		{
			return 'expired';
		}

		if ((int) $request['attempts'] >= (int) $this->config['inmemorium_max_attempts'])
		{
			return 'locked';
		}

		// Comparaison a temps constant : evite les attaques temporelles.
		if (!hash_equals($request['code_hash'], hash('sha256', $code)))
		{
			$this->db->sql_query('UPDATE ' . $this->table_request . '
				SET attempts = attempts + 1
				WHERE request_id = ' . (int) $request['request_id']);

			$this->log((int) $request['user_id'], 'CODE_FAILED', 0);

			return 'invalid';
		}

		$this->db->sql_query('UPDATE ' . $this->table_request . "
			SET request_status = 'validated', validated_time = " . time() . '
			WHERE request_id = ' . (int) $request['request_id']);

		$this->log((int) $request['user_id'], 'CODE_VALIDATED', 0);

		return 'ok';
	}

	/**
	 * Cloture d'une demande par l'administrateur.
	 *
	 * @param string $status 'approved' ou 'refused'
	 */
	public function close_request($request_id, $status, $admin_id)
	{
		$sql = 'SELECT user_id FROM ' . $this->table_request . '
			WHERE request_id = ' . (int) $request_id;
		$result = $this->db->sql_query($sql);
		$row    = $this->db->sql_fetchrow($result);
		$this->db->sql_freeresult($result);

		if (!$row)
		{
			return false;
		}

		$this->db->sql_query('UPDATE ' . $this->table_request . "
			SET request_status = '" . $this->db->sql_escape($status) . "', closed_time = " . time() . '
			WHERE request_id = ' . (int) $request_id);

		$this->log((int) $row['user_id'], $status === 'approved' ? 'REQUEST_APPROVED' : 'REQUEST_REFUSED', $admin_id);

		return (int) $row['user_id'];
	}

	/**
	 * Code de securite lisible : 4 groupes de 5 caracteres non ambigus.
	 */
	protected function generate_code()
	{
		$alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		$groups   = [];

		for ($g = 0; $g < 4; $g++)
		{
			$part = '';

			for ($i = 0; $i < 5; $i++)
			{
				$part .= $alphabet[random_int(0, strlen($alphabet) - 1)];
			}

			$groups[] = $part;
		}

		return implode('-', $groups);
	}

	/**
	 * Cle de reference administrateur : 4 groupes de 4 caracteres.
	 */
	protected function generate_admin_key()
	{
		$alphabet = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		$groups   = [];

		for ($g = 0; $g < 4; $g++)
		{
			$part = '';

			for ($i = 0; $i < 4; $i++)
			{
				$part .= $alphabet[random_int(0, strlen($alphabet) - 1)];
			}

			$groups[] = $part;
		}

		return implode('-', $groups);
	}

	/**
	 * Journalisation dans la table dediee de l'extension.
	 */
	public function log($user_id, $action, $performed_by, $details = '')
	{
		$this->db->sql_query('INSERT INTO ' . $this->table_logs . ' ' . $this->db->sql_build_array('INSERT', [
			'user_id'      => (int) $user_id,
			'log_action'   => $action,
			'performed_by' => (int) $performed_by,
			'log_ip'       => (string) $this->user->ip,
			'log_time'     => time(),
			'log_details'  => $details,
		]));
	}
}
