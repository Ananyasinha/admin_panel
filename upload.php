<?php 
  include 'inc/db.php';

    function make_rand($one, $two, $three) {
      $id = substr(uniqid(md5((hash('md5', hash('md5', $one) . $two) . $three))), 0, 10);
      return $id;
  }

  $user_id  = "123";

  $hotel_id  = 1; 
  $name      = 'abc';
  $datetime   = date("Y-m-d H:i:s");
  
  if(isset($_POST['uplode_media'])) {

    for($i = 0; $i < count($_FILES["upload_file"]["name"]); $i++){
      $uploadfile   = $_FILES["upload_file"]["tmp_name"][$i];
      $extension    = explode(".",$_FILES["upload_file"]["name"][$i])[1];

      if(strtoupper($extension) == "JPG" || strtoupper($extension) == "PNG" || strtoupper($extension) == "JPEG" || strtoupper($extension) == "GIF"){
          $folder    = "images/";
      }
     
      $rand_number   = make_rand($hotel_id,$datetime,rand(1000000,9999999));
      $new_name      = $hotel_id."_".$rand_number;
      $images        = "";
      $videos        = "";
      if(strtoupper($extension) == "JPG" || strtoupper($extension) == "PNG" || strtoupper($extension) == "JPEG" || strtoupper($extension) == "GIF"){
          $images    = $new_name.'.'.$extension;
      }else{
          $videos    = $new_name;
      }

      move_uploaded_file($_FILES["upload_file"]["tmp_name"][$i], "$folder".$images);

      $insert1   = "INSERT INTO hotel_image_details (hotel_id,images,videos) VALUES ('$hotel_id','$images','$videos')";
      $inserted1 = $conn->query($insert1);
    }
  
     //exit();

      if($inserted1){
         //header("location:update_profile.php");
          $succesmsg = "Your Details Updated Succesfully...!";
        }else{
        $message = 'opps somthing went wrong...!';
      }
  }

?>

