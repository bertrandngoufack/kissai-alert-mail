<?php namespace App\Models;

use CodeIgniter\Model;

class EmailLogModel extends Model
{
\tprotected $table = 'email_logs';
\tprotected $allowedFields = ['user_id','to_email','subject','status','error','message_id','created_at'];
\tpublic $useTimestamps = false;
}

