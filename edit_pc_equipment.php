<?php
require_once 'process_unit_pc.php';
$currentItem = 'equipments';
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
	<title>Add / Edit PC Equipments</title>
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
	
	
	<div class="card shadow row justify-content-center" style="padding: 2%;">
	
	<!-- Responsive Form -->
	<form action="#" method="POST">
	<center><h5 style='color: blue;'>Search PC Unit</h5></center>
	
	<div class="row col-md-12 mb-2" style="">
		<div class="col-md-4 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""> <i class="fas fa-fw fa-building"></i> Select Building </span>
			<select class="form-control" name="building_id" onchange="location = this.value;">
				<option selected disabled>Select Building</option>
				<?php
				$building_id = 0;
				while($building_row=$building_result->fetch_assoc()){
					if(isset($_GET['buildingId'])){
						$building_id = $_GET['buildingId'];
					}
					?>
				<option value="edit_pc_equipment.php?buildingId=<?php echo $building_row['building_id']; ?>"
				<?php if($building_id==$building_row['building_id']){
					echo "selected disabled";
				} ?>
				>
				<?php echo $building_row['building_name'];?>
				</option>
			<?php } ?>
			</select>			
		</div>
		<div class="row col-md-4 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold"><i class="fa fa-home" aria-hidden="true"></i> Laboratory / Room</span>
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
 								?><option value="<?php echo 'edit_pc_equipment.php?buildingId='.$buildingId.'&labId='.$getLaboratoryName['lab_id']?>" <?php if($labId==$getLaboratoryName['lab_id']){
 										echo 'selected';
 									} ?> ><?php echo $getLaboratoryName['lab_name']; ?></option>
 								}
 						<?php
 								}
 							}	
 						?>
 					</select>
		</div>
		<div class="row col-md-4 mb-1" style="padding: 1%; margin: auto; text-align: center;">
			<span class="font-weight-bold">Actions<br/><a class="btn btn-sm btn-danger" href="edit_pc_equipment.php"><i class="fas as fa-sync"></i> Refresh</a></span>
		</div>
	</div>
	</form>
	<!-- End Responsive Form -->
	
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
		$getPCResults = $mysqli->query("SELECT unit_pc.unit_id, unit_pc.unit_no, unit_pc.unit_name,unit_pc.status, laboratory.lab_name, building.building_name FROM unit_pc JOIN laboratory ON unit_pc.lab_id = laboratory.lab_id JOIN building ON unit_pc.building_id = building.building_id WHERE unit_pc.building_id = $buildingId AND unit_pc.lab_id = $labId") or die($mysqli->error());
		if(mysqli_num_rows($getPCResults)==0){
			echo "<h5 class='alert alert-danger'>It appears that this laboratory doesn't house any computers as of the moment.</h5>";
		}
	 echo "	<div class='row justify-content-center'>";
	

	?>
	<label class="form-control" style='color: blue;'>List of PC Units</label>

		<table class="table" width="100%" id="dataTable" cellspacing="0" role="table">
			<thead role="rowgroup">
				<tr role="row">
					<th role="columnheader">No</th>
					<th role="columnheader">PC Name</th>
					<th role="columnheader">Laboratory</th>
					<th role="columnheader">Building</th>
					<th style="display: none;" role="columnheader">Status</th>
					<th width="30%" role="columnheader">Actions</th>
				</tr>
			</thead>
			<tbody role="rowgroup">
			<?php 
			while($newGetPCResults=$getPCResults->fetch_assoc()){?>
 			<tr style="width: 100% !important;" role="row">
 				<td role="cell"><?php echo ++$thisPageFirstResult; ?></td>
 				<td role="cell"><button type="button" class="btn btn-link" data-toggle="modal" data-target="#ModalID<?php echo $newGetPCResults['unit_id'];?>"><?php echo $newGetPCResults['unit_name']; ?></button></td>
 				<td role="cell"><?php echo $newGetPCResults['lab_name']; ?></td>
 				<td role="cell"><?php echo $newGetPCResults['building_name'];?></td>
 				<td style="display: none;" role="cell"><?php echo ucfirst($newGetPCResults['status']);?></td>
				<td role="cell">
		<?php
				$getUnitID =  $newGetPCResults['unit_id'];
				$checkPeripheralExistence = $mysqli->query("SELECT * FROM peripherals WHERE unit_id = $getUnitID") or die ($mysqli->error);
				if(mysqli_num_rows($checkPeripheralExistence)==0){
					$noParts=true;
		?>
				<a target="_blank" href="add_peripheral.php?PcId=<?php echo $newGetPCResults['unit_id']; ?>" class="btn btn-primary btn-sm mb-1"><i class="far fa-plus-square"></i> Add PC Parts</a>
		<?php
				}
				else{
					$noParts=false;
		?>
				<a target="_blank" href="add_peripheral.php?PcId=<?php echo $newGetPCResults['unit_id']; ?>" class="btn btn-success btn-sm mb-1"><i class="far fa-edit"></i> Edit PC Parts</a>
		<?php			
				}
		?>
					<!-- Update 2019-09-25 add QR -->
					<!-- While the subdomain is not available, change the ip address -->
					<a target="_blank" class="btn btn-primary btn-sm mb-1 <?php if($noParts){echo 'not-active';} ?>" href="generate_qr.php?data=https://192.168.2.1/spcf-its/scan_qr.php?ispc=true$id=<?php echo $getUnitID; ?>" >
						<i class="fas fa-qrcode"></i>
						Generate QR
					</a>
					<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-trash-alt"></i> Delete
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
					You sure you want to delete? You cannot undo the changes<br/>
						<a href="process_unit_pc.php?delete=<?php echo $newGetPCResults['unit_id'] ?>" class='btn btn-danger btn-sm'><?php
						?><i class="far fa-trash-alt"></i> Confirm Delete</a>
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
				  	<a style='color: #5D4037;' class='btn btn-sm btn-warning' href="add_peripheral.php?PcId=<?php echo $unit_id;?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- End Modal For PC Equipments -->
 			<?php } ?>
 			</tbody>
		</table>

		<?php
		if(mysqli_num_rows($getPCResults)>=1){ ?>
			<a href="lab_report.php?<?php echo'building='.$buildingId.'&laboratory='.$labId; ?>" target="_blank" class="btn btn-sm btn-primary"><i class="fa fa-print" aria-hidden="true"></i>
 Generate Lab Report</a>
		<?php }  ?>
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
<style type="text/css">
	/*
	Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
	*/
.not-active {
	pointer-events: none;
	cursor: default;
	text-decoration: line-through;
	color: white;
}
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
		padding: 1%;
		width: 100%;
		border-bottom: 2px solid grey;
		border-top: 2px solid grey;
		background: #fcfce3;
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
	td:nth-of-type(1):before { content: "No:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "PC Name:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Laboratory:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Status:"; font-weight: bold; }
	td:nth-of-type(6):before { content: "Actions:"; font-weight: bold; }
}
</style>

<!-- EOF -->
