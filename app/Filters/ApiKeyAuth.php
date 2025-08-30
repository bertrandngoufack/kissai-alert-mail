<?php namespace App\Filters;

use App\Models\UserModel;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Config\Services;

class ApiKeyAuth implements FilterInterface
{
\tpublic function before(RequestInterface $request, $arguments = null)
\t{
\t\t$auth = $request->getHeaderLine('Authorization');
\t\tif (!$auth) {
\t\t\treturn Services::response()->setJSON(['error'=>['code'=>401,'description'=>'Missing Authorization header']])->setStatusCode(401);
\t\t}

\t\t$apiKey = null;
\t\tif (stripos($auth, 'Basic ') === 0) { $apiKey = trim(substr($auth, 6)); }
\t\tif (stripos($auth, 'Bearer ') === 0) { $apiKey = trim(substr($auth, 7)); }

\t\tif (!$apiKey) {
\t\t\treturn Services::response()->setJSON(['error'=>['code'=>401,'description'=>'Invalid Authorization header']])->setStatusCode(401);
\t\t}

\t\t$user = (new UserModel())->findByApiKey($apiKey);
\t\tif (!$user) {
\t\t\treturn Services::response()->setJSON(['error'=>['code'=>401,'description'=>'Invalid API key']])->setStatusCode(401);
\t\t}

\t\t$request->user = $user;
\t}

\tpublic function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
\t{
\t}
}

