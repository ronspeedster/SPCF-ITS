<?php
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$counter=1;
$department = '';
$electrical = '';
$mechanical = '';
$carpentry = '';
$janitorial = '';
$others = '';
$others_text = '';
$request = '';
$action_taken = '';
$date_requested ='';
$userName='';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Maintenance Print Forms</title>
	<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&display=swap" rel="stylesheet">  
	<style type="text/css">
	.topbar {
	    height: 3rem !important;
	}
	  html{
	  font-family: 'Roboto Condensed', sans-serif !important;
	  font-size: 12px;
	  }
	  input.date{
	    width: 10px;
	  }
	#dataTable_wrapper {
	    width: 100% !important;
	}
	.bg-gradient-primary {
	    background-color: #0f1e5d !important;
	    background-image: none !important;
	    background-image: none !important;
	    background-size: cover !important;
	}
	.page-item.active .page-link {
	    z-index: 1;
	    color: #fff;
	    background-color: #0f1e5d !important;
	    border-color: #0f1e5d !important;
	}
	.container-fluid{
	  background-color: white;
	  padding-left: 5% !important;
	  padding-right: 5% !important;
	}
	#content-wrapper{
	  background-color: white !important;
	}
	.table{
		color: black !important;
	}
	.table-borderless > tbody > tr > td,
	.table-borderless > tbody > tr > th,
	.table-borderless > tfoot > tr > td,
	.table-borderless > tfoot > tr > th,
	.table-borderless > thead > tr > td,
	.table-borderless > thead > tr > th {
	    border: none;
	}
	::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
	  opacity: 0.7 !important; /* Firefox */
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
<?php
	if(isset($_GET['department'])){
		$department = $_GET['department'];
		$electrical = $_GET['electrical'];
		$mechanical = $_GET['mechanical'];
		$carpentry = $_GET['carpentry'];
		$janitorial = $_GET['janitorial'];
		$others = $_GET['others'];
		$others_text = $_GET['others_text'];
		$request = $_GET['request'];
		$action_taken = $_GET['action_taken'];
		$date_requested = $_GET['date'];
		$userName = $_GET['userName'];
	}
while($counter<=3){$counter++;
?>
	<div style="padding: 1%; height: 4.5in" class="row justify-content-center">
	<table class='table table-borderless' width="100%">
		<tr>
			<td>
				<img src="img/logo.png" style="width: 0.75in;" align="right">
			</td>
			<td style="text-align: center; width: 40% !important;">
				<h3>Systems Plus College Foundation</h3>
				<h5>PHYSICAL PLANT AND AND FACILITIES FORM</h5>
				<h3 class="font-weight-bold">MAINTENANCE REQUEST FORM</h3>
			</td>
			<td><img src="img/PPFO.png" style="width: 0.75in;"></td>
		</tr>
	</table>
	<table class="table table-borderless" width="100%" style="border-bottom: 1px dotted black !important;">
		<tr>
			<td colspan="5" style="text-align: left !important; width: 70%;">
				<b>Department:</b> <?php echo "<span style='font-size: 14px !important;'>".$department."</span>"; ?><div style="width: 100%; border-bottom: 1px solid black;"></div>
			</td>
			<td>
				<b>Date:</b> <?php echo "<span style='font-size: 14px !important;'>".$date_requested."</span>"; ?><div style="width: 100%; border-bottom: 1px solid black;"></div>
			</td>
		</tr>
		<tr>
			<td>
				<b>Nature:</b>
			</td>
			<td>
				<input type="checkbox" name="" <?php if($electrical==1){echo 'checked';} ?> disabled>
				Electrical
			</td>
			<td>
				<input type="checkbox" name="" <?php if($mechanical==1){echo 'checked';} ?> disabled>
				Mechanical
			</td>
			<td>
				<input type="checkbox" name="" <?php if($carpentry==1){echo 'checked';} ?> disabled>
				Carpentry
			</td>
			<td>
				<input type="checkbox" name="" <?php if($janitorial==1){echo 'checked';} ?> disabled>
				Janitorial
			</td>
			<td>
				<input type="checkbox" name="" <?php if($others==1){echo 'checked';} ?> disabled>
				Others: <?php echo $others_text; ?><div style="width: 100%; border-bottom: 1px solid black;"></div>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<b>Request:</b> <?php echo "<span style='font-size: 14px !important;'>".$request."</span>"; ?>
				<div style="width: 100%; border-bottom: 1px solid black;"></div><br>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<b>Action Taken:</b> <?php echo $action_taken; ?>
				<div style="width: 100%; border-bottom: 1px solid black;"></div><br>
			</td>
		</tr>
		<tr>
			<td colspan="3">
				<b>Prepared By:</b> <?php echo $userName; ?>
				<div style="width: 60%; border-bottom: 1px solid black;"></div><br>
			</td>
			<td colspan="3">
				<b>Approved By:</b> 
				<div style="width: 60%; border-bottom: 1px solid black;"></div>
				PPFO
			</td>
		</tr>		
	</table>
</div>
<?php  } ?>
</body>
</html>
<!-- EOF -->
