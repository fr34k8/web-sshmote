<?php
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Contracts\Controller;

class HomeController extends Controller {

    public function index(Request $request, Response $response, array $arguments) {
        $csrf_tags = $this->csrf->getTokenForHiddenInputTags();

        return $this->view('home/index.html', compact('csrf_tags'));
    }

    public function signin(Request $request, Response $response, array $arguments) {
        $username = $request->getParam('username');
        $password = $request->getParam('password');

        $login = $this->auth->attempt([
            'username' => $username,
            'password' => $password
        ]);

        if ($login === false) {
            $response = $response->withStatus(302)->withHeader('Location', $this->router->pathFor('web.home.index'));
        }else{
            $response = $response->withStatus(302)->withHeader('Location', $this->router->pathFor('web.dashboard.index'));
        }

        return $response;
    }

}
