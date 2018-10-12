<?php 
  include 'inc/header.php';
  include 'inc/db.php';
?>


<style type="text/css">
img {
    height: 80px;
    width: 100px;
    border: 1px solid;
    margin: 10px;
}

div#error_register {
    text-align: center;
}
.row.filed {
    margin-top: 20px;
    margin-bottom: 70px;
}
</style>
<style type="text/css">
body {
    padding: 30px 0px;
}

#lightbox .modal-content {
    display: inline-block;
    text-align: center;   
}

#lightbox .close {
    opacity: 1;
    color: rgb(255, 255, 255);
    background-color: rgb(25, 25, 25);
    padding: 5px 8px;
    border-radius: 30px;
    border: 2px solid rgb(255, 255, 255);
    position: absolute;
    top: -15px;
    right: -55px;
    
    z-index:1032;
}

img.show_img {
  height: 100%;
  width: 100%;
  border: 1px solid;
  margin: 10px;
}

.row.image_list {
    margin-left: 0px;
    margin-right: 0px;
}

img.show_img {
    height: 75%;
    width: 89%;
    border: 1px solid;
    margin: 10px;
}

.thumbnail {
    height: 100%;
    width: 100%;
    border: 1px solid #e6e6e6;
    margin: 10px;
}


.thumbnail1 {
    height: 100%;
    width: 100%;
    border: 1px solid #e6e6e6;
    margin: 10px;
}


.col-xs-6.col-sm-2.img_view {
    margin-top: 20px;
}

.col-xs-6.col-sm-3.img_view1 {
    margin-top: 20px;
}

</style>


<?php include 'inc/menu.php';?>

  <div class="content">
    <div class="container">
      <div id="error_register" class="alert alert-dismissible alert-success" style="<?php if(!empty($succesmsg)){ echo "display:block"; }else {echo "display: none"; }?>">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php echo $succesmsg;?></strong>.
      </div> 
      
      <div class="alert alert-dismissible alert-danger" style="<?php if(!empty($message)){ echo "display:block"; }else {echo "display: none"; }?>">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong><?php echo $message;?></strong>.
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-icon card-header-rose">
              <div class="card-icon">
                  <i class="material-icons">image</i>
              </div>
              <h4 class="card-title"> Create Gallary  <small class="category"></small></h4>
            </div>

            <div class="card-body">
              <form action="upload_file.php" method="post" enctype="multipart/form-data">
                <div class="row filed">
                  <div class="col-md-1"></div>
                    <div class="col-md-5 col-sm-6">
                      <h4 class="title">Uplode Hotel Images</h4>
                        <div id="wrapper">
                          <div class="container">
                              <div class="col-md-6">
                                  <input type="file" id="upload_file" name="upload_file[]" class="btn btn-primary btn-round fileinput-exists" onchange="preview_image();" multiple/>
                              </div>
                              <div class="row" id="image_preview"></div>
                          </div>
                      </div>
                    </div>

                   <!--  <div class="col-md-1"></div> -->
                    <div class="col-md-5 col-sm-6">
                      <h4 class="title">Uplode Hotel Videos</h4>
                        <div id="wrapper1">
                          <div class="container">
                              <div class="col-md-6">
                                  <input type="file" id="upload_file" class="btn btn-primary btn-round fileinput-exists" name="upload_file[]" multiple/>
                              </div>
                              <div class="row" id="image_preview1"></div>
                          </div>
                        </div>
                    </div>
                </div>
                  <button type="submit" class="btn btn-rose" type="submit" name="uplode_media" value="submit">UPLODE</button>
                  <div class="clearfix"></div>
              </form>
            </div>
             <hr>

            <!--===== UPLOADED IMAGE-WRAPPER ====-->
            <div class="container" style="margin-bottom: 30px;">
              <h3>Uploded Image </h3>  
              <div class="row image_list">

              <?php 
                $hotel_id = $_SESSION['hotel_id'];
                $select_image =  "SELECT * FROM hotel_image_details WHERE hotel_id = '$hotel_id'";
                $selected = $conn->query($select_image);

                while($row = $selected->fetch_assoc()){ 
                  $id = $row['id'];

                  if($row['images'] !=""){?>

                    <div class="col-xs-6 col-sm-2 img_view">
                      <div href="#" class="thumbnail"> 
                      <i class="fa fa-times close"  data-id="<?php echo $row['id'];?>"></i>
                         <img class="show_img" src="images/<?php echo $row['images'].'.jpg';?>" /> 
                      </div>
                  </div>

                 <?php } } ?>

              </div>
            </div>
            <!-- end innerpage-wrapper -->

    
            <!--===== UPLOADED VIDEO-WRAPPER ====-->
            <hr>
            <div class="container" style="margin-bottom: 30px;">
              <h3>Uploded Video </h3>
              <div class="row image_list">

              <?php 
                $hotel_id = $_SESSION['hotel_id'];
                $select_videos =  "SELECT * FROM hotel_image_details WHERE hotel_id = '$hotel_id'";
                $selected_videos = $conn->query($select_videos);

                while($row = $selected_videos->fetch_assoc()){ 
                  if($row['videos'] !=""){   ?>

                    <div class="col-xs-6 col-sm-3 img_view1">
                        <div href="#" class="thumbnail1"> 
                         <i class="fa fa-times close1" data-id='<?php echo $row['id'];?>'></i>
                          <video width="220" height="220" controls>
                            <source src="videos/<?php echo $row['videos'].'.3gp';?>" type="video/mp4">
                            Sorry, your browser doesn't support the video element.
                          </video>
                        </div>
                    </div>
               <?php } } ?>

              </div>
            </div>
            <!-- end innerpage-wrapper -->

          </div>
        </div>
      </div>
    </div>
  </div>

<?php include 'inc/footer.php';?>


<script>
  $(document).ready(function() {
      $('form').ajaxForm(function() {
          alert("Your Details Updated Succesfully...!");
          window.location.reload(true);
      });
  });

  function preview_image() {
      var total_file = document.getElementById("upload_file").files.length;
      for (var i = 0; i < total_file; i++) {
          $('#image_preview').append("<div class='col-md-3 img'><img src='" + URL.createObjectURL(event.target.files[i]) + "'></div>");
      }
  }
</script>

<script>
  $('.close').on('click', function() {
    var image_id = $(this).data("id");
    var ref   = "image_box";
    $.ajax({
      url       :"inc/common.php",
      type      :"POST",
      dataType  :"JSON",
      data :{
          ref      : ref,
          image_id :  image_id
        }
      }).done(function(res){
        if(res.success){
          $(".img_view").hide();
          window.location.reload(true);
        }
      });
  });



 $('.close1').on('click', function() {
    var video_id = $(this).data("id");
  
    var ref      = "video_box";
    $.ajax({
      url       :"inc/common.php",
      type      :"POST",
      dataType  :"JSON",
      data :{
          ref      : ref,
          video_id :  video_id
        }
      }).done(function(res){
        if(res.success){
          $(".thumbnail1").hide();
           window.location.reload(true);
        }
      });
  });


</script>


