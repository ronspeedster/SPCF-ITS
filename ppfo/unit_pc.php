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
	<div class="row justify-content-center">
	<form action="process_unit_pc.php" method="POST">
	<h5 style='color: blue;'><center><?php /*
		if($update_building==true){
			echo "<h4>Edit ".$building_name."</h4>";
		}
		else{
			echo "<h4>Add Building</h4>";
		}*/
		?>
		Add PC Unit
	</h5>
	<table class='table'>
		<thead>
			<tr>
					<th>Select Building</th>
					<th>Laboratory / Room</th>
					<th>PC Qty.</th>
					<th colspan="2">Actions </th>
			</tr>
			<tr>
				 <!-- Start Drop down Building Selection -->
				<td>
					<select class="form-control"  onchange="location = this.value;">
						<option disabled selected>Select Building</option>
						<?php 
						$building_id = null;
						if(isset($_GET['buildingId'])){
							$building_id = $_GET['buildingId'];
						}
						while($building_row=$building_result->fetch_assoc()){ ?>
							<option value="<?php echo 'unit_pc.php?buildingId='.$building_row['building_id'];?>" <?php if($building_id==$building_row['building_id']){echo 'selected';} ?>><?php echo $building_row['building_name'] ?></option>
						<?php } ?>
					</select>
 				</td>
 				<!-- End Building Selection -->
 				<!-- Start Lab Drop Down Selection -->
 				<td>
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
 							echo "<option class=''>WARNING! Please add a Lab or Room to this building first</option>";}
 						if(isset($_GET['buildingId'])){
 							while($getLaboratoryName=$laboratoryName->fetch_assoc()){
 								?>
 								<option value="<?php echo $getLaboratoryName['lab_id']?>"><?php echo $getLaboratoryName['lab_name']; ?></option>
 						<?php
 								}
 							}	
 						?>
 					</select>
 					<input style="visibility: hidden;" class="form-control" value="<?php if(isset($_GET['buildingId'])){echo $_GET['buildingId'];}?>" name="building_id" readonly>
 				</td>
					<td><input max="30" min="1" type="number" name="unit_no" class="form-control" placeholder="Qty" required <?php if($noLab==true){ echo 'readonly';} ?>></td>
					<td>
					<button type="submit" class="btn btn-primary btn-sm" name="save" <?php if($noLab==true){echo "disabled";} ?>><i class="far fa-save"></i> Add Computers</button>
					</td>
					<td><a href="unit_pc.php" id="refresh" class='btn btn-danger btn-sm'><i class="fas as fa-sync"></i> Clear/Refresh</a></th></td>
			</tr>
		</thead>
	</table>
		
		
	</form>
	</div>		
	<!-- End Building Here -->
	<!-- Show Added Building Here-->
	<br/>
	<h5 class="form-control" style='color: blue;'>List of PC Unit (Preview)</h5>
	<?php
		$getPCResults = $mysqli->query("SELECT unit_pc.unit_no, unit_pc.unit_name, laboratory.lab_name, building.building_name FROM unit_pc JOIN laboratory ON unit_pc.lab_id = laboratory.lab_id JOIN building ON unit_pc.building_id = building.building_id") or die($mysqli->error());
		//$numberPreview = 1;
		$resultsPerPage = 10;
		$numberOfResults = mysqli_num_rows($getPCResults);
		$numberOfPages = ceil($numberOfResults/$resultsPerPage);
		if(!isset($_GET['page'])){
			$page = 1;
		}
		else{
			$page = $_GET['page'];
		}
		$thisPageFirstResult = ($page-1)*$resultsPerPage;
		$getPCResults = $mysqli->query("SELECT unit_pc.unit_id, unit_pc.unit_no, unit_pc.unit_name, unit_pc.date_added, laboratory.lab_name, building.building_name FROM unit_pc JOIN laboratory ON unit_pc.lab_id = laboratory.lab_id JOIN building ON unit_pc.building_id = building.building_id ORDER BY unit_pc.date_added DESC") or die($mysqli->error());
	 ?>
	<div class='row justify-content-center'>
		<table class='table' id="dataTable" width="100%" cellspacing="0">
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
			while($newGetPCResults=$getPCResults->fetch_assoc()):?>
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
						<a href="eprocess_unit_pc.php?delete=<?php echo $row['building_id'] ?>" class='btn btn-danger btn-sm'>Confirm Delete</a>
						<a href="#" class='btn btn-success btn-sm'>Cancel</a> 
					</div>
 				
 			</tr>
 			<?php endwhile; ?>
		</table>
	</div>
	
	<br/>
	<?php
		function pre_r($array){
			echo "<pre>";
			print_r($array);
			echo "</pre>";
		}
	?>
	<!-- End Added Building Here-->
	<?php
	include('footer.php');
?>