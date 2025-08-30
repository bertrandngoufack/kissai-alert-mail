<?php

/**
 * Routes addition for API endpoints.
 * Import this file from app/Config/Routes.php, e.g.:
 * if (is_file(APPPATH . 'Config/RoutesApi.php')) { require APPPATH . 'Config/RoutesApi.php'; }
 */

$routes->group('api/rest', ['filter' => 'apiKey'], static function ($routes) {
    $routes->post('otp/generate', 'Api\\OtpController::generate');
    $routes->post('otp/check', 'Api\\OtpController::check');
    $routes->post('email/send', 'Api\\EmailController::send');
});

