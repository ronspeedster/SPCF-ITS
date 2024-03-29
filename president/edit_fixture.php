<?php
require_once 'process_fixture.php';
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
	<title>Edit Fixture</title>
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
		$editting = false;

		if(isset($_GET['type']) && isset($_GET['id']) && isset($_GET['building_id'])){
			$editting=true;
			$type = $_GET['type'];
			$id = $_GET['id'];
		}

	?>

	
	<!-- Add Fixtures Here -->
	<div class="row">
		<?php
			if($editting==false){
				echo "<meta http-equiv='Refresh' content='2; url=fixtures.php'/>";
				echo "<span class='text-danger'>No Fixture is Selected! Redirecting you</span>";
			}
			else{
			?>
			<label class="form-control"><a class="" href='fixtures.php'><-- Back to Fixtures </a></label>
			<br/> <br/> <br/>
			<h5 style='color: blue;'> Edit <?php echo $id.'. '. strtoupper($type); ?></h5>
			<br/><br/>
			<?php
				$getFixture = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.remarks, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
					FROM fixture fe
					JOIN building bg
					ON bg.building_id = fe.building_id
					JOIN laboratory ly
					ON ly.lab_id = fe.lab_id
					WHERE fe.id = '$id'");
				$newFixture = $getFixture->fetch_assoc();
				$fixture_building_id = $newFixture['building_id'];
				$serial_no = $newFixture['serial_no'];
				$building_id = $_GET['building_id'];
				$fixture_lab_id = $newFixture['lab_id'];

				$getBuilding = mysqli_query($mysqli, "SELECT * FROM building");

				$getLaboratories = mysqli_query($mysqli, "SELECT * FROM laboratory WHERE building_id='$building_id'");
				$noLab = false;
				if(mysqli_num_rows($getLaboratories)==0){
					$noLab = true;
				}
				//print_r($newFixture); ?>
				
				<table class="table" width="100%;">
				<form action="process_fixture.php" method="POST">
					<tr>
						<th>Type</th>
						<th>Serial No.</th>
						<th>Building</th>
						<th>Laboratories</th>
						<th>Actions</th>
					</tr>
					<tr>
						<td><?php echo strtoupper($newFixture['type']); ?></td>
						<td><input type="text" name="serial_no" class="form-control" placeholder="Serial-No" value="<?php echo $serial_no; ?>" required>
							<input type="text" name="fixture_id" style="visibility: hidden;" value="<?php echo $id; ?>"></td>
						<td><select class="form-control" onchange="location = this.value;">
							<?php while ($newBuilding = $getBuilding->fetch_assoc()){
								$new_building_id = $newBuilding['building_id'];
								?> 
								<option value='<?php echo $getURI.'&building_id='.$new_building_id; ?>' <?php if($building_id==$new_building_id){ echo "Selected";} ?> ><?php echo $newBuilding['building_name']; ?></option>
							<?php } ?>
						</select>
						<input type="text" class="form-control" style="visibility: hidden;"  name="building_id" value="<?php echo $building_id; ?>">
					</td>
						<td>
							<select name="lab_id" class="form-control">
							<?php
								if($noLab==true){ echo "<option disabled selected>WARNING: NO LAB / ROOM</option>"; } 
								while ($newLaboratory = $getLaboratories->fetch_assoc()){
								$lab_id = $newLaboratory['lab_id']; ?>
								<option value='<?php echo $lab_id; ?>' <?php if($lab_id==$fixture_lab_id){ echo "Selected";} ?> ><?php echo $newLaboratory['lab_name']; ?></option>
							<?php } ?>
						</select>
						</td>
						<td>
							
							<!-- Start Drop down Delete here -->
							<button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<i class="far fa-save" ></i>  Update Fixture
							</button>
							<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding: 10px !important; font-size: 14px;">
								Proceed? You cannot undo the changes<br/>
							<button name="update" type="submit" class="btn btn-sm btn-primary" <?php if($noLab==true){ echo 'disabled';}?> > <i class="far fa-save" ></i> Confirm Update</button>
							<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
						</div>
						</td>
					</tr>
				</form>
				</table>

			
			<?php 
			}
			 ?>

		<!-- Show Added Fixtures -->

	</div>

	<br/>
	<br/>


	<?php
	include('footer.php');
?>