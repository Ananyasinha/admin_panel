<?php
session_start();
$conn = new MySQli("localhost","root","","admin");

if(!empty($_SESSION['user_id'])){
  header('location:home.php');
}


if (isset($_POST['register'])) {
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$gender = $_POST['gender'];

	$select = "SELECT id FROM users ORDER BY id DESC";
	$selected = $conn->query($select);
	$row = $selected->fetch_assoc();
	$id = $row['id'];
	$id = $id + 1;
	$user_id = '23'.$id.'12'.$id.'1995'.$id;


	$select_email = "SELECT email FROM users WHERE email = '$email'";
	$selected_email = $conn->query($select_email);

	if ($selected_email->num_rows > 0) {
		echo "<script>alert('email already exist')</script>";
	}
	else{
		$add = "INSERT INTO users VALUES ('','$user_id','$name','$email','$password','$gender',now())";
		$added = $conn->query($add);

		if($added){	

			$_SESSION['user_id'] = $user_id;
			header('location:home.php');
		}	
	}
}


if (isset($_POST['login'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$select_login = "SELECT email,password FROM users WHERE email='$email' && password='$password'";
	$selected_login = $conn->query($select_login);
	
	if($selected_login->num_rows > 0){

		$user_id = "SELECT user_id FROM users WHERE email = '$email'";
		$user_id_selected = $conn->query($user_id);
		$row_user_id = $user_id_selected->fetch_assoc();
		$user_id = $row_user_id['user_id'];

		$_SESSION['user_id'] = $user_id;
		header('location:home.php');

	}else{
		echo "<script>alert('wrong email & password combination')</script>";		
	}

}




?>



<!DOCTYPE html>
<html>
<head>
	<title>ADMIN</title>

<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
<style type="text/css">
	.navbar-default{border-radius:0px 0px 0px 0px}
</style>

</head>
<body>
<?php include "include/header.php" ?>


<div class="container" style="margin-top:140px;">
	<div class="row">
		<div class="col-md-6" style="box-shadow:0px 0px 1px 1px #a6a6a6">
			<form class="form-horizontal" action="index.php" method="POST" style="margin:25px 15px 25px 5px;">
			  <fieldset>
			    <legend>Register</legend>
			    <div class="form-group">
			      <label for="inputName" class="col-lg-2 control-label" >Name</label>
			      <div class="col-lg-10">
			        <input type="text" class="form-control" id="inputName" name="name" placeholder="Name" required />
			      </div>
			    </div>
			    <div class="form-group">
			      <label for="inputEmail" class="col-lg-2 control-label" >Email</label>
			      <div class="col-lg-10">
			        <input type="text" class="form-control" id="inputEmail" name="email" placeholder="Email" required />
			      </div>
			    </div>
			    <div class="form-group">
			      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
			      <div class="col-lg-10">
			        <input type="password" class="form-control" id="inputPassword" name="password" placeholder="Password" required />
			      </div>
			    </div>
			    <div class="form-group">
			      <label class="col-lg-2 control-label">Gender</label>
			      <div class="col-lg-10">
			        <div class="radio">
			          <label>
			            <input type="radio" name="gender" id="optionsRadios1" value="male" required>
			            MALE
			          </label>
			        </div>
			        <div class="radio">
			          <label>
			            <input type="radio" name="gender" id="optionsRadios2" value="female" required>
			           FEMALE
			          </label>
			        </div>
			      </div>
			    </div>
			   
			    <div class="form-group">
			      <div class="col-lg-12">
			        <button type="submit" class="btn btn-primary pull-right" name="register" style="margin-left:20px;">Register</button>
			        <button type="reset" class="btn btn-default pull-right" name="reset">Reset</button>
			      </div>
			    </div>
			  </fieldset>
			</form>
		</div>

		<div class="col-md-5 col-md-offset-1" style="box-shadow:0px 0px 1px 1px #a6a6a6; margin-top:40px;">
			<form class="form-horizontal" action="index.php" method="POST" style="margin:25px 15px 25px 5px;">
			  <fieldset>
			    <legend>Login</legend>
			    <div class="form-group">
			      <label for="inputEmail" class="col-lg-2 control-label">Email</label>
			      <div class="col-lg-10">
			        <input type="text" class="form-control" name="email"  id="inputEmail" placeholder="Email" required/>
			      </div>
			    </div>
			    <div class="form-group">
			      <label for="inputPassword" class="col-lg-2 control-label">Password</label>
			      <div class="col-lg-10">
			        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" required/>
			      </div>
			    </div>
			    <div class="form-group">
			      <div class="col-lg-12">
			        <button type="submit" class="btn btn-primary pull-right" name="login" style="margin-left:20px;">Login</button>
			        <button type="reset" class="btn btn-default pull-right">Reset</button>
			      </div>
			    </div>
			  </fieldset>
			</form>
		</div>
	</div>	
</div>


</body>
<script type="text/javascript" src="assets/js/jquery.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>

</html>
