<?php
require_once 'process_transfer_pc.php';
$currentItem = 'transfer';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
//$getURI = $_SERVER['QUERY_STRING'];
//echo $query; // Outputs: Query String
?>
<!DOCTYPE html>
<html>
<head>
	<title>Pull Out PC Unit</title>
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
	<?php include('topbar.php'); ?>
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
		endif
	?>
	<?php
		$mysqli = new mysqli($host,$username,$password,$database) or die(mysql_error($mysqli));
		$result = $mysqli->query('SELECT * FROM unit_pc') or die ($mysqli->error);
		$building_result = $mysqli->query('SELECT * FROM building ORDER BY building_name') or die ($mysqli->error);
		if(isset($_GET['lab_iD'])){
			$labId=$_GET['lab_iD'];
		}
		else{
			$labId = null;
		}
	?>
	
	<!-- Add Building Here -->
	<div class="card shadow row justify-content-center" style="padding: 2%;">
	<form action="#" method="POST">
	<h3>
	</h3>
	<table class='table'>
		<thead>
			<tr>
				<td colspan="2"><center><h5 style='color: blue;'>Search PC Unit for Pull Out</h5></center></td>
			</tr>
			<tr>
					<th><i class="fas fa-fw fa-building"></i> Select Building</th>
					<th><i class="fa fa-home" aria-hidden="true"></i> Laboratory / Room</th>
			</tr>
			<tr>
				 <!-- Start Drop down Building Selection -->
				<td>
					<select class="form-control" name="building_id" onchange="location = this.value;">
					<option selected disabled>Select Building</option>
						<?php
						$building_id = 0;
						while($building_row=$building_result->fetch_assoc()){
							if(isset($_GET['buildingId'])){
								$building_id = $_GET['buildingId'];
							}
						 ?>
						<option value="transfer_pc.php?buildingId=<?php echo $building_row['building_id']; ?>"
							<?php if($building_id==$building_row['building_id']){
								echo "selected disabled";
							} ?>>
							<?php echo $building_row['building_name'];?>
						</option>
						<?php } ?>
					</select>
 				</td>
 				<!-- End Building Selection -->
 				<!-- Start Lab Drop Down Selection -->
 				<td>
 					<select class="form-control" name="lab_id" onchange="location = this.value;">
 						<option selected disabled>Select Laboratories Below</option>
 						<?php
 							if(isset($_GET['buildingId'])){
 							$buildingId =	$_GET['buildingId'];
 							$labId = '';
 							if(isset($_GET['labId'])){
 								$labId = $_GET['labId'];
 							}
 							$laboratoryName = $mysqli->query("SELECT * FROM laboratory WHERE building_id=$buildingId") or die ($mysqli->error);
 							if(mysqli_num_rows($laboratoryName)==0){
 										echo "<option disabled selected value='#' class=''>WARNING! Please add a lab or room to this building first</option>";
 							}
 							else{/* DO NOTHING*/}
 							while($getLaboratoryName=$laboratoryName->fetch_assoc()){
 								$getLabId = $getLaboratoryName['lab_id'];
 								?><option value="<?php echo 'transfer_pc.php?buildingId='.$buildingId.'&labId='.$getLaboratoryName['lab_id']?>" <?php if($labId==$getLaboratoryName['lab_id']){
 										echo 'selected';
 									} ?> ><?php echo $getLaboratoryName['lab_name']; ?></option>
 								}
 						<?php
 								}
 							}	
 						?>
 					</select>
 				</td>
 				<td>
 					<a class="btn btn-sm btn-danger" href="edit_pc_equipment.php"><i class="fas as fa-sync"></i> Refresh</a>
 				</td>
			</tr>
		</thead>
	</table>
		
		
	</form>
	
	<!-- End Building Here -->
	<!-- Show Added Building Here-->
	<br/>
	<!--<h4>List of PC Units</h4>-->
	<?php
		if(isset($_GET['buildingId']) && isset($_GET['labId'])){
		$buildingId =	$_GET['buildingId'];
		$labId = $_GET['labId'];
		$getPCResults = $mysqli->query("SELECT unit_pc.unit_no, unit_pc.unit_name,laboratory.lab_name, building.building_name FROM unit_pc JOIN  laboratory ON unit_pc.lab_id = laboratory.lab_id JOIN building ON unit_pc.building_id = building.building_id WHERE unit_pc.building_id = $buildingId AND unit_pc.lab_id = $labId") or die($mysqli->error());
		//$numberPreview = 1;
		$resultsPerPage = 15;
		$numberOfResults = mysqli_num_rows($getPCResults);
		$numberOfPages = ceil($numberOfResults/$resultsPerPage);
		if(!isset($_GET['page'])){
			$page = 1;
		}
		else{
			$page = $_GET['page'];
		}
		$thisPageFirstResult = ($page-1)*$resultsPerPage;
		$getPCResults = $mysqli->query("SELECT unit_pc.unit_id, unit_pc.unit_no, unit_pc.unit_name,unit_pc.status, laboratory.lab_name, building.building_name, building.building_id, laboratory.lab_id FROM unit_pc JOIN laboratory ON unit_pc.lab_id = laboratory.lab_id JOIN building ON unit_pc.building_id = building.building_id WHERE unit_pc.building_id = $buildingId AND unit_pc.lab_id = $labId") or die($mysqli->error());
		if(mysqli_num_rows($getPCResults)==0){
			echo "<h5 class='alert alert-danger'>It appears that this laboratory doesn't house any computers as of the moment.</h5>";
		}
	 echo "	<div class='row justify-content-center'>";
	

	?>
	<label class="form-control" style='color: blue;'>List of PC Units</label>
		<table class='table' id="dataTable" cellspacing="0">
			<thead>
				<tr>
					<th>No</th>
					<th>PC Name</th>
					<th>Laboratory</th>
					<th>Building</th>
					<th>Actions</th>
				</tr>
			</thead>
			
			<?php 
			while($newGetPCResults=$getPCResults->fetch_assoc()):?>
 			<tr style="width: 100% !important;">
 				<td><?php echo ++$thisPageFirstResult; ?></td>
 				<td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#ModalID<?php echo $newGetPCResults['unit_id'];?>"><?php echo $newGetPCResults['unit_name']; ?></button></td>
 				<td><?php echo $newGetPCResults['lab_name']; ?></td>
 				<td><?php echo $newGetPCResults['building_name'];?></td>
				<td>
					<!-- Start Drop down Delete here -->
					<button class="btn btn-warning btn-sm dropdown-toggle" href="#" style="color: #5D4037;" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-outdent"></i>  Pull out </button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding: 10px !important; font-size: 14px;">Proceed? You cannot undo the changes<br/>
						<a class="btn btn-primary btn-sm" style="" href="process_transfer_pc.php?pull_out=yes&unit_id=<?php echo $newGetPCResults['unit_id']; ?>&building=<?php echo $newGetPCResults['building_id']; ?>&laboratory=<?php echo $newGetPCResults['lab_id']; ?>"><i class="fas fa-outdent"></i>  Proceed</a>
						<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a>
					</div>
				</td>
 			</tr>
 			<!-- Modal For PC Equipments -->
			<div class="modal fade" id="ModalID<?php echo $newGetPCResults['unit_id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle"><?php echo $newGetPCResults['unit_name'].' Peripherals and Equipments'; ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<!-- Contents Here -->
					<u>Additional Information:</u><br/>
					<?php
						$unit_id =  $newGetPCResults['unit_id'];
						$getPeripherals = $mysqli->query("SELECT * FROM peripherals WHERE unit_id=$unit_id") or die ($mysqli->error());
						
						if(mysqli_num_rows($getPeripherals)==0){
							echo "<span class='text-danger'>No Peripherals / Computer Parts Stored at the moment</span>";
						}
						else{
							//print_r($newPeripherals);
							while($newPeripherals=$getPeripherals->fetch_assoc()){
								echo '<br/>'.$newPeripherals['peripheral_type'].': '.$newPeripherals['peripheral_brand'].'<br/>';
								echo 'Serial ID: ' .$newPeripherals['peripheral_serial_no'].'<br/>';
							}

						}
					?>
				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- End Modal For PC Equipments -->
 			<?php endwhile; ?>

		</table>
	</div>
</div>
<?php
}
else{
		echo "<h5 class='alert alert-warning'>Select Building and Laboratory First</h5>";
	}
	?>
	<br/>
	<!-- End PC Equipment Views Here-->
	<?php
	include('footer.php');
?>
<!-- EOF -->