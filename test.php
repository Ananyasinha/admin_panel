<?php
$conn = new mysqli("localhost","root","","test");

if(isset($_POST['submit'])){

	$fileName = $_FILES['file']['name'];
    $fileExt = pathinfo($fileName, PATHINFO_EXTENSION);
    $fileName = rand('11111','99999').'-'.time().'.'.$fileExt;

	/*$file = $_FILES['file']['name'];
	$img  = rand(11111,999999)."_".time()."_".$file;*/
	move_uploaded_file($_FILES['file']['tmp_name'],"../upload/".$fileName);
	$date = mysqli_query($conn,"insert into `image`(`id`,`image`) values('','$fileName')");
	if($date == true)
	{
		echo "inserted";
	}
	else
	{
		"try again";
	}
}


?>

<!DOCTYPE html>
<html>
<?php 
	if($_SERVER['SCRIPT_NAME'] == '/lab/index.php') {
		$title = 'Demo';
	}else if ($_SERVER['SCRIPT_NAME'] == '/lab/test.php') {
		$title = 'Test';
	}
?>
<head>
	<title>Lab | <?php echo $title; ?></title>
<link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon.ico" />	
<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>

<form method="post" enctype="multipart/form-data">
	File:<input type="file" name="file"><br>
	<input type="submit" name="submit" value="Submit">
</form>

	
</body>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/common.js"></script>
</html>