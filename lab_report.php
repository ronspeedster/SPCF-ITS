<?php
include('dbh.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
$currentDate = date_default_timezone_set('Asia/Manila'); 
$currentDate = date('Y-m-d');
	if(isset($_GET['building'])){
		$buildingId=$_GET['building'];
		$labId=$_GET['laboratory'];
		$getBuilding = $mysqli->query(" SELECT * FROM building WHERE building_id='$buildingId' ") or die($mysqli->error());
		$newBuilding = $getBuilding->fetch_array();
		$getLaboratory = $mysqli->query(" SELECT * FROM laboratory WHERE lab_id='$labId' ") or die($mysqli->error());
		$newLaboratory = $getLaboratory->fetch_array();


		$getPCResults = $mysqli->query("SELECT unit_pc.unit_id, unit_pc.unit_no, unit_pc.unit_name,unit_pc.status, laboratory.lab_name, building.building_name FROM unit_pc JOIN laboratory ON unit_pc.lab_id = laboratory.lab_id JOIN building ON unit_pc.building_id = building.building_id WHERE unit_pc.building_id = $buildingId AND unit_pc.lab_id = $labId") or die($mysqli->error());
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Lab Summary <?php echo  $newBuilding['building_name'].' - '.$newLaboratory['lab_name'].' '.$currentDate;?></title>
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&display=swap" rel="stylesheet">  
<style type="text/css">
.topbar {
	height: 3rem !important;
}
html{
	font-family: 'Roboto Condensed', sans-serif !important;
	font-size: 11px !important;
}
table{
	font-size: 12px !important;
}
input.date{
	width: 10px;
}
#dataTable_wrapper {
	width: 100% !important;
}
.table{
		color: black !important;
}
</style>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="icon" href="img/favicon.png" type="image/gif" sizes="16x16"> 
	<!-- Custom styles for this template-->
	<link href="css/sb-admin-2.min.css" rel="stylesheet">

	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>
<body id="page-top">
<a target="_blank" href="request_maintenance.php"><- Get Back</a> Hit CRTL + P to PRINT
	<div style="padding: 1%;" class="row justify-content-center">
		<table class="table" style="width: 100% !important;">
			<thead>
				<tr>
					<td style="width: 30%;"><img src="img/logo.png" style="width: 0.75in;" align="right"></td>
					<td style="text-align: center; width: 40% !important;">
						<b style="font-size: 20px">Systems Plus College Foundation</b><br/><b>BALIBAGO, ANGELES CITY</b><br>INFORMATION TECHNOLOGY SERVICES
					</td>
					<td><img src="img/ITS.png" style="width: 0.75in;" align="left"></td>
				</tr>
			</thead>
				<tr>
					<td style="text-align: center;" colspan="3"><h5><b>Building:</b> <u><i><?php echo $newBuilding['building_name']; ?></i></u><b> Laboratory: </b><u><i><?php echo $newLaboratory['lab_name']; ?></i></u> Date: <u><i><?php echo date_format(date_create($currentDate), 'F j, Y'); ?></i></u></h5></td>
				</tr>
		</table>
		<table class="table table-bordered" style="width: 100% !important;" >
			<thead>
				<tr>
						<th>PC#</th>
						<th>Item /Equipment</th>
						<th>Serial Number</th>
						<th>Description</th>
						<th>Status</th>
						<th>Date Purchased</th>
				</tr>
			</thead>
			<?php while($newGetPCResults=$getPCResults->fetch_assoc()){
				$getUnitID =  $newGetPCResults['unit_id'];
				$getPeripherals = $mysqli->query("SELECT * FROM peripherals WHERE unit_id=$getUnitID") or die ($mysqli->error());
				$peripheral_rows =  mysqli_num_rows($getPeripherals);
			?>
			<tr>
				<td rowspan="<?php echo ++$peripheral_rows; ?>"><b><?php echo $newGetPCResults['unit_name'];  ?></b></td>
			</tr>
				<?php while($newPeripherals=$getPeripherals->fetch_assoc()){ ?>
				<tr>
					<td><?php echo $newPeripherals['peripheral_type'];  ?></td>
					<td><?php echo $newPeripherals['peripheral_serial_no'];  ?></td>
					<td><?php echo $newPeripherals['peripheral_description'];  ?></td>
					<td><?php echo $newPeripherals['peripheral_condition'];  ?></td>
					<td><?php echo $newPeripherals['peripheral_date_purchased'];  ?></td>
				</tr>
				<?php } ?>
			<?php } ?>
		</table>

		<table style="color: black !important;"> 
			<tr>
				<td><br/><br/>
					<center><u><h5>Attested by: MARVIN REYES, MIT</h5></u></center>
				</td>
			</tr>
			<tr>
				<td>
					<center><h5>ITS Head</h5></center>
				</td>
			</tr>
		</table>
		
	</div>

</body>
</html>