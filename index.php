<?php
  require_once 'include/core.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
  
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Manuel Paccoia e Federico Quaglia">
    <link rel="shortcut icon" href="img/icon/favicon.ico" type="image/x-icon">

    <title>
        Programmazione Ordini Contrastanga
    </title>
</head>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <body>
  <div class="container-fluid">
    <div class="row text-center">
      <div class="col text-justify" style="border-right: 1px solid black;">
        <h2>ANTIPASTI</h3>
      </div>
      <div class="col text-justify" style="border-left: 1px solid black;">
        <h2>DOLCI</h3>
      </div>
      <div class="col-12" id="content">
      <div class="row text-justify my-1 space red" id="in-corso">
        <div class="col-12 combine" id="combine-incorso"></div>
        <div class="col-6" id="dolce-incorso"></div>
        <div class="col-6" id="primo-incorso"></div>
      </div>
      <div class="row text-justify my-1 space blue" id="next">
        <div class="col-12 combine" id="combine-next"></div>
        <div class="col-6" id="dolce-next"></div>
        <div class="col-6" id="primo-next"></div></div>
    </div>
    </div>
    



  </div>

  </body>

  <script src="js/jquery-3.3.1.slim.min.js" ></script>
  <script src="js/popper.min.js" ></script>
  <script src="js/bootstrap.min.js" ></script>
  <script src="js/lodash.min.js" ></script>
  <script src="js/loadData.js"></script>
</html>