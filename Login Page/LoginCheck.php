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


button {
    background-color: darkblue;
    color: white;
    padding: 14px 20px;
    margin: 8px 0;
    border: none;
    cursor: pointer;
    width: 100%;
}

.logoutbtn {
    width: auto;
    padding: 10px 18px;
    background-color: darkblue;
}
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

.registerbtn {
    width: auto;
    padding: 10px 18px;
    background-color: darkblue;
}

.container {
    padding: 16px;
}

span.psw {
    float: right;
    padding-top: 16px;
}

.error {color: #FF0000;}

</style>
<script>

	var emailTaken = false;

function validatePassword(password){
   var re = (/^(?=.*\d)[0-9a-zA-Z]{8,}$/);
   return re.test(password);
}



function validateEmail(email) {
  var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})/i;
  return re.test(email);
}

function checkEmail() {
  var email = document.getElementById('username').value;
  
  if (validateEmail(email)) {
	document.getElementById("username").className = " greenborder";
	
	
	var emailErrText = document.getElementById("emailErr").innerHTML;
	if(emailErrText != "That email has not registered an account"){
	document.getElementById("emailErr").innerHTML = "";
	}
	return true;
  }
  
  else{
   document.getElementById("username").className = " redborder";
   document.getElementById("emailErr").innerHTML = "Invalid email";
   
    return false;
  }
  
 
}

function checkPass(){
  var password = document.getElementById('password').value;
  
  if (validatePassword(password)) {
   document.getElementById("password").className = " greenborder";
   document.getElementById("passErr").innerHTML = "";
   
   return true;
  }
  else{
   document.getElementById("password").className = " redborder";
   
   	var passErrText = document.getElementById("passErr").innerHTML;
		if(passErrText != "Incorrect password. Click 'forgot password' to reset your password"){
	document.getElementById("passErr").innerHTML = "Invalid password";
	}
  
   
   return false;
  }
  
  
}

 
function continueOrNot(){
	
	var emailBool = checkEmail();
	var passBool = checkPass();

	if(emailBool && passBool){
		return true
	}
	else{
		return false;
	}
}
</script>
<?php

 $username = $_POST['uname'];
 $passwrd = $_POST['psw'];
 
 if($username == null || $passwrd == null){
	header("Location:LoginPage.php");
 }
 
 
 $encryptPass = md5($passwrd);
 
 $emailErr = false;
 $passErr = false;
 
 $wrongEmail = false;
 $wrongPass = false;
 
 $emailErrText = "";
 $passErrText = "";
 
 
 
   $con=mysqli_connect("mysql0.cs.stir.ac.uk","jdo","jdo","jdo");
   
   //Check connection
   if (mysqli_connect_errno())
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   
   
   if (!filter_var($username, FILTER_VALIDATE_EMAIL)) {
	 $emailErr = true; 
	 $emailErrText = "Invalid email";
	 
   }
   
   
	if(!preg_match(('/^\S*(?=\S{8,})(?=\S*[\d])\S*$/'), $passwrd)){
	 $passErr = true; 
	 $passErrText = "Invalid password";
	}
   
   
	if($emailErr == false){
		$result= mysqli_query($con,"SELECT Email FROM login_details WHERE Email = '$username'") or die("Error: ".mysqli_error($con));
		
		
		$rowcount=mysqli_num_rows($result);
		if($rowcount == 0){
			$wrongEmail = true;
			$emailErrText = "That email has not registered an account";	
		}

	}
	
		if($passErr == false && $wrongEmail == false){
		$result= mysqli_query($con,"SELECT Password FROM login_details WHERE Email = '$username'") or die("Error: ".mysqli_error($con));
		$row = mysqli_fetch_assoc($result);
		
		$rowcount=mysqli_num_rows($result);
		if($rowcount != 0){
			if($row["Password"] != $encryptPass){
				$wrongPass = true;
				$passErrText = "Incorrect password. Click 'forgot password' to reset your password";
			}
			
		}

	}
   
   
   if($emailErr == true || $passErr == true || $wrongEmail == true || $wrongPass == true){
	   ?>
	<body>
	<h2> Login Form</h2>

	<form  name="form" id="myForm" action="LoginCheck.php" method="post">

		<div class="container">
			<label><b>Username (Email)	</b></label>
			<input id="username" class="txtBox" type="text" onBlur="checkEmail()" placeholder="Enter your email address" name="uname">
			<span class="error" id="emailErr"><?echo $emailErrText; ?></span>
			</br></br>

			<label><b>Password</b></label>
			<input id="password" class="txtBox" type="password" onBlur="checkPass()" placeholder="Enter Password" name="psw">
			<span class="error" id="passErr"><?echo $passErrText; ?></span>
			</br></br>
	
			<button type="submit" >Login</button>
		</div>
	  
		<div class="container" style="background-color:#f1f1f1">
			<button type="button" class="registerbtn" onclick="document.location.href = 'RegisterPage.php'">Register</button>
			<span class="psw" onclick="document.location.href = 'ForgotPasswordPage.php'">Forgot <a href="#">password?</a></span>
		</div>

	</form>
	</body>
	<? if($passErr == true){
			echo "<script> checkPass(); </script>";
		}
		if($emailErr == true){
			echo "<script> checkEmail(); </script>";
		}
   }
  else{  
  $result= mysqli_query($con,"SELECT Password FROM login_details WHERE Email = '$username'") or die("Error: ".mysqli_error($con));
  $row = mysqli_fetch_assoc($result);
  
  $result1= mysqli_query($con,"SELECT Name FROM login_details WHERE Email = '$username'") or die("Error: ".mysqli_error($con));
  $name = mysqli_fetch_assoc($result1);
  
  $rowcount=mysqli_num_rows($result);
      if($rowcount !=0)
   {
  if($row["Password"] == $encryptPass)
  { 
	$_SESSION['name'] = $name['Name'];
	header("Location:LoginSuccess.php");
  }
  }
  }
  
  //Close database    
  mysqli_close($con);
   

?>
</html>	