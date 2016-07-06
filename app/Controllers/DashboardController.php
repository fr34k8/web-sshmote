<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Contracts\Controller;

class DashboardController extends Controller {

    public function index(Request $request, Response $response, array $arguments) {
        return $this->view('dashboard/index.html');
    }

}
