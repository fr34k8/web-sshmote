<?php
use Phinx\Seed\AbstractSeed;

use App\Helpers\BcryptHelper;
use App\Models\User;

class UserSeeder extends AbstractSeed {

    public function run() {
        User::create([
            'email'    => 'test@test.com',
            'username' => 'test',
            'password' => (new BcryptHelper())->make('testtest'),
        ]);
    }

}
