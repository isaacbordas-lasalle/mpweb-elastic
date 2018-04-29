<!DOCTYPE html>
<html>
<head>
	<title>MPWEB Javascript and CSS example</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="https://almsaeedstudio.com/themes/AdminLTE/dist/css/AdminLTE.min.css">
</head>
<body>

<?php
$search = (isset($_GET['search'])) ? $_GET['search'] : '';
$balance_from = (isset($_GET['balance_from'])) ? $_GET['balance_from'] : '';
$balance_to = (isset($_GET['balance_to'])) ? $_GET['balance_to'] : '';
$city = (isset($_GET['city'])) ? $_GET['city'] : '';
$state = (isset($_GET['state'])) ? $_GET['state'] : '';
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
						   value="<?php echo $search; ?>">
				</div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label for="balance_from">Balance From:</label>
                        <input type="text" class="form-control" name="balance_from" id="balance_from" placeholder="Balance from"
                               value="<?php echo $balance_from; ?>">
                    </div>
                    <div class="col-sm-2">
                        <label for="balance_to">Balance To:</label>
                        <input type="text" class="form-control" name="balance_to" id="balance_to" placeholder="Balance to"
                               value="<?php echo $balance_to; ?>">
                    </div>
                    <div class="col-sm-2">
                        <label for="city">City</label>
                        <input type="text" class="form-control" name="city" id="city" placeholder="City"
                               value="<?php echo $city; ?>">
                    </div>
                    <div class="col-sm-2">
                        <label for="state">State</label>
                        <input type="text" class="form-control" name="state" id="state" placeholder="State"
                               value="<?php echo $state; ?>">
                    </div>
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
