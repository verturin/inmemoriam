<?php
/**
 * In Memoriam extension for phpBB.
 *
 * @copyright (c) 2026 In Memoriam
 * @license GNU General Public License, version 2 (GPL-2.0)
 */

namespace verturin\inmemorium\migrations;

class install_legacy extends \phpbb\db\migration\migration
{
	public static function depends_on()
	{
		return ['\verturin\inmemorium\migrations\install_acp_module'];
	}

	public function effectively_installed()
	{
		return $this->db_tools->sql_table_exists($this->table_prefix . 'inmemorium_legacy');
	}

	public function update_schema()
	{
		return [
			'add_tables' => [
				// Legataire designe par le membre lui-meme (depuis son panneau).
				$this->table_prefix . 'inmemorium_legacy' => [
					'COLUMNS' => [
						'legacy_id'    => ['UINT', null, 'auto_increment'],
						'user_id'      => ['UINT', 0],
						'legacy_name'  => ['VCHAR:255', ''],
						'legacy_email' => ['VCHAR:100', ''],
						'legacy_time'  => ['TIMESTAMP', 0],
					],
					'PRIMARY_KEY' => 'legacy_id',
					'KEYS' => [
						'im_lg_user' => ['UNIQUE', 'user_id'],
					],
				],

				// Demande de suppression initiee par le legataire.
				$this->table_prefix . 'inmemorium_request' => [
					'COLUMNS' => [
						'request_id'     => ['UINT', null, 'auto_increment'],
						'user_id'        => ['UINT', 0],
						'legacy_email'   => ['VCHAR:100', ''],
						// Le code envoye par courriel n'est stocke que sous forme de condensat.
						'code_hash'      => ['CHAR:64', ''],
						'qr_token'       => ['CHAR:32', ''],
						// Cle de reference que l'administrateur verifie sur la fiche du membre.
						'admin_key'      => ['VCHAR:19', ''],
						'request_status' => ['VCHAR:12', 'sent'],
						'attempts'       => ['UINT:3', 0],
						'request_time'   => ['TIMESTAMP', 0],
						'expire_time'    => ['TIMESTAMP', 0],
						'validated_time' => ['TIMESTAMP', 0],
						'closed_time'    => ['TIMESTAMP', 0],
						'request_ip'     => ['VCHAR:40', ''],
					],
					'PRIMARY_KEY' => 'request_id',
					'KEYS' => [
						'im_rq_token'  => ['UNIQUE', 'qr_token'],
						'im_rq_user'   => ['INDEX', 'user_id'],
						'im_rq_status' => ['INDEX', 'request_status'],
					],
				],
			],
		];
	}

	public function update_data()
	{
		return [
			// Duree de validite d'une demande, en jours.
			['config.add', ['inmemorium_request_expire', 30]],
			// Nombre d'essais autorises sur le code de securite.
			['config.add', ['inmemorium_max_attempts', 5]],
			// Autoriser les membres a designer un legataire.
			['config.add', ['inmemorium_legacy_enabled', 1]],

			['module.add', [
				'ucp',
				'UCP_PROFILE',
				[
					'module_basename' => '\verturin\inmemorium\ucp\main_module',
					'modes'           => ['legacy'],
				],
			]],
		];
	}

	public function revert_schema()
	{
		return [
			'drop_tables' => [
				$this->table_prefix . 'inmemorium_legacy',
				$this->table_prefix . 'inmemorium_request',
			],
		];
	}
}
