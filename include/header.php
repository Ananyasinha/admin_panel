<nav class="navbar navbar-default navbar-fixed-top">
	<div class="container-fluid">
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="#">Admin Panel</a>
	    </div>
	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav navbar-right">
	        <li class="dropdown">
	        <?php 
		      	if (!empty($_SESSION['user_id'])) {
		      		$user_id = $_SESSION['user_id'];
			      	$select_name = "SELECT name FROM users WHERE user_id ='$user_id'";
			      	$selected_name = $conn->query($select_name);
			      	$row = $selected_name->fetch_assoc();
			      	$name = $row['name'];
	      	?>
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
	          <?php echo $name; ?><span class="caret"></span></a>
	          <ul class="dropdown-menu" role="menu">
	            <li><a href="logout.php">Log Out</a></li>	            
	        <?php } else{?>
	        	<!--For showing nothing in topbar-->  
	        <?php } ?>
	          </ul>
	        </li>
	      </ul>
	    </div>
	</div>
</nav>
