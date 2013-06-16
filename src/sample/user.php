<?php

require_once '../../vendor/autoload.php';


use Beanstalkapi\Client\UserClient;

// Config
$config = array(
    'account'  => 'tequilarapido',
    'username' => 'tr_nbourguig',
    'password' => '9RuQxItg7FTm'
);

$user = UserClient::factory($config);

try {

    /* $findAll = $user->findAll(array('per_page' => 3, 'page' => 9));
     print_r(array('$all' => $findAll));

     $me = $user->me();
     print_r(array('$me' => $me));

     $find = $user->find(array('user_id' => 91374));
     print_r(array('$me' => $find));*/

    $create = $user->create(
        array(
            'user' => json_encode( array(
                "admin"    => false,
                "timezone" => "Europe/Paris",
                "name"     => "John Doe",
                "login"    => "john",
                "email"    => "john@example.com",
                "password" => "12345"
            ) )
        )
    );
    print_r(array('$create' => $create));


} catch (Exception $e) {
    die('Error : ' . $e->getMessage());
}
