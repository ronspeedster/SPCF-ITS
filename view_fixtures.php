<?php
$currentItem='equipments';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
include('process_misc_things.php');
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Other Fixtures</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="js/demo/datatables-demo.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script type="text/javascript">
		$(document).ready(function() {
    $('#fixtureTable').DataTable( {
    	responsive: true,
    	"pageLength": 25,	
        "order": [[ 4, "desc" ]]
	    } );
	} );
	</script>	
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
<div class="card shadow row justify-content-center" style="padding: 1%; margin: 1%;">

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
		echo "<h5 style='color: blue;'>View Other Fixtures</h5>";
	?>
	<!-- Add Building Here -->
	<br/>
	
	<?php
		$fileName = basename($_SERVER['PHP_SELF']);
		if(!isset($_GET['type'])){
			$current_type = '*';
			$type='All Types';
		}
		else{
			$current_type = $_GET['type'];
			if($current_type=='*'){
				$type = 'All Types';
			}
			else{
				$type = $current_type;	
			}	
		}


		// Get Categories
		$getCategories = mysqli_query($mysqli, "SELECT DISTINCT type FROM fixture WHERE type <> 'airconditioner' ");
	?>

	<table class="table">
		<tr>
			<th style="text-align: right;">Select Type: </th>
			<th>
				<select class="form-control" onchange="location = this.value;">
					<option disabled selected>Select Fixture</option>
					<?php while($newCategories=$getCategories->fetch_assoc()){  ?>
					<option value="<?php echo $fileName.'?type='.$newCategories['type'];?>"><?php echo strtoupper($newCategories['type']); ?></option>
					<?php } ?>
					<option value="<?php echo $fileName.'?type=*';?>">All Type</option>
				</select>
			</th>
		</tr>
	</table>
	<h5 style="color: blue;" class="form-control">List of Fixtures</h5>
	<div class='row justify-content-center'>
	<?php
	if($current_type=="*"){
		//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND remarks='ForRepair'");
		$getFixture = mysqli_query($mysqli, "SELECT f.*, b.building_name, l.lab_name FROM fixture f
		JOIN building b
		ON b.building_id = f.building_id
		JOIN laboratory l
		ON l.lab_id = f.lab_id WHERE type <> 'airconditioner' ");
	}
	else{
		//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND peripheral_type='$current_type' AND remarks='ForRepair'");
		$getFixture = mysqli_query($mysqli, "SELECT f.*, b.building_name, l.lab_name FROM fixture f
		JOIN building b
		ON b.building_id = f.building_id
		JOIN laboratory l
		ON l.lab_id = f.lab_id
		WHERE type='$current_type' AND type <> 'airconditioner' ");
	}
	?>
	<table class="table" id="fixtureTable" width="100%" cellspacing="0">
	<thead> 
		<tr>
			<th>Type</th>
			<th>Batch Code</th>
			<th>Serial Code</th>
			<th>Building</th>
			<th>Room / Laboratory</th>
			<th>Condition</th>
			<th>Actions</th>
		</tr>
	</thead>
			<?php
			if(mysqli_num_rows($getFixture)==0){
				echo "<div class='alert alert-warning'>No ".$current_type." currently for repair</div>";
			}
			else{
				while($newFixture=$getFixture->fetch_assoc()){ ?>
		<tr>
			<td><?php echo strtoupper($newFixture['type']); ?></td>
			<td><?php echo $newFixture['batch_code']; ?></td>
			<td><?php if($newFixture['serial_no']==''){echo "<span class='text-danger'>NO SC</span>";}else{echo $newFixture['serial_no'];} //echo $newFixture['serial_no']; ?></td>
			<td><?php echo $newFixture['building_name']; ?></td>
			<td><?php echo $newFixture['lab_name']; ?></td>
			<td><?php echo strtoupper($newFixture['fixture_condition']); ?></td>
			<td>
			<a class="btn btn-success btn-secondary btn-sm" href="<?php echo 'report_peripherals.php?peripheral_id='.$perripheral_row['peripheral_id'].'&is_fix=true'; ?>"><i class="far fa-edit"></i> Edit</a>
			<button style="display: none;" class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			<i class="far fa-trash-alt"></i> Delete
					</button><div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
					You sure you want to delete? You cannot undo the changes<br/>
						<a href="process_misc_things.php?delete=<?php echo $perripheral_row['peripheral_id'] ?>" class='btn btn-danger btn-sm'><i class="far fa-trash-alt"></i> Confirm Delete</a>
						<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> 
			</div></td>
		</tr>
			<?php	
				}}
			?>
	</table>
	</div>
</div>
	<!-- End Here-->
	<?php
	include('footer.php');
?>