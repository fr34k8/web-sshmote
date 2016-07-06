<?php
namespace App\Controllers;

use Interop\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use App\Contracts\Controller;
use App\Repositories\ServerRepository;
use App\Helpers\SshHelper;

class DashboardController extends Controller {

    protected $serverRepository;

    public function __construct(ContainerInterface $container) {
        parent::__construct($container);

        $this->serverRepository = new ServerRepository();
    }

    public function index(Request $request, Response $response, array $arguments) {
        $servers = $this->serverRepository->findAll();

        return $this->view('dashboard/index.html', compact('servers'));
    }

    public function run(Request $request, Response $response, array $arguments) {
        $validator = $this->validator;
        $validator->validators($request->getParams(), [
            'command'   => v::notEmpty()->in(['ping', 'host', 'traceroute', 'mtr', 'nslookup']),
            'target_ip' => v::notEmpty(),
            'servers'   => v::notEmpty(),
        ]);

        if ($validator->fails()) {
            $this->flash->error($validator->firstError());

            return $this->redirect($this->router->pathFor('web.dashboard.index'));
        }else{
            $command   = $request->getParam('command');
            $target_ip = $request->getParam('target_ip');
            $servers   = $request->getParam('servers');

            $ssh_helper = new SshHelper();
            $servers    = $this->serverRepository->findByIds($servers);
            $results    = [];

            foreach($servers as $server) {
                $results[$server->id] = [
                    'server'   => $server,
                    'response' => $ssh_helper->targetIp($target_ip)->server($server)->command($command)->run(),
                ];
            }

            $this->session->set('serverRunCommand', $command);
            $this->session->set('serverRunResults', $results);

            return $this->redirect($this->router->pathFor('web.dashboard.result'));
        }
    }

    public function result(Request $request, Response $response, array $arguments) {
        $command = $this->session->get('serverRunCommand');
        $results = $this->session->get('serverRunResults');

        return $this->view('dashboard/result.html', compact('command', 'results'));
    }

}
