<?php
namespace App\Repositories;

use App\Contracts\Repository;
use App\Models\Server;

class ServerRepository extends Repository {

    protected $server;

    public function __construct() {
        $this->server = new Server();
    }

    public function create($data) {
        return $this->server->create($data);
    }

}
