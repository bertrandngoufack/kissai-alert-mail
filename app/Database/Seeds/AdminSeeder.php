<?php namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AdminSeeder extends Seeder
{
\tpublic function run()
\t{
\t\t$this->db->table('users')->insert([
\t\t\t'email'\t\t\t\t => 'admin@local.test',
\t\t\t'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
\t\t\t'role'\t\t\t\t => 'admin',
\t\t\t'api_key'\t\t\t => bin2hex(random_bytes(32)),
\t\t\t'created_at'\t\t => date('Y-m-d H:i:s'),
\t\t]);
\t}
}

