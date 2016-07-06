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

    public function findAllWithPaginate($per_page = 12) {
        return $this->server->orderBy('created_at', 'desc')->paginate($per_page);
    }

}
