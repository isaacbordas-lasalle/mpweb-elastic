<?php

require __DIR__ . '/../vendor/autoload.php';

use Elasticsearch\ClientBuilder;
use App\Utils\Log;

$client = ClientBuilder::create()->build();

// Índice y tipo a usar por ES.
const INDEX_NAME = 'bank';
const INDEX_TYPE = 'account';

$query = [
	'match' => [
		'firstname' => 'Amber',
	],
];

// Componemos la consulta para a ES
$params = [
	'index' => INDEX_NAME,
	'type'  => INDEX_TYPE,
	'body'  => [
		'query' => $query,
	],
];


Log::input($params, 'Request');
// Ejecutamos la consulta anterior
$response = $client->search($params);

// Y vemos los resultados
Log::output($response, 'Response');
