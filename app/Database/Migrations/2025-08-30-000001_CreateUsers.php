<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
\tpublic function up()
\t{
\t\t$this->forge->addField([
\t\t\t'id'\t\t\t\t\t\t=> ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
\t\t\t'email'\t\t\t\t\t=> ['type'=>'VARCHAR','constraint'=>190,'unique'=>true],
\t\t\t'password_hash'\t\t=> ['type'=>'VARCHAR','constraint'=>255],
\t\t\t'role'\t\t\t\t\t=> ['type'=>'VARCHAR','constraint'=>32,'default'=>'user'],
\t\t\t'api_key'\t\t\t\t=> ['type'=>'VARCHAR','constraint'=>128,'unique'=>true],
\t\t\t'smtp_host'\t\t\t=> ['type'=>'VARCHAR','constraint'=>190,'null'=>true],
\t\t\t'smtp_port'\t\t\t=> ['type'=>'INT','constraint'=>5,'null'=>true],
\t\t\t'smtp_user'\t\t\t=> ['type'=>'VARCHAR','constraint'=>190,'null'=>true],
\t\t\t'smtp_pass'\t\t\t=> ['type'=>'TEXT','null'=>true],
\t\t\t'smtp_encryption'\t=> ['type'=>'VARCHAR','constraint'=>8,'null'=>true],
\t\t\t'smtp_from_email'\t=> ['type'=>'VARCHAR','constraint'=>190,'null'=>true],
\t\t\t'smtp_from_name'\t=> ['type'=>'VARCHAR','constraint'=>190,'null'=>true],
\t\t\t'created_at'\t\t\t=> ['type'=>'DATETIME','null'=>true],
\t\t\t'updated_at'\t\t\t=> ['type'=>'DATETIME','null'=>true],
\t\t]);
\t\t$this->forge->addKey('id', true);
\t\t$this->forge->createTable('users');
\t}

\tpublic function down()
\t{
\t\t$this->forge->dropTable('users');
\t}
}

