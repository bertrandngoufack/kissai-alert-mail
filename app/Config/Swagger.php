<?php namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Swagger extends BaseConfig
{
    public string $title = 'Kissai Alert API';
    public string $version = 'v1';

    public array $security = [
        ['ApiKeyAuth' => []]
    ];

    public array $components = [
        'securitySchemes' => [
            'ApiKeyAuth' => [
                'type' => 'apiKey',
                'in'   => 'header',
                'name' => 'Authorization',
            ],
        ],
    ];
}

