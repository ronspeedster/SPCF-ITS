<?php
require_once 'process_aircon.php';
$currentItem = 'aircon';
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
	<title>Aircon</title>
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
		$getFixtures = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.date_last_clean ,fe.remarks, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
			FROM fixture fe
			JOIN building bg
			ON bg.building_id = fe.building_id
			JOIN laboratory ly
			ON ly.lab_id = fe.lab_id
			WHERE fe.type ='airconditioner'
			ORDER BY fe.date_added DESC
			");
	?>

	<div class="row">

	<label><h4>Air Conditioners</h4></label>

	<table class="table" id="dataTable" width="100%" cellspacing="0">
		<thead>
			<th>ID</th>
			<th>Type</th>
			<th>Batch Code</th>
			<th>Serial No</th>
			<th>Building</th>
			<th>Room</th>
			<th>Date Last Cleaned</th>
			<th>Next Cleaning</th>
			<th>Actions</th>
		</thead>
		<tbody>
			<?php while($newFixtures=$getFixtures->fetch_assoc()){
				$lastCleanDate = date_create($newFixtures['date_last_clean']);
				$lastCleanDateA = $newFixtures['date_last_clean'];
				$newDate = date('Y/m/d', strtotime($lastCleanDateA. ' + 166 days'));
				if($currentDate>=$newDate){
					$newDate = "<span class='text-danger'>".date_format(date_create($newDate), 'F j, Y')."</span>";
				}
				else{
					$newDate = "<span class='text-primary'>".date_format(date_create($newDate), 'F j, Y')."</span>";
				}
				?>
			<tr>
				<td><?php echo $newFixtures['id']; ?></td>
				<td><?php echo strtoupper($newFixtures['type']); ?></td>
				<td><?php echo $newFixtures['batch_code']; ?></td>
				<td><?php echo $newFixtures['serial_no']; ?></td>
				<td><?php echo $newFixtures['building_name']; ?></td>
				<td><?php echo $newFixtures['lab_name']; ?></td>
				<td><?php echo date_format($lastCleanDate, 'F j, Y'); ?></td>
				<td><?php echo $newDate;?></td>
				<td><a class="btn btn-info btn-sm" href="edit_aircon.php?id=<?php echo $newFixtures['id'];?>&building_id=<?php echo $newFixtures['building_id']; ?>"><i class="far fa-edit"></i> Edit</a></td>
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