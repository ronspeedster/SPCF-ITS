<?php
require_once 'dbh.php';
$currentItem = '';
$protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$_SESSION['getURI'] = $getURI;

//echo $getURI = str_replace('$', '&', $getURI);
//echo $getURI = str_replace('scan_qr', 'view_qr', $getURI);

//header("location: ".$getURI);

$currentDate = date_default_timezone_set('Asia/Manila');
$currentDate = date('Y/m/d');

if(isset($_GET['ispc'])){
  $ispc = true;
  $id = $_GET['id'];


  //print_r($getPCInformation);
}
else if(isset($_GET['isfixture'])){
  $isfixture = true;
  $id = $_GET['id'];
}
else if(isset($_GET['isaircon'])){
  $isaircon = true;
  $id = $_GET['id'];
}
else{
  header("location: index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Roboto+Condensed:400,700&display=swap" rel="stylesheet">  
<style type="text/css">
.dropdown-menu{
  padding: 10px !important;
}
.topbar {
    height: 3rem !important;
}
  html{
  font-family: 'Roboto Condensed', sans-serif !important;
  font-size: 13.5px;
  }
  input.date{
    width: 10px;
  }

#dataTable_wrapper,#fixtureTable_wrapper, #airconTable_wrapper {
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
::placeholder { /* Chrome, Firefox, Opera, Safari 10.1+ */
  opacity: 0.7 !important; /* Firefox */
}
</style>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  

  <!-- Custom fonts for this template-->
  
  <link rel="icon" href="img/favicon.png" type="image/gif" sizes="16x16"> 
  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion toggled" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
          <!-- <i class="fas fa-laugh-wink"></i> -->
        </div>
        <div class="nav-item">SPCF-IS</div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item <?php if($currentItem=='dashboard'){echo 'active';}?>">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Actions
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php if($currentItem=='building'){echo 'active';} ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#buildings" aria-expanded="true" aria-controls="buildings">
          <i class="fas fa-fw fa-building"></i>
          <span>Buildings</span>
        </a>
        <div id="buildings" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Customize Buildings:</h6>
            <a class="collapse-item" href="building.php"><i class="fas fa-fw fa-building"></i> Add / Edit Buildings</a>
            <a class="collapse-item" href="laboratories.php"><i class="fas fa-person-booth"></i> Add / Edit Laboratories and Rooms</a>
             <a class="collapse-item" href="view_buildings.php"><i class="fas fa-eye"></i> View Buildings, Labs and Rooms</a>
          </div>
        </div>
      </li>

      <!-- Nav Items - Equipments -->
      <li class="nav-item <?php if($currentItem=='equipments'){echo 'active';} ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#equipments" aria-expanded="true" aria-controls="equipments">
          <i class="fas fa-toolbox"></i>
          <span>Equipments</span>
        </a>
        <div id="equipments" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Customize Computers:</h6>
            <a class="collapse-item" href="unit_pc.php"><i class="fas fa-laptop"></i> Add PC Units</a>
            <a class="collapse-item" href="edit_pc_equipment.php"><i class="fas fa-eye"></i> View PC Equipments</a>
            <h6 class="collapse-header">Customize Fixtures:</h6>
            <a class="collapse-item" href="fixtures.php"><i class="fas fa-couch"></i> Add / Edit Fixtures</a>
            <a class="collapse-item" href="aircon.php"><i class="fas fa-fan"></i> View Air Conditioners</a>
            <a class="collapse-item" href="view_fixtures.php"><i class="fas fa-eye"></i> View Other Fixtures</a>
          </div>
        </div>
      </li>

      <!-- Nav Items - Repair -->
      <li class="nav-item <?php if($currentItem=='for_repair'){echo 'active';} ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#repair" aria-expanded="true" aria-controls="equipments">
          <i class="fas fa-tools"></i>
          <span>For Repairs</span>
        </a>
        <div id="repair" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">View For Repairs:</h6>
            <a class="collapse-item" href="for_repair.php"><i class="fas fa-laptop"></i> View For Repair PC Peripherals</span></a>
            <a class="collapse-item" href="for_repair_fixtures.php"><i class="fas fa-couch"></i> View For Repair Fixtures</a>
          </div>
        </div>
      </li>

      <!-- Nav Items - Fixed Equipment -->
      <li class="nav-item <?php if($currentItem=='fixed_equipment'){echo 'active';} ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#fixed_equipment" aria-expanded="true" aria-controls="equipments">
          <i class="fas fa-band-aid"></i>
          <span>Fixed Equipments</span>
        </a>
        <div id="fixed_equipment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">View Fixed Equipments:</h6>
            <a class="collapse-item" href="fixed_peripherals.php"><i class="fas fa-laptop"></i> Fixed PC Peripherals</span></a>
            <a class="collapse-item" href="fixed_fixtures.php"><i class="fas fa-couch"></i> Fixed Fixtures</a>
          </div>
        </div>
      </li>

      <!-- Nav Items - Fixed Equipment -->
      <li class="nav-item <?php if($currentItem=='transfer'){echo 'active';} ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#equipment_transfer" aria-expanded="true" aria-controls="equipments">
          <i class="fas fa-dolly-flatbed"></i>
          <span>Equipment Transfer</span>
        </a>
        <div id="equipment_transfer" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Pull Out Equipments:</h6>
            <a class="collapse-item" href="transfer_pc.php"><i class="fas fa-laptop"></i> Pullout PC Unit </span></a>
            <a class="collapse-item" href="transfer_fixtures.php"><i class="fas fa-couch"></i> Pullout Fixtures</a>
            <h6 class="collapse-header">Transfer Equipments:</h6>
            <a class="collapse-item" href="pulled_out.php"><i class="fas fa-eye"></i> View Pulled out Equipments</a>
            <a class="collapse-item" href="completed_transfer.php"><i class="fas fa-eye"></i> View Completed Transfer</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Stock Rooms -->
      <li class="nav-item <?php if($currentItem=='stock_room'){echo 'active';} ?>">
        <a class="nav-link" href="stock_room.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Stock Room</span></a>
      </li>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php if($currentItem=='forms'){echo 'active';} ?>">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#forms" aria-expanded="true" aria-controls="equipments">
          <i class="fas fa-print"></i>
          <span>Forms</span>
        </a>
        <div id="forms" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">SELECT FORMS:</h6>
            <a class="collapse-item" href="view_maintenance.php"><i class="fas fa-eye"></i> View Request</a>
            <a class="collapse-item" href="request_maintenance.php"><i class="fa fa-file" aria-hidden="true"></i> New Maintenance Request</a>
          </div>
        </div>
      </li>      
      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="far fa-user-circle"></i>
          <span>Accounts</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">CUSROMIZE USER ACCOUNTS:</h6>
            <a class="collapse-item" href="accounts.php"><i class="fas fa-plus"></i> Add / Edit Accounts</a>
            <a class="collapse-item" href="account_designation.php"><i class="fas fa-info"></i> Designate Accounts</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">
      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->
<!DOCTYPE html>
<html>
<head>
  <title>View QR Code</title>
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
<!-- Topbar -->
 <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top" style="background-color: #424242 !important;">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3" style="color: white;">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Search -->
          <form style="visibility: hidden;" class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
              </div>
            </div>
          </form>
          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <div class="topbar-divider d-none d-sm-block"></div>

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="text-white mr-2 d-none d-lg-inline text-white-600 medium"></span><i class="text-white fas fa-user-circle"></i>
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-600"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- End of Topbar -->
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
  
    

  ?>
  <!-- Add Building Here -->
  <div class="card shadow row" style="padding: 1%">
    <h3>QR Code Result</h3>
    <h4 class="btn btn-lg btn-success text-uppercase font-weight-bold"><center>Specs</center></h4>
  <?php

        $getPCInformation = $mysqli->query("SELECT *
          FROM peripherals p
          JOIN unit_pc up
          ON p.unit_id = up.unit_id
          JOIN laboratory l
          ON l.lab_id = up.lab_id
          JOIN building b
          ON b.building_id = up.building_id
          WHERE p.unit_id = '$id'
        ") or die ($mysqli->error);

        while($newPCInformation=$getPCInformation->fetch_assoc()){ ?>
          <span style="margin-top: 1rem; text-align: center;">
            <?php echo $newPCInformation['peripheral_type'].': '.$newPCInformation['peripheral_brand']; ?>
            <?php if($newPCInformation['remarks']=='For Repair'){echo "<font color='red'>".$newPCInformation['remarks']."</font>";}else{echo "<font color='green'>".'Working'."</font>";} ?>            
          </span>
      <?php
      $buildingName = $newPCInformation['building_name'];
      $roomName = $newPCInformation['lab_name'];
      $unitName = $newPCInformation['unit_name'];
    } ?>
    
    <span style="text-align: center; margin-top: 2rem;">
      <h4 class="btn btn-block btn-lg btn-success"><b>PC: <?php echo $unitName; ?></b></h4><br/>
      <h5 class="btn btn btn-block btn-warning btn-lg text-uppercase">Building: <b><?php echo $buildingName; ?></b>
        ,Room: <b><?php echo $roomName; ?></b></h5>
    </span>
  </div>
  <!-- End Here-->
  <?php
  include('footer.php');
?>