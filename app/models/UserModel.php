<?php

namespace app\models;

use Flight;

class UserModel {

    public function getUsers() {
        $users = [
			[ 'id' => 1, 'name' => 'Bob Jones', 'email' => 'bob@example.com' ],
			[ 'id' => 2, 'name' => 'Bob Smith', 'email' => 'bsmith@example.com' ],
			[ 'id' => 3, 'name' => 'Suzy Johnson', 'email' => 'suzy@example.com' ],
			[ 'id' => 4, 'name' => 'Rakoto Abel', 'email' => 'rakoto@gmail.com' ],
            [ 'id' => 5, 'name' => 'Rasoa Cedric', 'email' => 'cedric@gmail.com' ],
		];
        return $users;
    }

    public function getUser($id) {
        $users = [
			[ 'id' => 1, 'name' => 'Bob Jones', 'email' => 'bob@example.com' ],
			[ 'id' => 2, 'name' => 'Bob Smith', 'email' => 'bsmith@example.com' ],
			[ 'id' => 3, 'name' => 'Suzy Johnson', 'email' => 'suzy@example.com' ],
			[ 'id' => 4, 'name' => 'Rakoto Abel', 'email' => 'rakoto@gmail.com' ],
            [ 'id' => 5, 'name' => 'Rasoa Cedric', 'email' => 'cedric@gmail.com' ],
		];
        return $users[$id];
    }

}