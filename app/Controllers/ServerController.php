<?php
namespace App\Controllers;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use App\Contracts\Controller;
use App\Repositories\ServerRepository;

class ServerController extends Controller {

    protected $serverRepository;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);

        $this->serverRepository = new ServerRepository();
    }

    public function index(Request $request, Response $response, array $arguments) {
        $servers = $this->serverRepository->findAllWithPaginate();
        $servers->setPath($this->router->pathFor('web.server.index'));

        return $this->view('server/index.html', compact('servers'));
    }

    public function create(Request $request, Response $response, array $arguments) {
        return $this->view('server/create.html');
    }

    public function store(Request $request, Response $response, array $arguments) {
        $validator = $this->validator;
        $validator->validators($request->getParams(), [
            'host'        => v::notEmpty()->noWhitespace(),
            'port'        => v::notEmpty()->between(0, 63737),
            'username'    => v::notEmpty(),
            'password'    => v::notEmpty(),
            'auth_method' => v::notEmpty()->in(['password']),
        ]);

        if ($validator->fails() === true) {
            $this->flash->error($validator->firstError());
        }else{
            $host        = $request->getParam('host');
            $port        = $request->getParam('port');
            $username    = $request->getParam('username');
            $password    = $request->getParam('password');
            $auth_method = $request->getParam('auth_method');

            $this->serverRepository->create([
                'host'        => $host,
                'port'        => $port,
                'username'    => $username,
                'password'    => $password,
                'auth_method' => $auth_method,
            ]);

            $this->flash->success("Server created");
        }

        return $this->redirect($this->router->pathFor('web.server.create'));
    }

    public function edit(Request $request, Response $response, array $arguments) {

    }

}
