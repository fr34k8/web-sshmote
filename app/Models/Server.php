<?php
namespace App\Models;

use App\Contracts\Model;

class Server extends Model {

    protected $table    = 'server';

    protected $fillable = ['name', 'host', 'port', 'username', 'password', 'auth_method'];

    protected $hidden   = ['password'];

}
