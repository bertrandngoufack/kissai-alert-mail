<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
\tprotected $table = 'users';
\tprotected $allowedFields = [
\t\t'email','password_hash','role','api_key',
\t\t'smtp_host','smtp_port','smtp_user','smtp_pass','smtp_encryption',
\t\t'smtp_from_email','smtp_from_name'
\t];
\tprotected $useTimestamps = true;

\tpublic function findByApiKey(string $apiKey): ?array
\t{
\t\treturn $this->where('api_key', $apiKey)->first();
\t}
}

