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
	<script src="libs/js/bootstrap.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	
	<script type="text/javascript">
		$(document).ready(function() {
			$('#airconTable').DataTable( {
				"order": [[ 5, "asc" ]],
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

    <div class="card shadow row" style="padding: 1%;">

	<h5 style="color: blue;">Air Conditioners</h5>

	<table class="table" id="airconTable" role="table">
		<thead role="rowgroup">
			<tr role="row">
				<th role="columnheader" >ID</th>
				<th role="columnheader" >Serial No</th>
				<th role="columnheader" >Building</th>
				<th role="columnheader" >Room</th>
				<th role="columnheader" >Date Last Cleaned</th>
				<th role="columnheader" >Next Cleaning</th>
				<th role="columnheader" >Actions</th>
			</tr>
		</thead>
		<tbody role="rowgroup">
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
			<tr role="row">
				<td role="cell"><?php echo $getAirconID = $newFixtures['id']; ?></td>
				<td role="cell"><?php if($newFixtures['serial_no']==''){echo "<span style='color: red;'>NO SN</span>";} else { echo $newFixtures['serial_no']; }?></td>
				<td role="cell"><?php echo $newFixtures['building_name']; ?></td>
				<td role="cell"><?php echo $newFixtures['lab_name']; ?></td>
				<td role="cell"><?php echo date_format($lastCleanDate, 'F j, Y'); ?></td>
				<td role="cell"><?php echo $newDate;?></td>
				<td role="cell">
					<a class="btn btn-info btn-sm mb-1" href="edit_aircon.php?id=<?php echo $newFixtures['id'];?>&building_id=<?php echo $newFixtures['building_id']; ?>"><i class="far fa-edit"></i> Edit</a>
					<!-- Update 2019-09-25 add QR -->
					<!-- While the subdomain is not available, change the ip address -->
					<a class="btn btn-primary btn-sm mb-1" href="generate_qr.php?data=https://192.168.2.1/spcf-its/scan_qr.php?isaircon=true$id=<?php echo $getAirconID; ?>"><i class="fas fa-qrcode"></i> QR Code</a>
					<a style='color: #5D4037;' class='btn btn-sm btn-warning mb-1' href="report_fixture.php?fixture_id=<?php echo $newFixtures['id']?>" target='_blank'><i class="fas fa-bug"></i> Report</a>
					<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm mb-1" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-trash-alt"></i> Delete
					</button>
					<div class="dropdown-menu shadow" aria-labelledby="dropdownMenuButton btn-sm" style="padding: 10px !important; font-size: 14px;">
						You sure you want to delete? You cannot undo the changes<br/>
						<a href="process_fixture.php?delete=<?php echo $getAirconID; ?>" class='btn btn-danger btn-sm mb-1'><i class="far fa-trash-alt"></i> Confirm Delete</a>
						<a class="btn btn-success btn-sm mb-1" style="color: white;"><i class="far fa-window-close"></i> Cancel</a> 
					</div>					
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
	td:nth-of-type(1):before { content: "ID:"; font-weight: bold;}
	td:nth-of-type(2):before { content: "Serial No:"; font-weight: bold; }
	td:nth-of-type(3):before { content: "Building: "; font-weight: bold; }
	td:nth-of-type(4):before { content: "Room: "; font-weight: bold; }
	td:nth-of-type(5):before { content: "Date Last Cleaned: "; font-weight: bold; }
	td:nth-of-type(6):before { content: "Next Cleaning: "; font-weight: bold; }
	td:nth-of-type(7):before { content: "Actions: "; font-weight: bold; }
}
</style>
<!-- EOF -->
