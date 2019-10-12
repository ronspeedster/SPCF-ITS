<?php
include 'process_vehicles.php';
$currentItem = 'vehicles';
include('sidebar.php');
//include('topbar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title> Manage Vehicle Maintenance</title>
	
	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper" style="width: 100% !important;">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
        <div id="content">
	<?php 
   	include('topbar.php');
	$getVehicles = mysqli_query($mysqli, "SELECT * FROM vehicle");
	$getVehicleExpense = mysqli_query($mysqli, "SELECT * FROM vehicle v
		JOIN vehicle_expense ve
		ON ve.vehicle_id = v.id");
?>
<div class="container-fluid">
	<?php
		if(isset($_SESSION['message'])){
	?>
	<div class="alert alert-<?=$_SESSION['msg_type']?> alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php
			echo $_SESSION['message'];
			unset($_SESSION['message']);

		?>
	</div>
	<?php
		}
	?>

	<!-- Add Building Here -->
	<div class="card shadow row justify-content-center" style="padding: 1%;">

	<form action="process_vehicles.php" method="POST" enctype="multipart/form-data">
	<center>
		<h5 style="color: blue;">Manage Vehicle Maintenance</h5>
	</center>
	<!-- Responsive Form -->
	<div class="row col-md-12 mb-2" style="">
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Type</center></span>
			<select class="form-control" name="expense_type">
				<option value="gas">Gas</option>
				<option value="maintenance">Maintenance</option>
				<option value="purchase_parts">Purchase Parts</option>
				<option value="car_wash">Car Wash</option>
			</select>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Description</center></span>
			<textarea style="min-height: 32px; height: 32px;" type="text" class="form-control" name="expense_description" class="form-control" required></textarea>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Vehicle</center></span>
			<select class="form-control" name="vehicle_id" required><?php
				while($newVehicles=$getVehicles->fetch_assoc()){
				?>
				<option value="<?php echo $newVehicles['id']; ?>"><?php echo $newVehicles['name'].' '.$newVehicles['plate_no']; ?></option>
				<?php	}
				?>
			</select>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>O.R / Receipt</center></span>
			<input type="file" name="expense_receipt" accept="image/*" value="Upload Receipt" required>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Cost</center></span>
			<input type="number" name='expense_cost' class="form-control" placeholder="0.00" min="0" step="0.01" required>
		</div>
		<div class="col-md-2 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Actions</center></span>
			<center>
				<button type="submit" class="btn btn-primary btn-sm mb-1" name="submit_expense_vehicle"><i class="far fa-save"></i> Save</button>
				<a href="vehicle_expense.php" id="refresh" class='btn btn-danger btn-sm mb-1'><i class="fas as fa-sync"></i> Clear/Refresh</a>
			</center>
		</div>		
	</div>
	<!-- Responsive Form End-->
	</form>
			
	<!-- End Building Here -->
	<!-- Show Added laboratories Here-->
	<h4 style='color: blue;' class="form-control">List of Rooms and Laboratories</h4>	
	<br/>
	<div class="table-responsive">
	<table class="table" id="dataTable" width="100%" cellspacing="0" role="table">
		<thead role="rowgroup">
			<tr role="row">
				<th role="columnheader">ID</th>
				<th role="columnheader">Vehicle</th>
				<th role="columnheader">Plate No.</th>
				<th role="columnheader">Expense Type</th>
				<th role="columnheader">Expense Cost</th>
				<th role="columnheader">Date</th>
				<th role="columnheader">Image</th>
			</tr>
		</thead>
		<tbody role="rowgroup">
			<?php while($newVehicleExpense=$getVehicleExpense->fetch_assoc()){ ?>
			<tr role="row">
				<td role="cell"><?php echo $newVehicleExpense['id']; ?></td>
				<td role="cell"><?php echo $newVehicleExpense['name']; ?></td>
				<td role="cell"><?php echo $newVehicleExpense['plate_no']; ?></td>
				<td role="cell"><?php echo $newVehicleExpense['expense_type']; ?></td>
				<td role="cell"><?php echo $newVehicleExpense['expense_cost']; ?></td>
				<td role="cell"><?php echo $newVehicleExpense['date_added']; ?></td>
				<td role="cell"><a class="btn btn-sm btn-info" href="img/assets/<?php echo $newVehicleExpense['file_name'] ?>" target="_blank"><i class="far fa-image"></i> Image</a></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>
	</div>
</div>
	
	<br/>
	<!-- End Added Building Here-->
	<?php
	include('footer.php');
?>
<style type="text/css">
	/*
	Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
@media
only screen
and (max-width: 760px), (min-device-width: 768px)
and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	table, thead, tbody, th, td, tr {
		display: block;
	}

	thead tr {
		position: absolute;
		top: -9999px;
		left: -9999px;
	}

	tr {
		margin: 0 0 1rem 0;
	}

	tr:nth-child(odd) {
		background: #fcfce3;
		padding: 1%;
		width: 100%;
		border-bottom: 2px solid grey;
		border-top: 2px solid grey;
	}
	    
	td {
		border-bottom: 1px solid #eee;
		position: relative;
	}

	td:before {
		top: 0;
		width: 45%;
		padding-right: 1%;
		white-space: nowrap;
	}

	/*
	Label the data
	You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
	*/
	td:nth-of-type(1):before { content: "ID:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Vehicle:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Plate No:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Expense Type:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Expense Cost: "; font-weight: bold; }
	td:nth-of-type(6):before { content: "Date: "; font-weight: bold; }
	td:nth-of-type(7):before { content: "Image: "; font-weight: bold; }
}
</style>
<!-- EOF -->
