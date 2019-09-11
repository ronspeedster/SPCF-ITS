<?php
require_once 'process_fixture.php';
$currentItem = 'equipments';

$currentDate = date_default_timezone_set('Asia/Manila');
$currentDate = date('Y/m/d');
$fixture_id=0;
if(isset($_GET['fixture_id'])){
	$fixture_id = $_GET['fixture_id'];
}
else{
	header('location: for_repair_fixtures.php');
}
$is_fix=false;
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
		$getFixture = $mysqli->query("SELECT * FROM fixture WHERE id = '$fixture_id'") or die ($mysqli->error);
		$newFixture = $getFixture->fetch_array();
		if($is_fix==false){
			echo "<h5 style='color: blue;'>Report Peripheral</h5>";
		}
		else{
			echo "<h5 style='color: blue;'>Edit Fixture details. Please add a note</h5>";
		}
	?>
	<!-- Send Report Here -->
	<div class="row" <?php if($is_fix==true){echo "style='display: none;'";} ?>>
		<table class="table" width="100%">
			<form action="process_fixture.php"  method="POST">
				<table class="table" width="100%">
					<thead>
						<th width="10%">ID</th>
						<th>Type</th>
						<th>Status</th>
						<th width="40%">Note / Condition</th>
						<th>Action</th>
					</thead>
					<tr>
						<td><input type="text" name='fixture_id' class="form-control" value="<?php echo $newFixture['id']; ?>" readonly></td>
						<td><?php echo strtoupper($newFixture['type']); ?></td>
						<td>
							<select class="form-control" name='status'>
		 						<option value='For Repair'>For Repair</option>
		 						<option value='Not For Repair'>Not For Repair</option>
	 						</select>
	 					</td>
						<td><textarea name="condition" class="form-control" style="min-height: 100px;" placeholder="Tell us something what happened to the peripheral" required></textarea></td>
						<td><button type='submit' name="submit_report" class="btn btn-primary btn-sm"><i class="fas fa-file-import"></i> Send Report</a></td>
					</tr>
				</table>
			</form>
	</div>
	<!-- Edit Report Here -->
	<div class="row" <?php if($is_fix==false){echo "style='display: none;'";} ?>>
		<table class="table" width="100%">
			<form action="process_fixture.php"  method="POST" enctype="multipart/form-data">
				<table class="table" width="100%">
					<thead>
						<th width="10%">ID</th>
						<th>Type</th>
						<th>Status</th>
						<th width="40%">Note / Condition</th>
						<th width="8%">Repair Cost (₱)</th>
						<th>Upload Receipt</th>
						<th>Action</th>
					</thead>
					<tr>
						<td><input type="text" name='fixture_id' class="form-control" value="<?php echo $newFixture['id']; ?>" readonly></td>
						<td><?php echo strtoupper($newFixture['type']); ?></td>
						<td>
							<select class="form-control" name='status'>
		 						<option value='Fixed'>Fixed</option>
		 						<option value='For Disposal'>For Disposal</option>
	 						</select>
	 					</td>
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