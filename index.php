<?php
  $currentItem = 'dashboard';
  include('dbh.php');
  include('sidebar.php');
  //PC
  $getCountPC = $mysqli->query("SELECT COUNT(unit_id) FROM unit_pc") or die ($mysqli->error);
  $newCountPC = $getCountPC->fetch_array();
  $getCountPeripheralForRepair = $mysqli->query("SELECT COUNT(peripheral_id) FROM peripherals WHERE remarks='For Repair'") or die ($mysqli->error);
  $newCountPeripheralForRepair = $getCountPeripheralForRepair->fetch_array();
  $getCountPeripheralFixed = $mysqli->query("SELECT COUNT(peripheral_id) FROM peripherals WHERE remarks='Fixed'") or die ($mysqli->error);
  $newCountPeripheralFixed = $getCountPeripheralFixed->fetch_array();
  
  //Furniture
  $getCountFixture = $mysqli->query("SELECT COUNT(id) FROM fixture WHERE type<>'airconditioner' ") or die ($mysqli->error);
  $newCountFixture = $getCountFixture->fetch_array();
  $getCountFixtureForRepair = $mysqli->query("SELECT COUNT(id) FROM fixture WHERE type<>'airconditioner' AND remarks='For Repair' ") or die ($mysqli->error);
  $newCountFixtureForRepair = $getCountFixtureForRepair->fetch_array();
  $getCountFixtureFixed = $mysqli->query("SELECT COUNT(id) FROM fixture WHERE type<>'airconditioner' AND remarks='Fixed' ") or die ($mysqli->error);
  $newCountFixtureFixed = $getCountFixtureFixed->fetch_array();

  //Aircon
  $getCountAircon = $mysqli->query("SELECT COUNT(id) FROM fixture WHERE type='airconditioner' ") or die ($mysqli->error);
  $newCountAircon = $getCountAircon->fetch_array();
  $getCountAirconForRepair = $mysqli->query("SELECT COUNT(id) FROM fixture WHERE type='airconditioner' AND remarks='For Repair' ") or die ($mysqli->error);
  $newCountAirconForRepair = $getCountAirconForRepair->fetch_array();
  $getCountAirconFixed = $mysqli->query("SELECT COUNT(id) FROM fixture WHERE type='airconditioner' AND remarks='Fixed' ") or die ($mysqli->error);
  $newCountAirconFixed = $getCountAirconFixed->fetch_array();

  //Maintenance
  $getCountMaintenance = $mysqli->query("SELECT COUNT(id) FROM maintenance ") or die ($mysqli->error);
  $newCountMaintenance = $getCountMaintenance->fetch_array();
  $getCountPendingMaintenance = $mysqli->query("SELECT COUNT(action_taken) FROM maintenance WHERE action_taken='' ") or die ($mysqli->error);
  $newCountPendingMaintenance = $getCountPendingMaintenance->fetch_array();
  $getCountActionTaken = $mysqli->query("SELECT COUNT(action_taken) FROM maintenance WHERE action_taken<>'' ") or die ($mysqli->error);
  $newCountActionTaken = $getCountActionTaken->fetch_array();
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Dashboard</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <?php include('topbar.php'); ?>
        <!-- Begin Page Content -->
        <div class="container-fluid">
          <label class="form-control" style="color: blue;">Dashboard</label>
          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <!--<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a  href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>-->
          </div>

          <!-- Content Row -->
          <div class="row">

            <!-- Total Number of unit PC:  -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of unit PC:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountPC['COUNT(unit_id)']; ?></div>
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Number Peripherals for repair:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountPeripheralForRepair['COUNT(peripheral_id)']; ?></div>
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Number Peripherals Fixed:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountPeripheralFixed['COUNT(peripheral_id)']; ?></div>
                      <!-- Progress -->
                                            <br/>
                          <?php $totalPCForRepair = $newCountPeripheralForRepair['COUNT(peripheral_id)'] + $newCountPeripheralFixed['COUNT(peripheral_id)'];
                                if($totalPCForRepair == 0){
                                  $totalPCForRepair =100;
                                }
                                else{
                                  $totalPCForRepair =  ($newCountPeripheralFixed['COUNT(peripheral_id)'] / $totalPCForRepair)*100;
                                }
                                
                                $totalPCForRepair = number_format($totalPCForRepair, 2, '.', '');
                                ?>
                          <div class="text-xs mb-0 mr-3 font-weight-bold text-gray-800">PROGRESS: <?php echo $totalPCForRepair; ?>%</div>
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $totalPCForRepair; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      <!-- End Progress -->
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-laptop fa-5x text-gray-500"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Number of Fixtures: -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Fixtures:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountFixture['COUNT(id)']; ?></div>
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Number of Fixtures For Repair:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountFixtureForRepair['COUNT(id)']; ?></div>
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Number of Fixtures Fixed:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountFixtureFixed['COUNT(id)']; ?></div>
                      <!-- Progress -->
                        <br/>
                          <?php $totalFextureForRepair = $newCountFixtureForRepair['COUNT(id)'] + $newCountFixtureFixed['COUNT(id)'];
                                $totalFextureForRepair =  ($newCountFixtureFixed['COUNT(id)'] / $totalFextureForRepair)*100;
                                $totalFextureForRepair = number_format($totalFextureForRepair, 2, '.', '');
                                ?>
                          <div class="text-xs mb-0 mr-3 font-weight-bold text-gray-800">PROGRESS: <?php echo $totalFextureForRepair; ?>%</div>
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $totalFextureForRepair; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      <!-- End Progress -->
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-couch fa-5x text-gray-500"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Total Number of Aircon: -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Number of Aircons:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountAircon['COUNT(id)']; ?></div>
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Total Number of Aircons For Repair:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountAirconForRepair['COUNT(id)']; ?></div>
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Number of Aircons Fixed:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountAirconFixed['COUNT(id)']; ?></div>
                      <!-- Progress -->
                      <br/>
                          <?php $totalAirconForRepair = $newCountAirconForRepair['COUNT(id)'] + $newCountAirconFixed['COUNT(id)'];
                                $totalAirconForRepair =  ($newCountAirconFixed['COUNT(id)'] / $totalAirconForRepair)*100;
                                $totalAirconForRepair = number_format($totalAirconForRepair, 2, '.', '');
                                ?>
                          <div class="text-xs mb-0 mr-3 font-weight-bold text-gray-800">PROGRESS: <?php echo $totalAirconForRepair; ?>%</div>
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $totalAirconForRepair; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      <!-- End Progress -->                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-fan fa-5x text-gray-500 fa-spin" style="-webkit-animation: fa-spin 0.5s infinite linear; animation: fa-spin 0.5s infinite linear;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Requests: </div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountMaintenance['COUNT(id)'] ?></div>
                      <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Pending Requests</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountPendingMaintenance['COUNT(action_taken)'] ?></div>
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Action Taken:</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $newCountActionTaken['COUNT(action_taken)'] ?></div>
                      <!-- Progress -->
                      <br/>
                          <?php $totalMaintenance = $newCountMaintenance['COUNT(id)'];
                                $totalMaintenance =  ($newCountActionTaken['COUNT(action_taken)'] / $totalMaintenance)*100;
                                $totalMaintenance = number_format($totalMaintenance, 2, '.', '');
                                ?>
                          <div class="text-xs mb-0 mr-3 font-weight-bold text-gray-800">PROGRESS: <?php echo $totalMaintenance; ?>%</div>
                          <div class="progress progress-sm mr-2">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $totalMaintenance; ?>%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                          </div>
                      <!-- End Progress -->                      
                    </div>
                    <div class="col-auto">
                      <i class="fa fa-address-book fa-5x text-gray-500" aria-hidden="true"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <span class="text-danger form-control">For Repairs:</span><br>

          <!-- Content Row -->
          <div class="row">

            <!-- Content Column -->
            <div class="col-lg-6 mb-4">

              <!-- PC Components -->
              <?php
                //For Repair Peripherals
                $peripheralMoreThan3=false;
                $getPeripherals = $mysqli->query("SELECT * FROM peripherals WHERE remarks='For Repair'") or die ($mysqli->error);
                if(mysqli_num_rows($getPeripherals)>3){
                   $peripheralMoreThan3=true;
                }
                $getPeripherals = $mysqli->query("SELECT * FROM peripherals p
                  JOIN unit_pc u ON p.unit_id = u.unit_id
                  JOIN laboratory l ON l.lab_id = u.lab_id
                  JOIN building b ON b.building_id = u.building_id
                  WHERE remarks='For Repair' LIMIT 3") or die ($mysqli->error);

               ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">PC Components</h6>
                </div>
                <div class="card-body">
                  <table class="table pc-components">
                    <thead class="thead-dark">
                      <th>ID</th>
                      <th>Type</th>
                      <th>Laboratory</th>
                      <th>Building</th>
                    </thead>
                    <tbody>
                    <?php while($newPeripherals=$getPeripherals->fetch_assoc()){ ?>
                    <tr>
                      <td><?php echo $newPeripherals['peripheral_id']; ?></td>
                      <td><?php echo $newPeripherals['peripheral_type']; ?></td>
                      <td><?php echo $newPeripherals['lab_name']; ?></td>
                      <td><?php echo $newPeripherals['building_name']; ?></td>
                    </tr>
                    <?php } ?>
                    <tr>
                    </tr>
                    </tbody>
                  </table>
                  <?php if($peripheralMoreThan3){ ?>
                    <center><a class='btn btn-sm btn-primary mb-2' target="_blank" href="for_repair.php"><i class="fas fa-book-reader"></i> Read More</a></center>
                  <?php } ?>                  
                </div>
              </div>

              <!-- Aircon -->
              <?php
                //For Repair Peripherals
                $airconMoreThan3=false;
                $getAircon = $mysqli->query(" SELECT * FROM fixture WHERE type='airconditioner' AND remarks='For Repair' ") or die ($mysqli->error);
                if(mysqli_num_rows($getAircon)>3){
                   $airconMoreThan3=true;
                }
                $getAircon  = $mysqli->query("SELECT * FROM fixture f 
                  JOIN laboratory l ON l.lab_id = f.lab_id
                  JOIN building b ON b.building_id = f.building_id                  
                  WHERE type='airconditioner' AND remarks='For Repair' LIMIT 3") or die ($mysqli->error);
               ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Airconditioner</h6>
                </div>
                <div class="card-body">
                  <table class="table dashboard-airconditioner">
                    <thead class="thead-dark">
                      <th>ID</th>
                      <th>Serial Code</th>
                      <th>Laboratory</th>
                      <th>Building</th>
                    </thead>
                    <tbody>
                      <?php while($newAircon =$getAircon->fetch_assoc()){ ?>
                      <tr>
                        <td><?php echo $newAircon['id']; ?></td>
                        <td><?php echo $newAircon['serial_no']; ?></td>
                        <td><?php echo $newAircon['lab_name']; ?></td>
                        <td><?php echo $newAircon['building_name']; ?></td>
                      </tr>
                      <?php } ?>
                    </tbody>
                  </table>
                  <?php if($airconMoreThan3){ ?>
                        <center><a class='btn btn-sm btn-primary mb-2' target="_blank" href="for_repair_fixtures.php"><i class="fas fa-book-reader"></i> Read More</a></center>
                  <?php } ?>


                  <?php
                  $airConCleaningMoreThan3=false;
                  $currentDate = date("Y-m-d");
                  $checkDateForCleaning = date('Y-m-d', strtotime($currentDate. ' - 166 days'));
                  $getAirconCleaning = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.date_last_clean ,fe.remarks, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
                    FROM fixture fe
                    JOIN building bg
                    ON bg.building_id = fe.building_id
                    JOIN laboratory ly
                    ON ly.lab_id = fe.lab_id
                    WHERE fe.type ='airconditioner' AND fe.date_last_clean<'$checkDateForCleaning' ") or die ($mysqli->error);

                  if(mysqli_num_rows($getAirconCleaning)>3){
                    $airConCleaningMoreThan3=true;
                  }
                  $getAirconCleaning = mysqli_query($mysqli, "SELECT fe.id, fe.date_added, fe.serial_no, fe.type, fe.batch_code, fe.building_id, fe.lab_id, fe.date_last_clean ,fe.remarks, bg.building_id, bg.building_name, ly.lab_id, ly.lab_name
                    FROM fixture fe
                    JOIN building bg
                    ON bg.building_id = fe.building_id
                    JOIN laboratory ly
                    ON ly.lab_id = fe.lab_id
                    WHERE fe.type ='airconditioner' AND fe.date_last_clean<'$checkDateForCleaning' LIMIT 3") or die ($mysqli->error);
                  
                  ?>
                  <span class="text-primary"><b>Due for Cleaning</b></span>
                   <table class="table dashboard-aircon-cleaning">
                    <thead class="thead-dark">
                      <th>ID</th>
                      <th>Serial Code</th>
                      <th>Laboratory</th>
                      <th>Building</th>
                      <th>Due Date<th>
                    </thead>
                    <?php while($newAirconCleaning =$getAirconCleaning->fetch_assoc()){ ?>
                    <tr>
                      <td><?php echo $newAirconCleaning['id']; ?></td>
                      <td><?php echo $newAirconCleaning['serial_no']; ?></td>
                      <td><?php echo $newAirconCleaning['lab_name']; ?></td>
                      <td><?php echo $newAirconCleaning['building_name']; ?></td>
                      <td><?php $getDateLastClean = $newAirconCleaning['date_last_clean'];
                               echo "<span class='text-danger'>".$getDateLastClean = date('Y-m-d', strtotime($getDateLastClean. ' + 166 days')).'</span>';
                      ?></td>
                    </tr>
                    <?php } ?>
                  </table>
                  <?php if($airConCleaningMoreThan3){ ?>
                      <center><a class='btn btn-sm btn-primary mb-2' target="_blank"  href="aircon.php"><i class="fas fa-book-reader"></i> Read More</a></center>
                  <?php } ?>
                </div>
              </div>

            </div>

            <div class="col-lg-6 mb-4">

              <!-- Fixtures -->
              <?php
                //For Repair Peripherals
                $fixturesMoreThan3=false;
                $getFixtures = $mysqli->query("SELECT * FROM fixture WHERE remarks='For Repair' AND type <> 'airconditioner' ") or die ($mysqli->error);
                if(mysqli_num_rows($getFixtures)>3){
                   $fixturesMoreThan3=true;
                }
                $getFixtures = $mysqli->query("SELECT * FROM fixture f 
                  JOIN laboratory l ON f.lab_id = l.lab_id
                  JOIN building b ON b.building_id = l.building_id
                  WHERE remarks='For Repair' AND f.type<>'airconditioner' LIMIT 3 ") or die ($mysqli->error);
               ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Fixtures</h6>
                </div>
                <div class="card-body">
                  <table class="table dashboard-fixtures">
                    <thead class="thead-dark">
                      <th>ID</th>
                      <th>Type</th>
                      <th>Laboratory</th>
                      <th>Building</th>

                    </thead>
                    <?php while($newFixtures=$getFixtures->fetch_assoc()){ ?>
                    <tr>
                      <td><?php echo $newFixtures['id']; ?></td>
                      <td><?php echo strtoupper($newFixtures['type']); ?></td>
                      <td><?php echo $newFixtures['lab_name']; ?></td>
                      <td><?php echo $newFixtures['building_name']; ?></td>
                    </tr>
                    <?php } ?>
                  </table>
                  <?php if($fixturesMoreThan3){ ?>
                    <center><a class='btn btn-sm btn-primary' target="_blank" href="for_repair_fixtures.php"><i class="fas fa-book-reader"></i> Read More</a></center>
                  <?php } ?>
                </div>
              </div>

              <!-- Request -->
              <?php
                //For Repair Peripherals
                $requestMoreThan3=false;
                $getRequest = $mysqli->query("SELECT * FROM maintenance WHERE action_taken=''") or die ($mysqli->error);
                if(mysqli_num_rows($getRequest)>3){
                   $requestMoreThan3=true;
                }
                $getRequest = $mysqli->query("SELECT * FROM maintenance WHERE action_taken='' LIMIT 3") or die ($mysqli->error);
               ?>
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Pending Maintenance Requests</h6>
                </div>
                <div class="card-body">
                  <table class="table dashboard-requests">
                    <thead class="thead-dark">
                      <th>ID</th>
                      <th>Department</th>
                      <th>Date</th>

                    </thead>
                    <?php while($newRequest=$getRequest->fetch_assoc()){ ?>
                    <tr>
                      <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#ModalID<?php echo $newRequest['id'];?>"><?php echo $newRequest['id']; ?></button></td>
                      <td><button type="button" class="btn btn-link" data-toggle="modal" data-target="#ModalID<?php echo $newRequest['id'];?>"><?php echo ucfirst($newRequest['department']); ?></button></td>
                      <td><?php echo ucfirst($newRequest['date_requested']); ?></td>
                    </tr>
                    <!-- Modal For Request Here -->
                    <div class="modal fade" id="ModalID<?php echo $newRequest['id'];?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Request ID: <?php echo $newRequest['id'].' by '.$newRequest['requested_by']; ?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                        <!-- Contents Here -->
                        <u>Note:</u><br/>
                        <?php echo $newRequest['request']; ?>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="far fa-window-close"></i> Close</button>
                        </div>
                      </div>
                      </div>
                    </div>
                    <!-- End Modal For PC Equipments -->                    
                    <?php } ?>
                  </table>
                  <?php if($requestMoreThan3){ ?>
                    <center><a class='btn btn-sm btn-primary' target="_blank" href="view_maintenance.php"><i class="fas fa-book-reader"></i> Read More</a></center>
                    <?php } ?>
                </div>
              </div>

              <!-- Approach -->
              <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">SPCF - ITS - Inventory System</h6>
                </div>
                <div class="card-body">
                  <p>Systems Plus College Foundation is committed to provide liberal, quality, transformative and relevant education towards the holistic development of all stakeholders through excellence in instruction, research and extension services. A leading and globally competitive institution of learning through service and innovation.</p>
                </div>
              </div>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>

<?php include('footer.php');?>
<!-- End of Footer -->
<style type="text/css">
  /*
  Max width before this PARTICULAR table gets nasty. This query will take effect for any screen smaller than 760px and also iPads specifically.
  */

@media
only screen
and (max-width: 760px), (min-device-width: 768px)
and (max-device-width: 1024px)  {
  /* PC Table */
  .pc-components table, .pc-components thead, .pc-components tbody, .pc-components th, .pc-components td, .pc-components tr {
    display: block;
  }

  .pc-components thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  .pc-components tr {
    margin: 0 0 1rem 0;
  }

  .pc-components tr:nth-child(odd) {
    background: none;
    padding: 1%;
    width: 100%;
    border-bottom: 2px solid grey;
    border-top: 2px solid grey;
  }
      
  .pc-components td {
    border-bottom: 1px solid #eee;
    position: relative;
  }

  .pc-components td:before {
    top: 0;
    width: 45%;
    padding-right: 1%;
    white-space: nowrap;
  }

  .pc-components td:nth-of-type(1):before { content: "ID:"; font-weight: bold;}
  .pc-components td:nth-of-type(2):before { content: "Type:"; font-weight: bold; }
  .pc-components td:nth-of-type(3):before { content: "Laboratory:"; font-weight: bold; }
  .pc-components td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
  /* End PC Table */

  /* Airconditioner Table */
  .dashboard-airconditioner table, .dashboard-airconditioner thead, .dashboard-airconditioner tbody, .dashboard-airconditioner th, .dashboard-airconditioner td, .dashboard-airconditioner tr {
    display: block;
  }

  .dashboard-airconditioner thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  .dashboard-airconditioner tr {
    margin: 0 0 1rem 0;
  }

  .dashboard-airconditioner tr:nth-child(odd) {
    background: none;
    padding: 1%;
    width: 100%;
    border-bottom: 2px solid grey;
    border-top: 2px solid grey;
  }
      
  .dashboard-airconditioner td {
    border-bottom: 1px solid #eee;
    position: relative;
  }

  .dashboard-airconditioner td:before {
    top: 0;
    width: 45%;
    padding-right: 1%;
    white-space: nowrap;
  }

  .dashboard-airconditioner td:nth-of-type(1):before { content: "ID:"; font-weight: bold;}
  .dashboard-airconditioner td:nth-of-type(2):before { content: "Serial Code:"; font-weight: bold; }
  .dashboard-airconditioner td:nth-of-type(3):before { content: "Laboratory:"; font-weight: bold; }
  .dashboard-airconditioner td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
  /* End Airconditioner Table */

  /* Airconditioner Cleaning Table */
  .dashboard-aircon-cleaning table, .dashboard-aircon-cleaning thead, .dashboard-aircon-cleaning tbody, .dashboard-aircon-cleaning th, .dashboard-aircon-cleaning td, .dashboard-aircon-cleaning tr {
    display: block;
  }

  .dashboard-aircon-cleaning thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  .dashboard-aircon-cleaning tr {
    margin: 0 0 1rem 0;
  }

  .dashboard-aircon-cleaning tr:nth-child(odd) {
    background: none;
    padding: 1%;
    width: 100%;
    border-bottom: 2px solid grey;
    border-top: 2px solid grey;
  }
      
  .dashboard-aircon-cleaning td {
    border-bottom: 1px solid #eee;
    position: relative;
  }

  .dashboard-aircon-cleaning td:before {
    top: 0;
    width: 45%;
    padding-right: 1%;
    white-space: nowrap;
  }

  .dashboard-aircon-cleaning td:nth-of-type(1):before { content: "ID:"; font-weight: bold;}
  .dashboard-aircon-cleaning td:nth-of-type(2):before { content: "Serial Code:"; font-weight: bold; }
  .dashboard-aircon-cleaning td:nth-of-type(3):before { content: "Laboratory:"; font-weight: bold; }
  .dashboard-aircon-cleaning td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
  .dashboard-aircon-cleaning td:nth-of-type(4):before { content: "Due Date:"; font-weight: bold; }
  /* Airconditioner Cleaning Table */

  /* Dashboard Fixture Table */
  .dashboard-fixtures table, .dashboard-fixtures thead, .dashboard-fixtures tbody, .dashboard-fixtures th, .dashboard-fixtures td, .dashboard-fixtures tr {
    display: block;
  }

  .dashboard-fixtures thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  .dashboard-fixtures tr {
    margin: 0 0 1rem 0;
  }

  .dashboard-fixtures tr:nth-child(odd) {
    background: none;
    padding: 1%;
    width: 100%;
    border-bottom: 2px solid grey;
    border-top: 2px solid grey;
  }
      
  .dashboard-fixtures td {
    border-bottom: 1px solid #eee;
    position: relative;
  }

  .dashboard-fixtures td:before {
    top: 0;
    width: 45%;
    padding-right: 1%;
    white-space: nowrap;
  }

  .dashboard-fixtures td:nth-of-type(1):before { content: "ID:"; font-weight: bold;}
  .dashboard-fixtures td:nth-of-type(2):before { content: "Type:"; font-weight: bold; }
  .dashboard-fixtures td:nth-of-type(3):before { content: "Laboratory:"; font-weight: bold; }
  .dashboard-fixtures td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
  /* Dashboard Fixture Table */

  /* Dashboard Requests */
  .dashboard-requests table, .dashboard-requests thead, .dashboard-requests tbody, .dashboard-requests th, .dashboard-requests td, .dashboard-requests tr {
    display: block;
  }

  .dashboard-requests thead tr {
    position: absolute;
    top: -9999px;
    left: -9999px;
  }

  .dashboard-requests tr {
    margin: 0 0 1rem 0;
  }

  .dashboard-requests tr:nth-child(odd) {
    background: none;
    padding: 1%;
    width: 100%;
    border-bottom: 2px solid grey;
    border-top: 2px solid grey;
  }
      
  .dashboard-requests td {
    border-bottom: 1px solid #eee;
    position: relative;
  }

  .dashboard-requests td:before {
    top: 0;
    width: 45%;
    padding-right: 1%;
    white-space: nowrap;
  }

  .dashboard-requests td:nth-of-type(1):before { content: "ID:"; font-weight: bold;}
  .dashboard-requests td:nth-of-type(2):before { content: "Type:"; font-weight: bold; }
  .dashboard-requests td:nth-of-type(3):before { content: "Laboratory:"; font-weight: bold; }
  .dashboard-requests td:nth-of-type(4):before { content: "Building:"; font-weight: bold; }
  /* Dashboard Requests */   
}
</style>
<!-- EOF -->