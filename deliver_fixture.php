<?php
require_once 'process_fixture.php';
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
	<title>Deliver Fixture</title>
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

		$building_id = 0;
		if(isset($_GET['deliver'])){
			$equipment_id = $_GET['equipment_id'];
			$type = $_GET['type'];
		}

		if(isset($_GET['building_id'])){
			$transfer_id = $_GET['transfer_id'];
			$building_id = $_GET['building_id'];
		}
		$getBuilding = mysqli_query($mysqli, "SELECT * FROM building");
		$getLaboratories = mysqli_query($mysqli, "SELECT * FROM laboratory WHERE building_id='$building_id'");
			if(mysqli_num_rows($getLaboratories)==0){
					$noLab = true;
				}
			else{
				$noLab = false;
			}
	?>

	<!-- Add Fixtures Here -->
	<div class="row card shadow" style="padding: 1%;">	
			<label class="form-control"><a class="" href='pulled_out.php'><-- Back to Pulled Out Equipments </a></label>
			<form action="process_transfer_pc.php" method="POST">
				<table class="table" width="100%;">
					<thead>
						<tr>
							<th>Type</th>
							<th>Building</th>
							<th>Laboratories</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td><?php echo $type; ?></td>
							<td><select class="form-control" onchange="location = this.value;">
								<option disabled selected>Select Building</option>
								<?php while ($newBuilding = $getBuilding->fetch_assoc()){
									$new_building_id = $newBuilding['building_id'];
									?> 
									<option value='<?php echo $getURI.'&building_id='.$new_building_id; ?>' <?php if($new_building_id==$building_id){echo 'selected';} ?> ><?php echo $newBuilding['building_name']; ?></option>
								<?php } ?>
								</select>
							</td>
							<td>
								<select name="lab_id" class="form-control"	>
									<?php
										if($noLab==true){ echo "<option disabled selected>WARNING: NO LAB / ROOM</option>"; } 
										while ($newLaboratory = $getLaboratories->fetch_assoc()){
										$lab_id = $newLaboratory['lab_id']; ?>
										<option value='<?php echo $lab_id; ?>'><?php echo $newLaboratory['lab_name']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td>
								<button class="btn btn-primary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<i class="far fa-save" ></i>  Update Equipment </button>
									<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="padding: 10px !important; font-size: 14px;">
										Proceed Process? You cannot undo the changes once transfered<br/>
									<button name="transfer_fixture" type="submit" class="btn btn-sm btn-primary" <?php if($noLab==true){ echo 'disabled';}?> > <i class="far fa-save" ></i> Confirm Update</button>
									<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
								</div>	
							</td>

						</tr>
					</tbody>
				</table>
				<input type="text" name="equipment_id" style="visibility: hidden;" value="<?php echo $equipment_id; ?>">
				<input type="text" name="building_id" style="visibility: hidden;" value="<?php echo $building_id; ?>">
				<input type="text" name="transfer_id" style="visibility: hidden;" value="<?php echo $transfer_id; ?>">				
			</form>

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
	td:nth-of-type(1):before { content: "Type:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Building:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Laboratories: "; font-weight: bold; }
	td:nth-of-type(4):before { content: "Actions: "; font-weight: bold; }
}
</style>
<!-- EOF -->
