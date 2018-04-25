<?php require __DIR__ . '/vendor/autoload.php';


use App\Search\Types\SearchBankAccounts;
use App\Search\Highlight\Highlight;
use App\Search\SearchMultiQuery;
use Elasticsearch\ClientBuilder;

$search = (isset($_GET['search'])) ? $_GET['search'] : '';


$searchable_fields = ['firstname', 'lastname'];
$searchQuery       = new SearchMultiQuery($search, $searchable_fields);
$highlighter       = new Highlight($searchable_fields);

$client             = ClientBuilder::create()->build();
$searchBankAccounts = new SearchBankAccounts($client, $searchQuery);
$searchBankAccounts->setHighlighter($highlighter);

// Descomenta estas líneas si quieres ver la query que se está ejecutando.
// Útil en el caso de que haya un error de sintaxis
//echo "<pre>";
//echo json_encode($searchBankAccounts->getQuery(), JSON_PRETTY_PRINT);
//echo "</pre>";

$filterResults = $searchBankAccounts->search();

function getHighlight($result, $field)
{
	if (isset($result['highlight'][$field][0])) {
		return $result['highlight'][$field][0];
	}
	return $result['_source'][$field];
}

?>

<style>
	.table-results em {
		background-color: #FFFF00;
		font-weight: bold;
	}
</style>

<div class="box">
	<div class="box-header">
		<h3 class="box-title">Results (hits=<?= $total_hits = $filterResults['hits']['total'] ?>)</h3>

		<div class="box-tools">
			<div class="input-group input-group-sm" style="width: 150px;">
			</div>
		</div>
	</div>
	<div class="box-body table-responsive">
		<table class="table table-hover table-striped table-results">
			<tbody>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Surname</th>
				<th>Balance</th>
				<th>Email</th>
				<th>ElasticSearch sort score</th>
			</tr>
			<?php

			foreach ($filterResults['hits']['hits'] as $filterResult) {
				$result = $filterResult['_source'];
				?>
				<tr>
					<td>#<?= $result['account_number'] ?></td>
					<td><?= getHighlight($filterResult, 'firstname') ?></td>
					<td><?= getHighlight($filterResult, 'lastname') ?></td>
					<td>$ <?= $result['balance'] ?></td>
					<td><?= $result['email'] ?></td>
					<td><?= $filterResult['_score'] ?></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<hr>
		<?php
		echo "<pre>ElasticSearch QUERY \n";
		echo json_encode($searchBankAccounts->getQuery(), JSON_PRETTY_PRINT);
		echo "</pre>";
		echo "<pre>ElasticSearch Response \n";
		echo json_encode($filterResults, JSON_PRETTY_PRINT);
		echo "</pre>";


		?>
	</div>
</div>
