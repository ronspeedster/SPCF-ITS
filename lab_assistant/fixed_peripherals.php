<?php
$currentItem='fixed_equipment';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
include('process_misc_things.php');
$account_id = $_SESSION['account_id'];
?>
<!DOCTYPE html>
<html>
<head>
	<title>For Repair Peripherals</title>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script src="../js/demo/datatables-demo.js"></script>
	<link href="../vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
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
		echo "<h5 style='color: blue;'>Fixed PC Peripherals and Components</h5>";
	?>
	<!-- Add Building Here -->
	<div class="row justify-content-center">
	<form action="process_misc_things.php" method="POST">
	</form>
	</div>
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
	?>

	<table class="table">
		<tr>
			<th style="text-align: right;">Select Type: </th>
			<th>
					
				<select class="form-control" onchange="location = this.value;">
					<option class="text-danger" disabled selected><?php echo $type; ?></option>
					<option value="<?php echo $fileName.'?type=*';?>">All Types</option>
					<option value="<?php echo $fileName.'?type=Monitor';?>">Monitor</option>
					<option value="<?php echo $fileName.'?type=Keyboard';?>">Keyboard</option>
					<option value="<?php echo $fileName.'?type=Mouse';?>">Mouse</option>
					<option value="<?php echo $fileName.'?type=AVR';?>">AVR</option>
					<option value="<?php echo $fileName.'?type=Headset';?>">Headset</option>
					<option value="<?php echo $fileName.'?type=CPU';?>">CPU</option>
					<option value="<?php echo $fileName.'?type=Motherboard';?>">Motherboard</option>
					<option value="<?php echo $fileName.'?type=GPU';?>">GPU</option>
					<option value="<?php echo $fileName.'?type=RAM';?>">RAM</option>
					<option value="<?php echo $fileName.'?type=HDD';?>">HDD</option>
				</select>
			</th>
		</tr>
	</table>
	<h5 style="color: blue;" class="form-control">List of PC Equipments Fixed</h5>
	<div class='row justify-content-center'>
	<?php
	if($current_type=="*"){
		//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND remarks='ForRepair'");
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals p
			JOIN unit_pc u ON p.unit_id = u.unit_id
			JOIN laboratory l ON u.lab_id = l.lab_id
			JOIN building b ON b.building_id = l.building_id
			JOIN designation d ON d.building_id = b.building_id
			WHERE p.remarks = 'Fixed' AND d.account_id='$account_id' ");
	}
	else{
		//$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals WHERE unit_id='StockRoom' AND peripheral_type='$current_type' AND remarks='ForRepair'");
		$getStockRooms = mysqli_query($mysqli, "SELECT * FROM peripherals p
			JOIN unit_pc u ON p.unit_id = u.unit_id
			JOIN laboratory l ON u.lab_id = l.lab_id
			JOIN building b ON b.building_id = l.building_id
			JOIN designation d ON d.building_id = b.building_id
			WHERE p.remarks = 'Fixed' AND d.account_id='$account_id' AND peripheral_type='$current_type' ");
	}
	?>
	<table class="table" id="dataTable" width="100%" cellspacing="0">
	<thead>
		<tr>
			<th>Type</th>
			<th>Brand</th>
			<th>Description</th>
			<th>Serial ID</th>
			<th>Building</th>
			<th>Laboratory</th>
			<th>Condition</th>
			<th>Remarks</th>
		</tr>
	</thead>
			<?php
			if(mysqli_num_rows($getStockRooms)==0){
				echo "<div class='alert alert-warning'>No ".$current_type." fixed</div>";
			}
			else{
				while($perripheral_row=$getStockRooms->fetch_assoc()){ ?>
		<tr>
			<td><?php echo $perripheral_row['peripheral_type']; ?></td>
			<td><?php echo $perripheral_row['peripheral_brand']; ?></td>
			<td><?php echo $perripheral_row['peripheral_description']; ?></td>
			<td><?php echo $perripheral_row['peripheral_serial_no']; ?></td>
			<td><?php echo $perripheral_row['building_name']; ?></td>
			<td><?php echo $perripheral_row['lab_name']; ?></td>
			<td><?php echo $perripheral_row['peripheral_condition']; ?></td>
			<td><?php echo $perripheral_row['remarks']; ?></td>
		</tr>
			<?php	
				}}
			?>
	</table>
	</div>

	<!-- End Here-->
	<?php
	include('footer.php');
?>