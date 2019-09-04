<?php
require_once 'process_transfer_pc.php';
$currentItem = 'transfer';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
$currentDate = date("Y/m/d");
//$getURI = $_SERVER['QUERY_STRING'];
//echo $query; // Outputs: Query String
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Pulled Out Equipments</title>
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
		$getPulledOutPC = mysqli_query($mysqli, "SELECT et.equipment_id, et.date_added, b.building_name, l.lab_name, up.unit_name FROM equipment_transfer et  
			JOIN building b ON b.building_id = et.from_building
			JOIN laboratory l ON l.lab_id = et.from_lab
			JOIN unit_pc up ON up.unit_id =  et.equipment_id
			WHERE et.status='pending'");
	?>

	<div class="car shadow row" style="padding: 1%;">

	<h5 style='color: blue;'>Completed Transfer</h5>
	<?php $getPulledOutPC = mysqli_query($mysqli, "SELECT et.equipment_id, et.date_added, b1.building_name AS from_building, b2.building_name as to_building, l1.lab_name AS from_lab, l2.lab_name as to_lab, up.unit_name FROM equipment_transfer et  
			JOIN building b1 ON b1.building_id = et.from_building
            JOIN building b2 ON b2.building_id = et.to_building
			JOIN laboratory l1 ON l1.lab_id = et.from_lab
            JOIN laboratory l2 ON l2.lab_id = et.to_laboratory
			JOIN unit_pc up ON up.unit_id =  et.equipment_id
			WHERE et.status='completed' ");
	 ?>

	<table class="table display" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<th>ID</th>
			<th>Name</th>
			<th>From Building</th>
			<th>From Room</th>
			<th>To Building</th>
			<th>To Room</th>
			<th>Date</th>
		</thead>
		<tbody>
			<?php while($newPulledOutPC=$getPulledOutPC->fetch_assoc()){ 
				?>
			<tr>
				<td><?php echo $newPulledOutPC['equipment_id']; ?></td>
				<td><?php echo $newPulledOutPC['unit_name']; ?></td>
				<td><?php echo $newPulledOutPC['from_building']; ?></td>
				<td><?php echo $newPulledOutPC['from_lab']; ?></td>
				<td><?php echo $newPulledOutPC['to_building']; ?></td>
				<td><?php echo $newPulledOutPC['to_lab']; ?></td>
				<td><?php echo $newPulledOutPC['date_added']; ?></td>
			</tr>
			<?php } ?>
		</tbody>
	</table>	

	</div>

	<br/>
	<br/>
<?php
	include('footer.php');
?>