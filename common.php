<?php 
error_reporting(0);
	include '../inc/db.php';
	$ref = $_POST['ref'];

	switch ($ref) {
		case 'register':
		    $firstname 	= $_POST['registerfirstname'];
		    $lastname 	= $_POST['registerlastname'];
		    $address	= $_POST['registeraddress'];
			$email 		= $_POST['registeremail'];
			$password 	= md5($_POST['registerpass']);
			$usertype 	= $_POST['registerusertype'];
			
			$check_email = "SELECT email FROM users WHERE email='$email'";
			$checked 	 = $conn->query($check_email);
			
			if ($checked->num_rows > 0) {
				$out = array(
						'success' => false,
						'message' => "L'email existe déjà", //'Email Already Exists', 
						'class_name' =>'alert-warning'
				);
			}else if(($firstname=="") || ($lastname=="") || ($address=="") || ($email=="") || ($password=="") || ($usertype=="")){
					$out = array(
						'success' => false,
						'message' =>'Tous les champs sont obligatoires', //'All fields are mandatory',
						'class_name'=>'alert-danger'
					);
			}else if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$email)){
				$out = array(
					'success' => false,
					'message' =>'Invalid Email Pattern',
					'class_name'=>'alert-info'
				 );
			}else{
				$insert 	 = "INSERT INTO users VALUES (null,'$email','$firstname','$lastname','$address','$password','$usertype','$datetime')";
				
				if($inserted = $conn->query($insert)){
					$select_id = "SELECT * FROM users WHERE email='$email'";
					$selected  = $conn->query($select_id);
					$row 	   = $selected->fetch_assoc();
					$id 	   = $row['id'];
					$email_id  = $row['email'];
					$firstname = $row['firstname'];
					
					$_SESSION['email'] = $email_id;
					$_SESSION['id'] = $id;
					$_SESSION['firstname'] = $firstname;
					$_SESSION['usertype'] = $usertype;

					$out = array(
						'success' => true,
						'message' => 'Félicitations, enregistré avec succès!', //'Congrats, Registered Successfully!',
						'class_name'=>'alert-info'
					);
				}else{
					$out = array(
						'success' => false,
						'message' => $conn->error,
						'class_name'=>'alert-info'
					);
					// echo "error".$conn->error;
				}
			}
			echo json_encode($out);
		break;
		
		case 'login':
			$email 		= $_POST['loginemail'];
			$password 	= md5($_POST['loginpass']);
			if($email=='' || $password==''){
				$out = array(
					'success' => false,
					'message' =>'Tous les champs sont obligatoires',
					'class_name' =>'alert-danger'
				);
				echo json_encode($out);
			}else{
				if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$email)){
					$out = array(
						'success' => false,
						'message' => "Modèle d'email invalide", //'Invalid Email Pattern',
						'class_name' =>'alert-info'
					);
					
				}else{	
					$check_login = "SELECT * FROM users WHERE email='$email' AND password='$password'";
					$logged_in = $conn->query($check_login);
					if($logged_in->num_rows >0){
						$select_id 	 = "SELECT * FROM users WHERE email='$email'";
						$selected_id = $conn->query($select_id);
						$row 		 = $selected_id->fetch_assoc();
						$id 		 = $row['id'];
						$firstname 	 = $row['firstname'];
						$email_id	 = $row['email'];
						$usertype	 = $row['usertype'];

						$_SESSION['email'] = $email_id;
						$_SESSION['id'] = $id;
						$_SESSION['firstname'] = $firstname;
						$_SESSION['usertype']  = $usertype;

						$out = array(
							'success' => true,
							'message' => 'Connectez-vous', //'Logging In...'
						);
					}else{
						$out = array(
							'success' => false,
							'message' => "Mauvaise combinaison d'email et de mot de passe", //'Wrong Email And Password Combination',
							'class_name' => 'alert-warning'
						);
					}
				}
				echo json_encode($out);
			}		
		break;

		case 'contact':
			$firstname 	= $_POST['contactfirstname'];
			$lastname 	= $_POST['contactlastname'];
			$subject	= $_POST['contactsubject'];	
			$email 		= $_POST['contactemail'];
			$message 	= $_POST['contactmessage'];
			if($email=='' || $firstname==''){
				$out = array(
					'success' => false,
					'message' => "Le nom et l'email sont obligatoires", //'Name and Email Are Mandatory',
					'class_name' =>'alert-danger'
				);
			}else{
				if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/",$email)){
					$out = array(
						'success' => false,
						'message' => "Email invalide!", //'Invalid Email!',
						'class_name' =>'alert-info'
					 );
				}else{
					// $reply_to = "contact@matmaps.be";
					$to = "contact@matmaps.be"; //Admin Email
					$from = "no-reply@matmaps.be";
					$body = "Enquiry from ".$firstname." ".$lastname."<br>";
					$body = $body."Email :- ".$email."<br>";
					$body = $body."Enquiry :- <br><br>";
					$body = $body.$message;
					$mailSent = sendMail($to, $from, $reply_to, $subject, $body);
					$out = array(
						'success' => true,
						'message' => "Votre requête est enregistrée avec succès. Nous vous répondrons dans les plus brefs délais." //'Your Query is successfully registered, We will get back to you soon.'
					);
				}
			}
				echo json_encode($out);
		break;

		case 'post_sand' :
			$address_build 	= $_POST['address_build'];
			$region 		= $_POST['region'];
			$postal_code 	= $_POST['postal_code'];
			$coordinates 	= json_encode($_POST['coordinates']);
			$type_of_sand 	= $_POST['type_of_sand'];
			$volume 		= $_POST['volume'];
			$trans_cost 	= $_POST['trans_cost'];
			$date_avail 	= $_POST['date_avail'];
			$post_image 	= $_POST['post_image'];
			$price 			= $_POST['price'];

			$email 			= $_SESSION['email'];
			$insert_sand 	= "INSERT INTO sand_posts VALUES (null,'$email','$address_build','$region','$postal_code','$coordinates','$type_of_sand','$volume','$trans_cost','$date_avail','$price','$post_image','$datetime')";
			if($conn->query($insert_sand)  === TRUE){
				$insert_id = $conn->insert_id;
				$out = array(
					'success' => true,
					// 'insert_id' => $insert_id
				);
			}else{
				$out = array(
					'success' => false,
					'message' => "Une erreur est survenue" //'Some error occured'
				);
			}
			echo json_encode($out);
		break;

		case 'update_posted_sand' :
			$address_build 	= $_POST['address_build'];
			$region 		= $_POST['region'];
			$postal_code 	= $_POST['postal_code'];
			$coordinates 	= json_encode($_POST['coordinates']);
			$type_of_sand 	= $_POST['type_of_sand'];
			$volume 		= $_POST['volume'];
			$trans_cost 	= $_POST['trans_cost'];
			$date_avail 	= $_POST['date_avail'];
			$post_image 	= $_POST['post_image'];
			$price 			= $_POST['price'];
			$post_id		= $_POST['post_id'];
			
			$email 			= $_SESSION['email'];

			$update_sand 	= "UPDATE sand_posts SET email='$email',address_build='$address_build',region='$region',postal_code='$postal_code',coordinates='$coordinates',type_of_sand='$type_of_sand',volume='$volume',trans_cost='$trans_cost',date_avail='$date_avail',post_image='$post_image',price='$price',datetime='$datetime' WHERE id='$post_id'";
			$updated 	 = $conn->query($update_sand);
			if($updated){
				$out = array(
					'success' => true
				);
			}else{
				$out = array(
					'success' => false,
					'message' => "Une erreur est survenue" //'Some error occured'
				);
			}
			echo json_encode($out);
		break;

		case 'delete_posted_sand':
			$dataId 		= $_POST['dataId'];
			$email 			= $_SESSION['email'];

			$delete_sand 	= "DELETE FROM `sand_posts` WHERE email='$email' AND id='$dataId'";
			$deleted 	 	= $conn->query($delete_sand);
			if($deleted){
				echo "deleted";
			}
		break;

		case 'edit_posted_sand':
			$dataId 		= $_POST['dataId'];
			$email 			= $_SESSION['email'];
			$posted_sands 	= "SELECT * FROM sand_posts WHERE id='$dataId'";
			$posted 	 	= $conn->query($posted_sands);
			$row_sand 	   	= $posted->fetch_assoc();
			
			echo json_encode(array('status'=>'edited','post_id'=>$row_sand['id'],'address_build'=>$row_sand['address_build'],'region'=>$row_sand['region'],'postal_code'=>$row_sand['postal_code'],'coordinates'=>$row_sand['coordinates'],'type_of_sand'=>$row_sand['type_of_sand'],'volume'=>$row_sand['volume'],'trans_cost'=>$row_sand['trans_cost'],'date_avail'=>$row_sand['date_avail'],'price'=>$row_sand['price'],'post_image'=>$row_sand['post_image']));
		break;

		case 'getMapMarkers':
			$filterData = $_POST['filterData'];
			$len = count($filterData);
			if ($len>0) {
				$where = ' WHERE ';
				$i=1;
				foreach ($filterData as $key => $value) {
					if ($key == 'volume') {
						if ($value == 'plus') {
							$where .= ''.$key.' > 210';
						}elseif ($value == 'moins') {
							$where .= ''.$key.' < 10';
						}else{
							$min = explode("_", $value)[0];
							$max = explode("_", $value)[1];
							$where .= 'volume BETWEEN '.$min .' AND '. $max;
						}
					}elseif ($key == 'price') {
						if (strtolower($value) == 'free') {
							$where .= ''.$key.' = "'.$value.'"';
						}else{
							$where .= '('.$key.' <= '.$value.'';
							$where .= ' or '.$key.' = '.$value.')';
						}
					}elseif ($key == 'trans_cost') {
						$where .= ''.$key.' <= '.$value.'';
					}else{
						$where .= ''.$key.' = "'.$value.'"';
					}
					if($i!=$len)
						$where.=" and ";
					$i++;
				}
			}
			$posted_sands 	= "SELECT * FROM sand_posts".$where;
			$posted 	 	= $conn->query($posted_sands);
			// $row_sand 	   	= $posted->fetch_assoc();
			$i=0;
			$data = array();
			while($row_sand = $posted->fetch_assoc()){
				$coordinates = array_filter( json_decode($row_sand['coordinates']));
				if (!count($coordinates)) {
					continue;
				}
				$i++;
				$marker = array();
				$marker['id'] = "marker-".$row_sand['id'];
				$marker['center'] = $coordinates;
				$marker['title'] = $row_sand['type_of_sand'];
				$marker['price'] = "€ ".$row_sand['price'];
				if ($row_sand['post_image'] && $row_sand['post_image']!= "") {
					$marker['image'] = "posts/".$row_sand['post_image'];
				}else{
					$marker['image'] = "/assets/img/sandicon.png";
				}
				array_push($data, $marker);
			}
			echo json_encode($data);
		break;

		case 'post_product':
			$email_id 			  = $_SESSION['email'];
			$const_address_build  = $_POST['const_address_build'];
			$const_region         = $_POST['const_region'];
			$const_postal_code    = $_POST['const_postal_code'];
			$product_type         = $_POST['product_type'];
			$const_price          = $_POST['const_price'];
			$product_image		  = $_POST['product_image'];
			$insert_construction  = "INSERT INTO construction VALUES (null,'$email_id','$const_address_build','$const_region','$const_postal_code','$product_type','$product_image','$const_price','$datetime')";

			if($inserted = $conn->query($insert_construction)){
				echo "inserted_construction";
			}

		break;

		case 'update_posted_product' :
            $const_address_build  = $_POST['const_address_build'];
            $const_region         = $_POST['const_region'];
            $const_postal_code    = $_POST['const_postal_code'];
            $product_type         = $_POST['product_type'];
            $const_price          = $_POST['const_price'];
            $product_image        = $_POST['product_image'];
		    $post_id              = $_POST['dataId'];

		    $email 				  = $_SESSION['email'];

		    if(!empty($product_image)){
			 	$update_product = "UPDATE construction SET address='$const_address_build',region='$const_region',postal_code='$const_postal_code',type_of_good='$product_type',good_image='$product_image',price='$const_price',datetime='$datetime' WHERE id='$post_id'";
		    }else{
		     	$update_product = "UPDATE construction SET address='$const_address_build',region='$const_region',postal_code='$const_postal_code',type_of_good='$product_type',price='$const_price',datetime='$datetime' WHERE id='$post_id'";
		    }

			$updated 	 = $conn->query($update_product);
			if($updated){
				$out = array(
					'success' => true,
					'message' => "Details Updated Successfully" // successfully updated
				);
			}else{
				$out = array(
					'success' => false,
					'message' => "Une erreur est survenue" //'Some error occured'
				);
			}
			echo json_encode($out);
		break;

		case 'edit_posted_product':
			$dataId 		= $_POST['dataId'];
			$email 			= $_SESSION['email'];

			$posted_product = "SELECT * FROM construction WHERE id='$dataId'";
			$posted 	 	= $conn->query($posted_product);
			$row_product 	= $posted->fetch_assoc();
			
			echo json_encode(array('status'=>'edited','post_id'=>$row_product['id'],'const_address'=>$row_product['address'],'const_region'=>$row_product['region'],'const_postal_code'=>$row_product['postal_code'],'const_type_of_good'=>$row_product['type_of_good'],'const_price'=>$row_product['price'],'const_good_image'=>$row_product['good_image']));
		break;

		// case 'edit_construction':
		// 	$dataId 		= $_POST['dataId'];
		// 	$email 			= $_SESSION['email'];
		// 	$posted_product = "SELECT * FROM construction WHERE id='$dataId'";
		// 	$posted 	 	= $conn->query($posted_product);
		// 	$row_product 	= $posted->fetch_assoc();
			
		// 	echo json_encode(array('status'=>'edited','post_id'=>$row_product['id'],'const_address'=>$row_product['address'],'const_region'=>$row_product['region'],'const_postal_code'=>$row_product['postal_code'],'const_type_of_good'=>$row_product['type_of_good'],'const_price'=>$row_product['price'],'const_good_image'=>$row_product['good_image']));
		// break;

		case 'delete_posted_goods':
			$dataId 		= $_POST['dataId'];
			$email 			= $_SESSION['email'];

			$delete_sand 	= "DELETE FROM `construction` WHERE email='$email' AND id='$dataId'";
			$deleted 	 	= $conn->query($delete_sand);
			if($deleted){
				echo "deleted";
			}
		break;

		case 'email_forgot':
			$_SESSION['email_forgot'] = $email = $_POST['email'];
			$check_email = "SELECT * FROM users WHERE email='$email'";
			$checked 	 = $conn->query($check_email);
			$row 	   	 = $checked->fetch_assoc();
			$firstname 	 = $row['firstname'];

			$_SESSION['otp'] = $validation_key = rand();
			if ($checked->num_rows > 0) {
				include '../email_templates/mail_vars.php';
				$to = $email;
				$from = "no-reply@matmaps.be";
				// $body = $validation_key;
				$body = $forgot_mail_body;
				$subject = "Mat&Maps OTP - ".$validation_key;
				$mailSent = sendMail($to, $from, $reply_to, $subject, $body);
				if ($mailSent) {
					echo json_encode(array('success'=>true));
				}else{
					echo json_encode(array('success'=>false,'message'=>'Une erreur est survenue'));
				}
				
			}else {
				echo json_encode(array('success'=>false,'message'=>'Email is not registered'));
			}
		break;

		case 'verify_otp':
			$password = $_POST['password'];
			$email_forgot = $_SESSION['email_forgot'];
			if ($_POST['otp'] == $_SESSION['otp']) {
				$new_passowrd = md5($password);
				$update_product = "UPDATE users SET password='$new_passowrd' WHERE email='$email_forgot'";
				$updated 	 = $conn->query($update_product);
				if($updated){
					unset($_SESSION['email_forgot']);
					unset($_SESSION['otp']);
					$out = array(
						'success' => true,
						'message' => 'Mot de passe mis à jour avec succès!' //'Password Updated Successfully!'
					);
				}else{
					$out = array(
						'success' => false,
						'message' => "Une erreur est survenue" //'Some error occured'
					);
				}
				
			}else {
				$out = array(
						'success' => false,
						'message' => "Code de vérification invalide" //'Invalid Verification Code'
					);
			}
			echo json_encode($out);
		break;

		case 'email_contact_sand':
			$email = $_SESSION['email'];
			$contact_number = $_POST['contact_number'];
			$contact_msg 	= $_POST['contact_msg'];
			$sand_id 		= $_POST['sand_id'];
			
			$check_email = "SELECT * FROM users WHERE email='$email'";
			$checked 	 = $conn->query($check_email);
			$row 	   	 = $checked->fetch_assoc();
			$firstname 	 = $row['firstname'];
			$lastname 	 = $row['lastname'];
			
			$select_post   	= "SELECT * FROM sand_posts WHERE id = '$sand_id'";
			$selected_post 	= $conn->query($select_post);
			$row 			= $selected_post->fetch_assoc();
		    $supplier_email = $row['email'];
		    $address_build 	= $row['address_build'];
		    $region 	   	= $row['region'];
		    $postal_code 	= $row['postal_code'];
		    $volume 		= $row['volume'];
		    $type_of_sand 	= $row['type_of_sand'];
		    $trans_cost 	= $row['trans_cost'];
		    $price 			= $row['price'];
		    $date_avail 	= $row['date_avail'];
		    $post_image 	= $row['post_image'];
			
		    $supply_email 	= "SELECT * FROM users WHERE email='$supplier_email'";
			$checked_supply = $conn->query($supply_email);
			$row_supply 	= $checked_supply->fetch_assoc();
			$supply_name 	= $row_supply['firstname'];

			include '../email_templates/mail_vars.php';
			$to = $email;
			$from = "no-reply@matmaps.be";
			// $body = $validation_key;
			$body 	 = $contact_sand_body;
			$subject = $firstname." Shown interest on your sand - Mat&Maps";
			$mailSent = sendMail($to, $from, $reply_to, $subject, $body);
			if ($mailSent) {
				echo json_encode(array('success'=>true,'message'=>'Mail successfully sent. Supplier will contact you soon.'));
			}else{
				echo json_encode(array('success'=>false,'message'=>'Some error occurs'));
			}
		break;

		case 'email_contact_sand':
			$email = $_SESSION['email'];
			$contact_number = $_POST['contact_number'];
			$contact_msg 	= $_POST['contact_msg'];
			$sand_id 		= $_POST['sand_id'];
			
			$check_email = "SELECT * FROM users WHERE email='$email'";
			$checked 	 = $conn->query($check_email);
			$row 	   	 = $checked->fetch_assoc();
			$firstname 	 = $row['firstname'];
			$lastname 	 = $row['lastname'];
			
			$select_post   	= "SELECT * FROM sand_posts WHERE id = '$sand_id'";
			$selected_post 	= $conn->query($select_post);
			$row 			= $selected_post->fetch_assoc();
		    $supplier_email = $row['email'];
		    $address_build 	= $row['address_build'];
		    $region 	   	= $row['region'];
		    $postal_code 	= $row['postal_code'];
		    $volume 		= $row['volume'];
		    $type_of_sand 	= $row['type_of_sand'];
		    $trans_cost 	= $row['trans_cost'];
		    $price 			= $row['price'];
		    $date_avail 	= $row['date_avail'];
		    $post_image 	= $row['post_image'];
			
		    $supply_email 	= "SELECT * FROM users WHERE email='$supplier_email'";
			$checked_supply = $conn->query($supply_email);
			$row_supply 	= $checked_supply->fetch_assoc();
			$supply_name 	= $row_supply['firstname'];

			include '../email_templates/mail_vars.php';
			$to = $email;
			$from = "no-reply@matmaps.be";
			// $body = $validation_key;
			$body 	 = $contact_sand_body;
			$subject = $firstname." Shown interest on your sand - Mat&Maps";
			$mailSent = sendMail($to, $from, $reply_to, $subject, $body);
			if ($mailSent) {
				echo json_encode(array('success'=>true,'message'=>'Mail successfully sent. Supplier will contact you soon.'));
			}else{
				echo json_encode(array('success'=>false,'message'=>'Some error occurs'));
			}
		break;

		default:
			echo "Oops an error occured!";
		break;
	}
?>