<?php namespace App\Models;

use CodeIgniter\Model;

class OtpModel extends Model
{
\tprotected $table = 'otps';
\tprotected $allowedFields = [
\t\t'user_id','recipient','code','alpha','length','attempts','max_attempts',
\t\t'max_seconds_validity','app_id','status','expires_at'
\t];
\tprotected $useTimestamps = true;
}

