<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Contracts\Controller;

class ServerController extends Controller {

    public function create(Request $request, Response $response, array $arguments) {
        return $this->view('server/create.html');
    }

}
