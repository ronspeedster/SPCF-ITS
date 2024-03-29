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
	<title>Edit Aircon</title>
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

		if(isset($_GET['id'])){
			$editting=true;
			$id = $_GET['id'];
		}

	?>

	<!-- Add Fixtures Here -->
	<div class="card row shadow" style="padding: 1%;">
		<?php
			if($editting==false){
				echo "<meta http-equiv='Refresh' content='2; url=fixtures.php'/>";
				echo "<span class='text-danger'>No Fixture is Selected! Redirecting you</span>";
			}
			else{
			?>
			<label class="form-control">
				<a class="" href='aircon.php'><-- Back to Air Conditioners </a>
			</label>
			<h5 style="color: blue;"> Edit <?php echo $id.'. AIRCONDITIONER'; ?></h5>
			<?php
				$getFixture = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.remarks, fe.date_last_clean, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
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
				$last_date_clean = $newFixture['date_last_clean'];
				$getBuilding = mysqli_query($mysqli, "SELECT * FROM building");

				$getLaboratories = mysqli_query($mysqli, "SELECT * FROM laboratory WHERE building_id='$building_id'");
				$noLab = false;
				if(mysqli_num_rows($getLaboratories)==0){
					$noLab = true;
				}
				//print_r($newFixture); ?>
				<form action="process_aircon.php" method="POST" style="width: 100%;">
				<table class="table" width="100%;">
					<thead>
						<tr>
							<th style="display: none;">Type</th>
							<th>Serial No.</th>
							<th>Brand</th>
							<th>AC Type</th>
							<th style="display: none;">Building</th>
							<th style="display: none;">Laboratories</th>
							<th style="width: 5%;">Last Cleaned (Date)</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td width="5%" style="display: none;"><?php echo strtoupper($newFixture['type']); ?></td>
							<td><input type="text" name="serial_no" class="form-control" placeholder="Serial-No" value="<?php echo $serial_no; ?>" required>
								</td>
							<td ><input type="text" name="brand" class="form-control" placeholder="Brand" required></td>
							<td><select name="ac_type" class="form-control">
								<option value="window">Window</option>
								<option value="split_air">Split Air</option>
								<option value="duct_less">Ductless</option>
								<option value="central">Central Air</option>
								<option value="tower">Tower</option>
								<option value="wall-mounted">Wall Mounted</option>
								<option value="ceiling-mounted">Ceiling Mounted</option>
								<option value="floor-mounted">Floor Mounted</option>
								<option value="casette">Casette</option>
							</select></td>
							<td width="5%" style="display: none;">
								<select class="form-control" onchange="location = this.value;" disabled>
								<?php while ($newBuilding = $getBuilding->fetch_assoc()){
									$new_building_id = $newBuilding['building_id'];
									?> 
									<option value='<?php echo $getURI.'&building_id='.$new_building_id; ?>' <?php if($building_id==$new_building_id){ echo "Selected";} ?> ><?php echo $newBuilding['building_name']; ?></option>
								<?php } ?>
							</select>
							<input type="text" class="form-control" style="visibility: hidden;"  name="building_id" value="<?php echo $building_id; ?>">
						</td>
							<td width="5%" style="display: none;">
								<select name="lab_id" class="form-control" disabled>
								<?php
									if($noLab==true){ echo "<option disabled selected>WARNING: NO LAB / ROOM</option>"; } 
									while ($newLaboratory = $getLaboratories->fetch_assoc()){
									$lab_id = $newLaboratory['lab_id']; ?>
									<option value='<?php echo $lab_id; ?>' <?php if($lab_id==$fixture_lab_id){ echo "Selected";} ?> ><?php echo $newLaboratory['lab_name']; ?></option>
								<?php } ?>
							</select>
							</td>
							<td>
								<input type="date" name="date_last_clean" class="form-control" min="<?php echo $last_date_clean; ?>" required>
							</td>
							<td>
								
								<!-- Start Drop down Delete here -->
								<button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="far fa-save" ></i>  Update Aircon
								</button>
								<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding: 10px !important; font-size: 14px;">
									Proceed? You cannot undo the changes<br/>
								<button name="update" type="submit" class="btn btn-sm btn-primary" <?php if($noLab==true){ echo 'disabled';}?> > <i class="far fa-save" ></i> Confirm Update</button>
								<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
							</div>
							</td>
						</tr>
					</tbody>
				</table>
				<input type="text" name="fixture_id" style="visibility: hidden;" value="<?php echo $id; ?>">
				</form>
			
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
		background: #fcfce3;
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
	td:nth-of-type(1):before { content: "Type.:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Serial No.:"; font-weight: bold;}
	td:nth-of-type(3):before { content: "Brand:"; font-weight: bold; }
	td:nth-of-type(4):before { content: "AC Type:"; font-weight: bold; }
	td:nth-of-type(5):before { content: "Building:"; font-weight: bold; }
	td:nth-of-type(6):before { content: "Laboratories:"; font-weight: bold; }
	td:nth-of-type(7):before { content: "Last Cleaned (Date):"; font-weight: bold; }
	td:nth-of-type(8):before { content: "Actions: "; font-weight: bold; }
}
</style>
<!-- EOF -->
