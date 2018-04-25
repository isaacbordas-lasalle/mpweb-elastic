<?php

require __DIR__ . '/../vendor/autoload.php';

use Elasticsearch\ClientBuilder;

use App\Utils\Log;


$client = ClientBuilder::create()->build();

// Índice y tipo de índice a usar por ES.
const INDEX_NAME = 'bank';
const INDEX_TYPE = 'account';

$account_number = 1;

// Componemos los parámetros necesarios para recuperar el documento de ES
$params = [
	'index' => INDEX_NAME,
	'type'  => INDEX_TYPE,
	'id'    => $account_number,
];


Log::input($params, 'Request');
$response = $client->get($params);

Log::output($response, 'Response');