<?php

  if(isset($_GET['ispc'])){
    #I wonder if anyone can understand what boolean means.
    #I mean, it could be true or false.
    $ispc = true;
    $id = $_GET['id'];
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


  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $getURI = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
  $_SESSION['getURI'] = $getURI;

  echo $getURI = str_replace('$', '&', $getURI);
  echo $getURI = str_replace('scan_qr', 'view_qr', $getURI);

  header("location: ".$getURI);

?>
<!-- EOF -->
