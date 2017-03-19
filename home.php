<?php 
session_start();
$conn = new MySQli("localhost","root","","admin");

if(empty($_SESSION['user_id'])){
  header('location:index.php');
}

?>

<!DOCTYPE html>
<html>
<head>
	<title>HOME</title>

<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

</head>
<body>

<?php include "include/header.php" ?>

<div class="container" style="margin-top:100px;">
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Id.no</th>
      <th>Name</th>
      <th>Email</th>
      <th>Gender</th>
      <th>Password</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
    </tr>
    <tr>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
    </tr>
    
    <tr class="success">
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
      <td>Column content</td>
    </tr>
    
  
  </tbody>
</table> 
</div>

</body>
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

</html>