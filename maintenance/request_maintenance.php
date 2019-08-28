<?php
require_once 'process_maintenance.php';
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
	<title>Maintenance Request</title>

	<script src="libs/js/bootstrap.min.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>

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
		
		echo "<h5>Maintenance Request</h5>";
	?>
	<!-- Add Building Here -->
	<div class="row">
		<table class="table" width="100%">
			<form action="process_maintenance.php"  method="POST">
				<input type="text" name="id" value="<?php echo $id; ?>" style='visibility: hidden;'>
				<input type="text" name="username" value="<?php echo $requested_by; ?>" style='visibility: hidden;'>
			<tr>
				<th>Department</th>
				<th>Date</th>
			</tr>
			<tr>
				<td><input type="text" class="form-control" name="department" placeholder="Department Name" <?php if($editMaintenance==true){echo "value='$department' readonly";} ?> required></td>
				<td><input type="text" class="form-control" name="date" value="<?php if($editMaintenance==false){echo $currentDate; }else{echo $date;}?>" readonly></td>
			</tr>
		</table>
		<table class="table" width="100%">
			<tr style="text-align: center !important; <?php if($editMaintenance==true){echo 'visibility: hidden;';} ?>" >
				<th colspan="5">Nature</th>
			</tr>
			<tr <?php if($editMaintenance==true){echo "style='visibility: hidden;'";} ?>>
				<td  style="width: 20%;">
				<input type="hidden" id="" name="electrical"  value="0">
				<input type="checkbox" name="electrical" class="form-check-input" value='1' checked>
				Electrical</td>
				<td  style="width: 20%;">
				<input type="hidden" id="" name="mechanical"  value="0">
				<input type="checkbox" name="mechanical" class="form-check-input" value='1' />
				Mechanical</td>
				<td  style="width: 20%;">
				<input type="hidden" id="" name="carpentry"  value="0">
				<input type="checkbox" name="carpentry" class="form-check-input" value='1' />
				Carpentry</td>
				<td  style="width: 20%;">
				<input type="hidden" id="" name="janitorial"  value="0">
				<input type="checkbox" name="janitorial" class="form-check-input" value='1' />
				Janitorial</td>
				<td  style="width: 20%;" class="">
				<input type="hidden" id="" name="others"  value="0">
				<input type="checkbox" name="others" value='1' />
				Others:<br>
				<textarea name="others_text" class="form-control" placeholder="Others Text"></textarea>
				</td>
			</tr>
			<tr>
				<th colspan="5">Request: <textarea name="request" class="form-control" placeholder="Sample Text" <?php if($editMaintenance==true){ echo "readonly";} ?>><?php if($editMaintenance==true){ echo $request;} ?></textarea></th>
			</tr>
			<tr>
				<th colspan="5">Action Taken: <textarea name="action_taken" class="form-control" placeholder="Action Taken to be filled in by PPFO" <?php if($editMaintenance==false){echo "readonly";}?>></textarea></th>
			</tr>
			<tr style="text-align: center;">
				<?php if($editMaintenance==false){ ?>
					<td colspan="5"><button type="submit" class="btn btn-sm btn-primary" name="save"><i class="far fa-save"></i> Submit Request</button>
					<a href="request_maintenance.php" class="btn btn-sm btn-danger"><i class="fas as fa-sync"></i> Clear Fields</a>
				<?php } else { ?>
					<td colspan="5"><button type="submit" class="btn btn-sm btn-success" name="update"><i class="far fa-save"></i> Update Request</button>
				<?php } ?></td>
			</tr>
		</table>
	</form>
	</div>
	<!-- End Here-->
	<?php
	include('footer.php');
?>