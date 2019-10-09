<?php
require_once 'process_unit_pc.php';
$currentItem = 'equipments';
include('sidebar.php');
//echo $date = date('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add / Edit PC Unit</title>
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
		include('topbar.php'); ?>
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
		$building_result = $mysqli->query('SELECT * FROM building') or die ($mysqli->error);
	?>
	
	<!-- Add Building Here -->
	<div class="card shadow row justify-content-center" style="padding: 1%;">
	<form action="process_unit_pc.php" method="POST">
	<h5 style='color: blue;'><center> Add PC Unit</center> </h5>
	
	<!-- Responsive Form -->
	<div class="row col-md-12 mb-2" style="">
		<div class="col-md-3 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Select Building</center></span>
			<select class="form-control"  onchange="location = this.value;">
				<option disabled selected>Select Building</option>
				<?php
					$building_id = null;
					if(isset($_GET['buildingId'])){
						$building_id = $_GET['buildingId'];
					}
					while($building_row=$building_result->fetch_assoc()){ ?>
				<option value="<?php echo 'unit_pc.php?buildingId='.$building_row['building_id'];?>" <?php if($building_id==$building_row['building_id']){echo 'selected';} ?>><?php echo $building_row['building_name'] ?>
				</option>
			<?php } ?>
			</select>			
		</div>
		<div class="col-md-3 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Laboratory / Room</center></span>
			<?php
			$noLab = true;
			if(isset($_GET['buildingId'])){
			$getBuildingID = $_GET['buildingId'];
			$noLab = false; 
 			$laboratoryName = $mysqli->query("SELECT * FROM laboratory WHERE building_id=$getBuildingID") or die ($mysqli->error);
 			if(mysqli_num_rows($laboratoryName)==0){
 				$noLab = true;
 			}
 			else{/* DO NOTHING*/}
 			}
 		?>
 			<select class="form-control" name="lab_id" <?php if($noLab==true){ echo 'disabled';} ?> required>
 			<?php
 			if($noLab==true){
 				echo "<option class=''>WARNING! Please add a Lab or Room to this building first</option>";
 			}
 			if(isset($_GET['buildingId'])){
 				while($getLaboratoryName=$laboratoryName->fetch_assoc()){
 					?>
 				<option value="<?php echo $getLaboratoryName['lab_id']?>"><?php echo $getLaboratoryName['lab_name']; ?></option>
 				<?php
 				}
 			}
 		?>
 			</select>
		</div>
		<div class="col-md-3 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>PC Qty.</center></span>
			<input max="30" min="1" type="number" name="unit_no" class="form-control" placeholder="Qty" required <?php if($noLab==true){ echo 'readonly';} ?> >
		</div>
		<div class="col-md-3 mb-1" style="padding: 1%; margin: auto;">
			<span class="font-weight-bold" style=""><center>Actions</center></span>
			<center>
				<button type="submit" class="btn btn-primary btn-sm mb-1" name="save" <?php if($noLab==true){echo "disabled";} ?>><i class="far fa-save"></i> Add Computers</button>
				<a href="unit_pc.php" id="refresh" class="btn btn-danger btn-sm mb-1"><i class="fas as fa-sync"></i> Clear/Refresh</a>
			</center>
		</div>
	</div>
	<!-- End Responsive Form -->
	<input type="text" style="visibility: hidden; max-height: 1px;" class="form-control" value="<?php if(isset($_GET['buildingId'])){echo $_GET['buildingId'];}?>" name="building_id" readonly>	
	</form>
	
	<!-- End Building Here -->
	<!-- Show Added Building Here-->
	<br/>
	<h5 class="form-control" style='color: blue;'>List of PC Unit (Preview - Latest Addition)</h5>
	<?php
	$thisPageFirstResult = 0;	
	$getPCResults = $mysqli->query("SELECT unit_pc.unit_id, unit_pc.unit_no, unit_pc.unit_name, unit_pc.date_added, laboratory.lab_name, building.building_name FROM unit_pc JOIN laboratory ON unit_pc.lab_id = laboratory.lab_id JOIN building ON unit_pc.building_id = building.building_id ORDER BY unit_pc.date_added DESC LIMIT 50") or die($mysqli->error());
	 ?>
	<div class="table-responsive">
		<table class="table" id="dataTable" width="100%" cellspacing="0">
			<thead>
				<tr>
					<th>No</th>
					<th>PC Name</th>
					<th>Laboratory</th>
					<th>Building</th>
					<th style="display: none;">Actions</th>
				</tr>
			</thead>
			<?php 
			while($newGetPCResults=$getPCResults->fetch_assoc()){?>
 			<tr>
 				<td><?php echo ++$thisPageFirstResult; ?></td>
 				<td><?php echo $newGetPCResults['unit_name']; ?></td>
 				<td><?php echo $newGetPCResults['lab_name']; ?></td>
 				<td><?php echo $newGetPCResults['building_name'];?></td>
 				<td style="display: none;"><a target='_blank' href="add_peripheral.php?PcId=<?php echo $newGetPCResults['unit_id']; ?>" class="btn btn-info btn-sm"><i class="far fa-edit"></i> Edit</a>
 					<!-- Start Drop down Delete here -->
					<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						Delete
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
					You sure you want to delete? You cannot undo the changes<br/>
						<a href="process_unit_pc.php?delete=<?php echo $row['building_id'] ?>" class='btn btn-danger btn-sm'>Confirm Delete</a>
						<a href="#" class='btn btn-success btn-sm'>Cancel</a> 
					</div>
 				</td>
 			</tr>
 			<?php } ?>
		</table>
	</div>
</div>			
	<br/>

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
}
</style>
<!-- EOF -->
