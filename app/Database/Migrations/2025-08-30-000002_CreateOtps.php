<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOtps extends Migration
{
\tpublic function up()
\t{
\t\t$this->forge->addField([
\t\t\t'id'\t\t\t\t\t\t\t\t=> ['type'=>'BIGINT','unsigned'=>true,'auto_increment'=>true],
\t\t\t'user_id'\t\t\t\t\t=> ['type'=>'INT','unsigned'=>true],
\t\t\t'recipient'\t\t\t\t=> ['type'=>'VARCHAR','constraint'=>190],
\t\t\t'code'\t\t\t\t\t\t=> ['type'=>'VARCHAR','constraint'=>32],
\t\t\t'alpha'\t\t\t\t\t\t=> ['type'=>'TINYINT','constraint'=>1,'default'=>0],
\t\t\t'length'\t\t\t\t\t=> ['type'=>'INT','constraint'=>3,'default'=>4],
\t\t\t'attempts'\t\t\t\t=> ['type'=>'INT','constraint'=>3,'default'=>0],
\t\t\t'max_attempts'\t\t\t=> ['type'=>'INT','constraint'=>3,'default'=>3],
\t\t\t'max_seconds_validity'=> ['type'=>'INT','constraint'=>6,'default'=>60],
\t\t\t'app_id'\t\t\t\t\t=> ['type'=>'VARCHAR','constraint'=>64,'default'=>''],
\t\t\t'status'\t\t\t\t\t=> ['type'=>'ENUM','constraint'=>['pending','validated','expired'],'default'=>'pending'],
\t\t\t'created_at'\t\t\t\t=> ['type'=>'DATETIME','null'=>true],
\t\t\t'updated_at'\t\t\t\t=> ['type'=>'DATETIME','null'=>true],
\t\t\t'expires_at'\t\t\t\t=> ['type'=>'DATETIME','null'=>true],
\t\t]);
\t\t$this->forge->addKey('id', true);
\t\t$this->forge->addKey(['user_id','recipient']);
\t\t$this->forge->createTable('otps');
\t}

\tpublic function down()
\t{
\t\t$this->forge->dropTable('otps');
\t}
}

