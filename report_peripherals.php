<?php
require_once 'process_add_peripheral.php';
$currentItem = 'equipments';
$currentDate = date_default_timezone_set('Asia/Manila');
$currentDate = date('Y/m/d');
$is_fix = false;
if(isset($_GET['peripheral_id'])){
	$peripheral_id = $_GET['peripheral_id'];
}
else{
	header('location: for_repair.php');
}

if(isset($_GET['is_fix'])){
	$is_fix = $_GET['is_fix'];
}

include('sidebar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Report Peripheral</title>

	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
?>
<div class="container-fluid">
	<?php
		if(isset($_SESSION['message'])):
	?>
	<div class="alert alert-<?=$_SESSION['msg_type']?> alert-dismissible">
	<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php
			echo $_SESSION['message'];
			unset($_SESSION['message']);

		?>
	</div>
	<?php
		endif;
		$getPeripheral = $mysqli->query("SELECT * FROM peripherals WHERE peripheral_id = '$peripheral_id'") or die ($mysqli->error);
		$newPeripheral = $getPeripheral->fetch_array();
		if($is_fix==false){
		echo "<h5 style='color: blue;'>Report Peripheral</h5>";
		}
		else{
		echo "<h5 style='color: blue;'>Edit Peripheral if fixed. Please add a note</h5>";	
		}
	?>
	<!-- Send Report Here -->
	<div class="card shadow row" <?php if($is_fix==true){echo "style='display: none;'";} ?>>
		<table class="table" width="100%">
			<form action="process_add_peripheral.php"  method="POST">
				<table class="table" width="100%">
					<thead>
						<th width="10%">ID</th>
						<th>Type</th>
						<th>Status</th>
						<th width="40%">Note / Condition</th>
						<th>Action</th>
					</thead>
					<tr>
						<td><input type="text" name='peripheral_id' class="form-control" value="<?php echo $newPeripheral['peripheral_id']; ?>" readonly></td>
						<td><?php echo $newPeripheral['peripheral_type']; ?></td>
						<td>
							<select class="form-control" name='status'>
	 						<option value='For Repair'>For Repair</option>
	 						<option value='Not For Repair'>Not For Repair</option>
	 						</select></td>
						<td><textarea name="condition" class="form-control" style="min-height: 100px;" placeholder="Tell us something what happened to the peripheral" required></textarea></td>
						<td><button type='submit' name="submit_report" class="btn btn-primary btn-sm"><i class="fas fa-file-import"></i> Send Report</a></td>
					</tr>
				</table>
			</form>
	</div>
	<div class="card shadow row" <?php if($is_fix==false){echo "style='display: none;'";} ?>>
		<table class="table" width="100%">
			<form action="process_add_peripheral.php" method="POST" enctype="multipart/form-data">
				<table class="table" width="100%">
					<thead>
						<tr>
							<th width="8%">ID</th>
							<th>Type</th>
							<th>Status</th>
							<th width="40%">Note / Condition</th>
							<th width="8%">Repair Cost (₱)</th>
							<th>Upload Receipt</th>
							<th>Action</th>
						</tr>
					</thead>
					<tr>
						<td><input type="text" name='peripheral_id' class="form-control" value="<?php echo $newPeripheral['peripheral_id']; ?>" readonly></td>
						<td><?php echo $newPeripheral['peripheral_type']; ?></td>
						<td>
							<select class="form-control" name='status'>
	 						<option value='Fixed'>Fixed</option>
	 						<option value='For Disposal'>For Disposal</option>
	 						</select></td>
						<td><textarea name="condition" class="form-control" style="min-height: 100px;" placeholder="Tell us something what happened to the peripheral" required></textarea></td>
						<td><input type="number" name='repair_cost' class="form-control" placeholder="0.00" min="0" step="0.01" required></td>
						<td><input type="file" name="image_receipt" accept="image/*" value="Upload Receipt"></td>
						<td><button type='submit' name="submit_fix_report" class="btn btn-primary btn-sm"><i class="fas fa-file-import"></i> Save Details</a></td>
					</tr>
				</table>
			</form>
	</div>
	<!-- End Here-->
	<?php
	include('footer.php');
?>
<style type="text/css">
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
		background: none;
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
		padding-right: 5%;
		white-space: nowrap;
	}

	/*
	Label the data
	You could also use a data-* attribute and content for this. That way "bloats" the HTML, this way means you need to keep HTML and CSS in sync. Lea Verou has a clever way to handle with text-shadow.
	*/
	td:nth-of-type(1):before { content: "Building ID:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Type:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Status:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Note / Condition:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Repair Cost (₱): "; font-weight: bold; }
	td:nth-of-type(6):before { content: "Upload Receipt"; font-weight: bold; }
	td:nth-of-type(7):before { content: "Action"; font-weight: bold; }
}
</style>
<!-- EOF -->
