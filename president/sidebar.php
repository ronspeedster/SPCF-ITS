<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }

    if(!isset($_SESSION['account'])){
      header("Location: login.php");
    }

    if($_SESSION['account'] == 'user'){
      header("Location: users");
    }
    else if($_SESSION['account'] == 'lab_assistant'){
      header("Location: ../lab_assistant");
    }
    //else if($_SESSION['account'] == 'president'){
     // header("Location: president");
    //}
    else if($_SESSION['account'] == 'maintenance'){
      header("Location: ../maintenance");
    }
    else if($_SESSION['account'] == 'ppfo'){
      header("Location: ../ppfo");
    }
    else {
      // Do nothing
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
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
  <link href="../css/sb-admin-2.min.css" rel="stylesheet">

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
     
     <!-- Nav Item - Requests -->
      <li class="nav-item <?php if($currentItem=='equipments'){echo 'active';} ?>">
        <a class="nav-link" href="edit_pc_equipment.php">
          <i class="fas fa-laptop"></i>
          <span>PC Reports</span></a>
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
            <h6 class="collapse-header">View Fixed Equioments:</h6>
            <a class="collapse-item" href="fixed_peripherals.php"><i class="fas fa-laptop"></i> Fixed PC Peripherals</span></a>
            <a class="collapse-item" href="fixed_fixtures.php"><i class="fas fa-couch"></i> Fixed Fixtures</a>
          </div>
        </div>
      </li>  
      <!-- Nav Item - Stock Rooms -->
      <li class="nav-item <?php if($currentItem=='stock_room'){echo 'active';} ?>">
        <a class="nav-link" href="view_stock_room.php">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Stock Room</span></a>
      </li>

      <!-- Nav Item - Aircon -->
      <li class="nav-item <?php if($currentItem=='equipments'){echo 'active';} ?>">
        <a class="nav-link" href="aircon.php">
          <i class="fas fa-fan"></i>
          <span>Aircon</span></a>
      </li>

      <!-- Nav Item - Requests -->
      <li class="nav-item <?php if($currentItem=='forms'){echo 'active';} ?>">
        <a class="nav-link" href="view_maintenance.php">
          <i class="fas fa-print"></i>
          <span>Requests</span></a>
      </li>
      
      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php if($currentItem=='building'){echo 'active';} ?>" style='display: none;'>
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
      <li class="nav-item <?php if($currentItem=='equipments'){echo 'active';} ?>" style='display: none;'>
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
            <a class="collapse-item" href="misc_things.php" style="display: none;">Add / Edit Misc. Things</a>
          </div>
        </div>
      </li>

    
      <!-- Nav Item - Pages Collapse Menu -->
      <li style="display: none;" class="nav-item <?php if($currentItem=='aircon'){echo 'active';} ?>">
        <a class="nav-link" href="aircon.php">
          <i class="fas fa-fan"></i>
          <span>Air Conditioner</span>
        </a>
      </li>

      <!-- Nav Item - Equipment Transfer -->
      <li class="nav-item" style="display: none;">
        <a class="nav-link" href="#">
          <i class="fas fa-dolly-flatbed"></i>
          <span>Equipment Transfer</span></a>
      </li>


      <!-- Nav Item - Defective Equipment -->
      <li style="display: none;" class="nav-item <?php if($currentItem=='defect_equipment'){echo 'active';} ?>">
        <a class="nav-link" href="defect_equipment.php">
          <i class="fas fa-fw fa-unlink"></i>
          <span>Defective Equipment</span></a>
      </li>

      <!-- Nav Item - Fixed Equipment -->
      <li style="display: none;" class="nav-item">
        <a class="nav-link" href="#">
          <span>Fixed Equipment</span></a>
      </li>
<!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item <?php if($currentItem=='forms'){echo 'active';} ?>" style='display: none;'>
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#forms" aria-expanded="true" aria-controls="equipments">
          <i class="fas fa-print"></i>
          <span>Form</span>
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

      <!-- Nav Item - Archived -->
      <li style="display: none;" class="nav-item">
        <a class="nav-link" href="accounts.php">
          <i class="far fa-user-circle"></i>
          <span>Accounts</span></a>
      </li>
      <li style="display: none;" class="nav-item">
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
      <!-- Nav Item - Archived -->
      <li style="display: none;" class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-archive"></i>
          <span>Archived</span></a>
      </li>
      <!-- Nav Item - Utilities Collapse Menu -->
      <li style="display: none;" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
          </div>
        </div>
      </li>



      <!-- Heading -->
      <div style="display: none;" class="sidebar-heading">
        Addons
      </div>
      <!-- Divider 
      <hr class="sidebar-divider">

      -->

      <!-- Nav Item - Pages Collapse Menu -->
      <li style="display: none;" class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Pages</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Login Screens:</h6>
            <a class="collapse-item" href="login.html">Login</a>
            <a class="collapse-item" href="register.html">Register</a>
            <a class="collapse-item" href="forgot-password.html">Forgot Password</a>
            <div class="collapse-divider"></div>
            <h6 class="collapse-header">Other Pages:</h6>
            <a class="collapse-item" href="404.html">404 Page</a>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>   

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->