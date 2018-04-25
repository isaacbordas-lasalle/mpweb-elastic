<?php

require __DIR__ . '/../vendor/autoload.php';

use Elasticsearch\ClientBuilder;
use App\Utils\Log;

$client = ClientBuilder::create()->build();

// Índice y tipo de índice a usar por ES.
const INDEX_NAME = 'bank';
const INDEX_TYPE = 'account';

// Datos que queremos insertar
$data = [
	'account_number' => 1,
	'balance'        => 39225,
	'firstname'      => 'Amber',
	'lastname'       => 'Duke',
	'age'            => 32,
	'gender'         => 'M',
	'address'        => '880 Holmes Lane',
	'employer'       => 'Pyrami',
	'email'          => 'amberduke@pyrami.com',
	'city'           => 'Brogan',
	'state'          => 'IL',
];

// Componemos los parámetros necesarios para hacer el insert en ES
$params = [
	'index' => INDEX_NAME,
	'type'  => INDEX_TYPE,
	'id'    => $data['account_number'],
	'body'  => $data,
];


Log::input($params, 'Request');

// E insertamos el documento en ES
$response = $client->index($params);

Log::output($response, 'Response');