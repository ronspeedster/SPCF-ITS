<?php
require_once 'dbh.php';
$currentItem = 'forms';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;
$currentDate = date_default_timezone_set('Asia/Manila');
$currentDate = date('Y/m/d');
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Maintenance Request</title>

	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script type="text/javascript">
		$(document).ready(function() {
    $('#dataTable').DataTable( {
        "order": [[ 2, "desc" ]]
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
		$getMaintenanceRequests = $mysqli->query('SELECT * FROM maintenance') or die ($mysqli->error);
		
	?>
	<!-- Add Building Here -->
	<div class="card shadow row" style="padding: 1%">
		<h5>View Maintenance Request</h5>
		<table id="dataTable" class="table" width="100%">
			<thead>
				<th>ID</th>
				<th>Department</th>
				<th>Date Requested</th>
				<th>Request</th>
				<th>Action Taken</th>
				<th>Requested by</th>
				<th>Date Action Taken</th>
				<th>No of Days</th>
				<th>Actions</th>
			</thead>
			<?php while($newMaintenanceRequest=$getMaintenanceRequests->fetch_assoc()){
				$date1 = date_create($newMaintenanceRequest['date_requested']);
				$date2 = date_create($newMaintenanceRequest['date_action_taken']);
				?>
			<tr>
				<td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#ModalID<?php echo $newMaintenanceRequest['id'];?>"><?php echo $newMaintenanceRequest['id']; ?></button></td>
				<td><?php echo $newMaintenanceRequest['department']; ?></td>
				<td><?php echo $newMaintenanceRequest['date_requested']; ?></td>
				<td><?php echo $newMaintenanceRequest['request']; ?></td>
				<td><?php echo $newMaintenanceRequest['action_taken']; ?></td>
				<td><?php echo $newMaintenanceRequest['requested_by']; ?></td>
				<td><?php echo $newMaintenanceRequest['date_action_taken']; ?></td>
				<td><?php echo ($diff = date_diff($date1,$date2))->format('%a');?></td>
				<td><a target='_blank' href="request_maintenance.php?edit=<?php echo $newMaintenanceRequest['id']; ?>" class="btn btn-info btn-sm"><i class="far fa-edit"></i> Edit</a>
					<!-- Start Drop down Delete here -->
					<button class="btn btn-danger btn-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						<i class="far fa-trash-alt"></i> Delete
					</button>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton btn-sm">
					You sure you want to delete? You cannot undo the changes<br/>
						<a href="process_maintenance.php?delete=<?php echo $newMaintenanceRequest['id'] ?>" class='btn btn-danger btn-sm'><i class="far fa-trash-alt"></i> Confirm Delete</a>
						<a href="#" class='btn btn-success btn-sm'><i class="far fa-window-close"></i> Cancel</a> </td>
			</tr>
			<!-- Modal For Request Here -->
			<div class="modal fade" id="ModalID<?php echo $newMaintenanceRequest['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			  <div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLongTitle">Request ID: <?php echo $newMaintenanceRequest['id'].' by '.$newMaintenanceRequest['requested_by']; ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					  <span aria-hidden="true">&times;</span>
					</button>
				  </div>
				  <div class="modal-body">
					<!-- Contents Here -->
					<u>Additional Information:</u><br/>
					Janitorial: <?php if($newMaintenanceRequest['janitorial']==1){echo "<font color='green'>YES</font>";} else{echo "<font color='red'>NO</font>";} ?><br/>
					Electrical: <?php if($newMaintenanceRequest['electrical']==1){echo "<font color='green'>YES</font>";} else{echo "<font color='red'>NO</font>";} ?><br/>
					Mechanical: <?php if($newMaintenanceRequest['mechanical']==1){echo "<font color='green'>YES</font>";} else{echo "<font color='red'>NO</font>";} ?><br/>
					Carpentry: <?php if($newMaintenanceRequest['carpentry']==1){echo "<font color='green'>YES</font>";} else{echo "<font color='red'>NO</font>";} ?><br/>
					Others: <?php echo "<font color='green'>".$newMaintenanceRequest['others_text'].'</font>'; ?>

				  </div>
				  <div class="modal-footer">
					<button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
				  </div>
				</div>
			  </div>
			</div>
			<!-- End Modal For Request Here -->
			<?php } ?>
		</table>

	</div>
	<!-- End Here-->
	<?php
	include('footer.php');
?>
<!-- EOF -->
