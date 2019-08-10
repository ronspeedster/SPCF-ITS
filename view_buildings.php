<?php

require_once 'dbh.php';
$currentItem = 'building';
include('sidebar.php');
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

$getBuildings = mysqli_query($mysqli, "SELECT * FROM building ORDER BY building_name ASC");
$id = 1;
if(!isset($_GET['id'])){
	$buildingID = 1;
}
else{
	$buildingID = $_GET['id'];
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Buildings and Laboratories</title>

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
		
		echo "<h5 style=''>View Buildings and Laboratories</h5>";
	?>

	<ul class="nav">
		<?php //echo $tab_menu; ?>
	</ul>
	<!-- Add Building Here -->
	<div class="row">
	<select class="form-control" onchange="location = this.value;">
		<option selected disabled>Select Building</option>
	<?php
	if(isset($_GET['id'])){
		$id=$_GET['id'];
	}
	while ($newBuildings=$getBuildings->fetch_assoc()) {
		$buildingName[$newBuildings['building_id']] = $newBuildings['building_name']; ?>
		<option value="<?php echo "view_buildings.php?id=".$newBuildings['building_id']; ?>" <?php if($id==$newBuildings['building_id']){echo 'selected disabled';} ?>><?php echo $newBuildings['building_name']; ?></option>
	<?php } ?>
	</select>
	<?php	
	echo "<div class='card-header' style='width: 100%;'><center><i>Laboratories and Roooms in ".$buildingName[$buildingID].'</i></center></div>';
	$getLabInfo = "SELECT * FROM laboratory WHERE building_id=$buildingID";
	$labResult = mysqli_query($mysqli, $getLabInfo);
	echo "<div style='height: 10% !important; width: 100%;'><br></div>";
	if(mysqli_num_rows($labResult)==0){
			echo "<div class='alert alert-danger' style='width: 100%;'>No Existing Laboratories or Rooms!<a href='#' class='close' data-dismiss='alert' aria-label='close'><!--&times;--></a></div>";
		}		
		else{
			while($newLabResult=$labResult->fetch_assoc()){
			$labID = $newLabResult['lab_id']; 
		?>
		    <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary text-uppercase mb-1"><a style='color: #192e86 !important;' target='_blank' href="edit_pc_equipment.php?buildingId=<?php echo  $newLabResult['building_id'];?>&labId=<?php echo $newLabResult['lab_id']; ?>"><?php echo $newLabResult['lab_name'];?></a><br/><br/></div>
                      <div class="text-s mb-0 text-gray-800"><?php echo 'Description: '.ucfirst($newLabResult['lab_description']).'<br><br>'; ?></div>
                      <div class="text-s mb-0 text-gray-800"><?php 
                      		$countPC = mysqli_query($mysqli, "SELECT COUNT(lab_id) FROM unit_pc WHERE lab_id='$labID'");
                      		$countAircon = mysqli_query($mysqli, "SELECT COUNT(lab_id) FROM fixture WHERE lab_id='$labID' AND type='airconditioner'");
                      		$newPC = $countPC->fetch_assoc();
                      		$newAircon = $countAircon->fetch_assoc();
                      		
                      		if($newPC['COUNT(lab_id)']==0){
                      			echo "<a href='unit_pc.php?buildingId=".$newLabResult['building_id']."' target='_blank'>+ Add PC</a><br/>";
                      		}
                      		else{
                      		echo "Total number of PC: ".$newPC['COUNT(lab_id)'].'<br/>';
                      		}

                      		if($newAircon['COUNT(lab_id)']==0){
                      			echo "<a href='fixtures.php' target='_blank'>+ Add Aircon</a>";
                      		}
                      		else{
                      		echo "Aircon: ".$newAircon['COUNT(lab_id)'].'<br/>';
                      		}
                       ?></div>
                    </div>
                    <div class="col-auto">
                    </div>
                  </div>
                </div>
              </div>
            </div>
	<?php
			}
		}
	?>
		    <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="h5 font-weight-bold text-primary text-uppercase mb-1">ADD NEW LAB or ROOM</div>
                      <div class="text-s mb-0 text-gray-800" style="text-align: center;"><br/><a target="_blank" href="laboratories.php?<?php echo 'addLab='.$buildingID;?>"><i class="fas fa-plus" style="font-size: 60px;"></i></a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>	
</div>
	<!-- End Here-->
	<?php
	include('footer.php');
?>