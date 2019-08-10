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
<body>
<div class="container">
	<?php
	/*$result = mysqli_query($mysqli, "SELECT * FROM building");
	$fetchid =0;
	while ($res = mysqli_fetch_array($result)) {
	$res['building_id'];
	$fetchid = $res['building_id'];
}*/
	include('topbar.php');
?>

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
		if(isset($_GET['lab_iD'])){
			$labId=$_GET['lab_iD'];
		}
		else{
			$labId = null;
		}
	?>
	
	<!-- Add Building Here -->
	<div class="row justify-content-center">
	<form action="#" method="POST">
	<h3>
	</h3>
	<table class='table'>
		<thead>
			<tr>
				<td colspan="2"><center><h4>Search PC Unit</h4></center></td>
			</tr>
			<tr>
					<th>Select Building</th>
					<th>Laboratory / Room</th>
					<th></th>
			</tr>
			<tr>
				 <!-- Start Drop down Building Selection -->
				<td>
					<button class="btn btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<?php 
							if(isset($_GET['buildingId'])){
								$getBuildingID = $_GET['buildingId'];
								$buildingName = $mysqli->query("SELECT * FROM building WHERE building_id=$getBuildingID") or die ($mysqli->error);
								while ($newBuildingName=$buildingName->fetch_assoc()) {
									echo "<i class='far fa-building'></i> ".$newBuildingName['building_name'];
								}
							}
							else{
								echo "<i class='far fa-building'></i> "."Buildings";
							}
						?>
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
						<?php while($building_row=$building_result->fetch_assoc()){
							?>
							<a href="edit_pc_equipment.php?buildingId=<?php echo $building_row['building_id'] ?>" class="btn-success btn-sm"><?php echo $building_row['building_name'] ?></a>
						<?php }
						?>
					</div>
 				</td>
 				<!-- End Building Selection -->
 				<!-- Start Lab Drop Down Selection -->
 				<td>
 					<select class="form-control" name="lab_id" onchange="location = this.value;">
 						<option selected="selected" value="#">Select Laboratories Below</option>
 						<?php
 							if(isset($_GET['buildingId'])){
 							$buildingId =	$_GET['buildingId'];
 							$labId = $_GET['labId'];
 							$laboratoryName = $mysqli->query("SELECT * FROM laboratory WHERE building_id=$getBuildingID") or die ($mysqli->error);
 							if(mysqli_num_rows($laboratoryName)==0){
 										echo "<option value='#' class=''>WARNING! Please add a Lab to this building first</option>";
 							}
 							else{/* DO NOTHING*/}
 							while($getLaboratoryName=$laboratoryName->fetch_assoc()){
 								$getLabId = $getLaboratoryName['lab_id'];
 								?><option value="<?php echo 'edit_pc_equipment.php?buildingId='.$buildingId.'&labId='.$getLaboratoryName['lab_id']?>"><?php echo $getLaboratoryName['lab_name']; ?></option>
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
	</div>		
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
		$getPCResults = $mysqli->query("SELECT unit_pc.unit_id, unit_pc.unit_no, unit_pc.unit_name,unit_pc.status, laboratory.lab_name, building.building_name FROM unit_pc JOIN laboratory ON unit_pc.lab_id = laboratory.lab_id JOIN building ON unit_pc.building_id = building.building_id WHERE unit_pc.building_id = $buildingId AND unit_pc.lab_id = $labId LIMIT $thisPageFirstResult, $resultsPerPage") or die($mysqli->error());
		if(mysqli_num_rows($getPCResults)==0){
			echo "<h5 class='alert alert-danger'>It appears that this laboratory doesn't house any computers as of the moment.</h5>";
		}
	 echo "	<div class='row justify-content-center'>";
	

	?>
<label class="form-control">List of PC Units (Page <?php echo $page;?>)</label>
		<table class='table'>
			<thead>
				<tr>
					<th>No</th>
					<th>PC Name</th>
					<th>Laboratory</th>
					<th>Building</th>
					<th>Status</th>
					<th colspan="2">Actions</th>
				</tr>
			</thead>
			<?php 
			while($newGetPCResults=$getPCResults->fetch_assoc()):?>
 			<tr>
 				<td><?php echo ++$thisPageFirstResult; ?></td>
 				<td><?php echo $newGetPCResults['unit_name']; ?></td>
 				<td><?php echo $newGetPCResults['lab_name']; ?></td>
 				<td><?php echo $newGetPCResults['building_name'];?></td>
 				<td><?php echo ucfirst($newGetPCResults['status']);?></td>
<!--  				<td><a href="add_peripheral.php" class="btn btn-primary btn-sm"><i class="far fa-edit"></i> Edit</a></td>
 				<td><a target="_blank" href="add_peripheral.php?PcId=<?php echo $newGetPCResults['unit_id']; ?>" class="btn btn-primary btn-sm"><i class="far fa-plus-square"></i> Add PC Parts</a></td> -->
				 <!-- Start Drop down Delete here -->
				 <td>
		<?php
				$getUnitID =  $newGetPCResults['unit_id'];
				$checkPeripheralExistence = $mysqli->query("SELECT * FROM peripherals WHERE unit_id = $getUnitID") or die ($mysqli->error);
				if(mysqli_num_rows($checkPeripheralExistence)==0){
		?>
				<a target="_blank" href="add_peripheral.php?PcId=<?php echo $newGetPCResults['unit_id']; ?>" class="btn btn-primary btn-sm"><i class="far fa-plus-square"></i> Add PC Parts</a>
		<?php
				}
				else{
		?>
				<a target="_blank" href="add_peripheral.php?PcId=<?php echo $newGetPCResults['unit_id']; ?>" class="btn btn-success btn-sm"><i class="far fa-edit"></i> Edit PC Parts</a>					
		<?php			
				}
		?>		
				</td>
				<td>
					<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
 			<?php endwhile; ?>
 			<tr>
 				<td colspan="5"></td>
 			</tr>
 			<tr>
 				<td colspan="5"><center>Page <?php echo $page.' of '.$numberOfPages;?>
 				<?php
 				if (isset($_GET['page'])){
 					if($page == '1'){
 						//Do nothing
 					}
 					else{	
 				?>	<a class="btn-success btn-sm" href="<?php echo ''.$getURI.'&page='.--$page.''; ?>"><i class="fa fa-angle-left" aria-hidden="true"></i></a>
 				<?php 	} 
 					}
 				?>
 				<?php
 					for($page=1; $page<=$numberOfPages; $page++){
 						echo '<a class="btn-success btn-sm" class="" href="'.$getURI.'&page='.$page.'">'.$page.'</a> ';
 					}
 				if(isset($_GET['page'])){
 				if($_GET['page'] == $numberOfPages){
 					// Do nothing
 				}
 				else{
 					$page = $_GET['page'];
 					?>
 					<a class="btn-success btn-sm" href="<?php echo ''.$getURI.'&page='.++$page.''; ?>"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
 					<?php
 					}
 				}
 				?>
 			</center>
 				</td>
 			</tr>
		</table>
	</div><?php
}
else{
		echo "<h5 class='alert alert-warning'>Select Building and Laboratory First</h5>";
	}
	?>
	
	<br/>
	<?php
		function pre_r($array){
			echo "<pre>";
			print_r($array);
			echo "</pre>";
		}
	?>
	<!-- End PC Equipment Views Here-->
	<?php
	include('footer.php');
?>