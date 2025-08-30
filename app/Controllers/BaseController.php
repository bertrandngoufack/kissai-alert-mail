<?php namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;

class BaseController extends Controller
{
\tprotected $helpers = [];

\tpublic function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
\t{
\t\tparent::initController($request, $response, $logger);
\t}
}

