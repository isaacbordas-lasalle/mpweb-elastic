<?php

require __DIR__ . '/../vendor/autoload.php';

use Elasticsearch\ClientBuilder;

use App\Utils\Log;
use Elasticsearch\Common\Exceptions\Missing404Exception;


$client = ClientBuilder::create()->build();

// Componemos los parámetros necesarios para recuperar el documento de ES
$params = [
    'index' => 'invalid_index',
    'type' => 'invalid_type',
    'id' => 1,
];


Log::input($params, 'Request');

try {
	$response = $client->get($params);
} catch (Missing404Exception $error) {
	$esError = json_decode($error->getMessage(), true);
	Log::error("Document not found!");
	Log::output($esError, 'json_decode($error->getMessage())');
	exit(0);
}


Log::output($response, 'Response');
