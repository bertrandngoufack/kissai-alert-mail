<?php namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;

class Filters extends BaseConfig
{
\tpublic array $aliases = [
\t\t'csrf'    => CSRF::class,
\t\t'toolbar' => DebugToolbar::class,
\t\t'apiKey'  => \App\Filters\ApiKeyAuth::class,
\t];

\tpublic array $globals = [
\t\t'before' => [],
\t\t'after'  => ['toolbar'],
\t];

\tpublic array $methods = [];

\tpublic array $filters = [];
}

