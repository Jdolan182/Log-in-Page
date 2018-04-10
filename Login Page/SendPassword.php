<?php
session_start();


 if (isset($_SESSION['name'])) {
	header("Location:LoginSuccess.php");
 }
 ?>
<html>
<style>
form {
    border: 3px solid #f1f1f1;
	width: 30%;
}

.txtBox {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
    box-sizing: border-box;
}

.greenborder{
    border: 3px solid #05ee15;
	width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    box-sizing: border-box;
}

.redborder{
    border: 3px solid #f61d18;
	width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;	
    box-sizing: border-box;
}


button {
    background-color: darkblue;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

.backbtn {
    width: auto;
    padding: 10px 18px;
    background-color: darkblue;
}

.container {
    padding: 16px;
}

.error {color: #FF0000;}

</style>
<script>


function validatePassword(password){
   var re = (/^(?=.*\d)[0-9a-zA-Z]{8,}$/);
   return re.test(password);
}



function validateEmail(email) {
  var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})/i;
  return re.test(email);
}

function checkEmail() {
  var email = document.getElementById('email').value;
  
  if (validateEmail(email)) {
	document.getElementById("email").className = " greenborder";
	document.getElementById("emailErr").innerHTML = "";

	
	return true;
  }
  else{
   document.getElementById("email").className = " redborder";
   
   var emailErrText = document.getElementById("emailErr").innerHTML;
	if(emailErrText != "That email is not a registered user. Try again or go back and register"){
   document.getElementById("emailErr").innerHTML = "Invalid email";
   }
   
    return false;
  }
  
 
}



function continueOrNot(){

	if(checkEmail()){
		return true;
	}
	else{
		return false;
	}
}



</script>

<?php

function randomPassword(){
	
    $length = 8;
    $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
    $string = "";

    for ($p = 0; $p <= $length; $p++) {
        @$string .= $characters[mt_rand(0, strlen($characters))];
    }

    return $string;
}

 $email = $_POST['email'];
 
 $emailErrText = "";
 
 $emailErr = false;
 $wrongEmail = false;
 
 
 $password = randomPassword();
 
 

 
 
   $con=mysqli_connect("mysql0.cs.stir.ac.uk","jdo","jdo","jdo");
   
   //Check connection
   if (mysqli_connect_errno())
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   
   
   
   
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailErr = true; 
		$emailErrText = "Invalid email";
	 
   }
   
   
   if($emailErr == false){
		$result= mysqli_query($con,"SELECT Email FROM login_details WHERE Email = '$email'") or die("Error: ".mysqli_error($con));
		
		
		$rowcount=mysqli_num_rows($result);
		if($rowcount == 0){
			$wrongEmail = true;
			$emailErrText = "That email is not a registered user. Try again or go back and register";
		}
   }
 
   
   if($emailErr == true || $wrongEmail ==true){
	      ?>
	<body>
	<h2> Forgot Password?</h2>

	<form action="SendPassword.php" method="post" onSubmit="return continueOrNot();">

		<div class="container">
			<label><b>Email Address</b></label>
			<input id="email" class="txtBox" onBlur="checkEmail()" type="text" placeholder="Enter your email address" name="email">
			<span class="error" id="emailErr"><?echo $emailErrText; ?></span>
			
			<button type="submit">Send password reset email</button>
		</div>

		<div class="container" style="background-color:#f1f1f1">
			<button type="button" class="backbtn" onclick="document.location.href = 'LoginPage.php'">Back</button>
		</div>
	<form>
	</body>
<?
  }
else{ 
   
  $result= mysqli_query($con,"SELECT * FROM login_details WHERE Email = '$email'") or die("Error: ".mysqli_error($con));
  $row = mysqli_fetch_assoc($result);

  $rowcount=mysqli_num_rows($result);
      if($rowcount !=0)
   {
	    $msg = "You have requested that your password be reset. Your password has been reset to: '$password'";

		// use wordwrap() if lines are longer than 70 characters
		$msg = wordwrap($msg,70);

		// send email
		mail($email, "Password Reset",$msg);
		
		$password = md5($password);
		
		$result1= mysqli_query($con,"UPDATE login_details SET Password = '$password' WHERE Email = '$email'") or die("Error: ".mysqli_error($con));
   ?>
	<body>
	<h2> Your password has been reset</h2>

		<form action="LoginPage.php">

  
		<div class="container">
			<p>A new password has been sent to you in an email?</p>
			<button type="submit" class="loginbtn">Back</button>
        </div>

	</form>
	</body>
<?
  }
}
	 
  
  //Close database    
  mysqli_close($con);
   

?>
</html>	