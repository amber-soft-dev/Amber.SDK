<?php


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Client/AppClient.php';
$config = require __DIR__ . '/../config/config.php';

$endpoint = $config['base_uri'] . $config['endpoint'];

$client = new \AmberSdk\Client\AppClient($endpoint, new \AmberSdk\Client\AuthManager($config));

$cache = new \Gregwar\Cache\Cache();

//$client->updateObject("BaseLead", 8654, ["Phone"=>"22222-55-22"]);
//
//$lead = $client->getObject("BaseLead", 8654);
//
//
//
//var_dump($lead);

//$leads = $client->getObjects("BaseLead");
//var_dump($leads);
