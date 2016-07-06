<?php
use App\Contracts\Migration;

class CreateServerTable extends Migration {

    public function up() {
        $this->schema->create('server', function(Illuminate\Database\Schema\Blueprint $table) {
            $table->increments('id');
            $table->string('name', 120);
            $table->string('host', 50);
            $table->string('port', 10);
            $table->string('username', 30);
            $table->string('password', 64);
            $table->string('auth_method', 30);
            $table->timestamps();
        });
    }

    public function down() {
        $this->schema->drop('server');
    }

}
