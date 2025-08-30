<?php namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmailLogs extends Migration
{
\tpublic function up()
\t{
\t\t$this->forge->addField([
\t\t\t'id'\t\t\t\t\t=> ['type'=>'BIGINT','unsigned'=>true,'auto_increment'=>true],
\t\t\t'user_id'\t\t\t\t=> ['type'=>'INT','unsigned'=>true],
\t\t\t'to_email'\t\t\t=> ['type'=>'VARCHAR','constraint'=>190],
\t\t\t'subject'\t\t\t\t=> ['type'=>'VARCHAR','constraint'=>255],
\t\t\t'status'\t\t\t\t=> ['type'=>'ENUM','constraint'=>['success','error'],'default'=>'success'],
\t\t\t'error'\t\t\t\t\t=> ['type'=>'TEXT','null'=>true],
\t\t\t'message_id'\t\t\t=> ['type'=>'VARCHAR','constraint'=>190,'null'=>true],
\t\t\t'created_at'\t\t\t=> ['type'=>'DATETIME','null'=>true],
\t\t]);
\t\t$this->forge->addKey('id', true);
\t\t$this->forge->createTable('email_logs');
\t}

\tpublic function down()
\t{
\t\t$this->forge->dropTable('email_logs');
\t}
}

