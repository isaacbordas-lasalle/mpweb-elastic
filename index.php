<!DOCTYPE html>
<html>
<head>
	<title>MPWEB Javascript and CSS example</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://almsaeedstudio.com/themes/AdminLTE/dist/css/AdminLTE.min.css">
</head>
<body>

<?php
$search    = (isset($_GET['search'])) ? $_GET['search'] : '';
?>

<div class="container">
	<div class="page-header">
		<h1> Bank accounts </h1>
	</div>


	<div class="box box-primary col-xs-12">
		<form action="/" method="get">
			<div class="box-header with-border">
				<h3 class="box-title">Filter</h3>
			</div>
			<div class="box-body">

				<div class="form-group">
					<label for="search">Search</label>
					<input type="text" class="form-control" name="search" id="search" placeholder="Search"
						   value="<?= $search ?>">
				</div>
			</div>
			<!-- /.box-body -->
			<div class="box-footer">
				<button type="submit" class="btn btn-primary">Filter</button>
			</div>
		</form>
	</div>

	<div class="col-xs-12">
		<?php include('results_table.php') ?>
	</div>
</div>
</body>
</html>
