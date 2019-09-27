<?php
require_once 'process_aircon.php';
$currentItem = 'equipments';
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
	<title>View Air-con</title>
	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	
	<script type="text/javascript">
		$(document).ready(function() {
    $('#airconTable').DataTable( {
        "order": [[ 7, "asc" ]],
        "pageLength": 50
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

	<div class="car shadow row" style="padding: 1%;">

	<h5 style='color: blue;'>Air Conditioners</h5>

	<table class="table" id="airconTable" cellspacing="0">
		<thead>
			<th style="width: 5%;">ID</th>
			<th style="display: none;">Type</th>
			<th style="display: none;">Batch Code</th>
			<th style="width: 10%;">Serial No</th>
			<th style="width: 10%;">Building</th>
			<th style="width: 10%;">Room</th>
			<th style="width: 15%;">Date Last Cleaned</th>
			<th style="width: 15%;">Next Cleaning</th>
			<th style="width: 15%;">Actions</th>
		</thead>
		<tbody>
			<?php while($newFixtures=$getFixtures->fetch_assoc()){
				$lastCleanDate = date_create($newFixtures['date_last_clean']);
				$lastCleanDateA = $newFixtures['date_last_clean'];
				$newDate = date('Y/m/d', strtotime($lastCleanDateA. ' + 166 days'));
				//echo $newDate;
				if($currentDate>=$newDate){
					$newDate = "<span class='text-danger'>".$newDate.' ('.date_format(date_create($newDate), 'F j, Y').')'."</span>";
					//$newDate = "<span class='text-danger'>".$newDate."</span>";
				}
				else{
					//$newDate = "<span class='text-primary'>".date_format(date_create($newDate), 'F j, Y')."</span>";
					$newDate = "<span class='text-primary'>".$newDate."</span>";
				}
				?>
			<tr>
				<td><?php echo $getAirconID = $newFixtures['id']; ?></td>
				<td style="display: none;"><?php echo strtoupper($newFixtures['type']); ?></td>
				<td style="display: none;"><?php echo $newFixtures['batch_code']; ?></td>
				<td><?php if($newFixtures['serial_no']==''){echo "<font color='red'>NO SN</font>";} else { echo $newFixtures['serial_no']; }?></td>
				<td><?php echo $newFixtures['building_name']; ?></td>
				<td><?php echo $newFixtures['lab_name']; ?></td>
				<td><?php echo date_format($lastCleanDate, 'F j, Y'); ?></td>
				<td><?php echo $newDate;?></td>
				<td>
					<a class="btn btn-info btn-sm mb-1" href="edit_aircon.php?id=<?php echo $newFixtures['id'];?>&building_id=<?php echo $newFixtures['building_id']; ?>"><i class="far fa-edit"></i> Edit</a>
					<!-- Update 2019-09-25 add QR -->
					<!-- While the subdomain is not available, change the ip address -->
					<a class="btn btn-primary btn-sm mb-1" href="generate_qr.php?data=https://192.168.2.1/spcf-its/scan_qr.php?isaircon=true$id=<?php echo $getAirconID; ?>"><i class="fas fa-qrcode"></i> Generate QR</a>
					<a style='color: #5D4037;' class='btn btn-sm btn-warning mb-1' href="report_fixture.php?fixture_id=<?php echo $newFixtures['id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
				</td>
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