<?php namespace App\Libraries;

class OtpGenerator
{
\tpublic static function generateCode(int $length = 4, bool $alpha = false): string
\t{
\t\t$pool = $alpha ? 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789' : '0123456789';
\t\t$code = '';
\t\tfor ($i = 0; $i < $length; $i++) {
\t\t\t$code .= $pool[random_int(0, strlen($pool) - 1)];
\t\t}
\t\treturn $code;
\t}
}

