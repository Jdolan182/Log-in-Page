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

.backbtn {
    width: auto;
    padding: 10px 18px;
    background-color: darkblue;
}

</style>
<script>


	var emailTaken = true;


function validatePassword(password){
   var re = (/^(?=.*\d)[0-9a-zA-Z]{8,}$/);
   return re.test(password);
}



function validateEmail(email) {
  var re = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})/i;
  return re.test(email);
}

function checkName() {
  var name = document.getElementById('name').value;
  
  if (name != "") {
	document.getElementById("name").className = "greenborder";
	document.getElementById("nameErr").innerHTML = "";
	
	return true;
  }
  else{
   document.getElementById("name").className = "redborder";
   document.getElementById("nameErr").innerHTML = "You must enter a name";
   
    return false;
  }
  
 
}

function checkEmail() {
  var email = document.getElementById('email').value;
  
  if (validateEmail(email)) {
	document.getElementById("email").className = " greenborder";
	
	var emailErrText = document.getElementById("emailErr").innerHTML;
	if(emailErrText != "That email is already registered"){
	document.getElementById("emailErr").innerHTML = "";
	}
	
	return true;
  }
  else{
   document.getElementById("email").className = " redborder";
   	var emailErrText = document.getElementById("emailErr").innerHTML;
	if(emailErrText != "That email is already registered"){
	document.getElementById("emailErr").innerHTML = "Invalid email";
	}
   
   
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
   document.getElementById("passErr").innerHTML = "Invalid password. Passwords must be 8 characters long and contain at least one number";
   
   return false;
  }

  
}

function emailValidate() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
	
		var response = this.responseText;
		if(response == "true"){
			document.getElementById("emailErr").innerHTML = "That email is already registered";	
			emailTaken = true;
		}
		else{
			document.getElementById("emailErr").innerHTML = "";
			emailTaken = false;
		}
    }
  };
  var email = document.form["email"].value;
  //ask about false
  xhttp.open("GET", "email_validate.php?email="+email, false);
  xhttp.send();
}


function continueOrNot(){

	emailValidate();

	var emailBool = checkEmail();
	var passBool = checkPass();
	var nameBool = checkName();

	if(emailBool && passBool && nameBool && emailTaken == false){
		return true;
	}
	else{
		return false
	}

	

}
</script>
<?php
 $name = $_POST['name'];
 $email = $_POST['email'];
 $passwrd = $_POST['psw'];
 
 $encryptPass = md5($passwrd);
 
 $nameErr = false;
 $emailErr = false;
 $passErr = false;
 
 $emailExist = false;
 
 
 $nameErrText = "";
 $emailErrText = "";
 $passErrText = "";
 
 
   $con=mysqli_connect("mysql0.cs.stir.ac.uk","jdo","jdo","jdo");
   
   //Check connection
   if (mysqli_connect_errno())
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   
   
   if($name == null){
	 $nameErr = true; 
	 $nameErrText = "You must enter a name";
   }
   
      //ask if this needs to be a regular expression instead
   if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	 $emailErr = true; 
	 $emailErrText = "Invalid email";
	 
   }
   
   if($emailErr == false){
	$result= mysqli_query($con,"SELECT Email FROM login_details WHERE Email = '$email'") or die("Error: ".mysqli_error($con));
		
		
		$rowcount=mysqli_num_rows($result);
		if($rowcount != 0){
			$emailExist = true;
			$emailErrText = "That email is already registered";	
		}

	}
   
   
	if(!preg_match(('/^\S*(?=\S{8,})(?=\S*[\d])\S*$/'), $passwrd)){
	 $passErr = true; 
	 $passErrText = "Invalid password";
	}
   
   if($nameErr == true || $emailErr == true || $passErr == true || $emailExist == true){
	   ?>
		<body>
		<h2> Register Form</h2>

		<form name="form" id="myForm" action="AddUser.php" method="post" onSubmit="return continueOrNot();">

			<div class="container">
				<label><b>Name</b></label>
				<input id="name" type="text" class="txtBox" onBlur="checkName()" placeholder="Enter your name" name="name">
				<span class="error" id="nameErr"><?echo $nameErrText; ?></span>
				</br></br>
	
				<label><b>Email Address</b></label>
				<input id="email" type="text" class="txtBox" onBlur="checkEmail()" placeholder="Enter your email address" name="email">
				<span class="error" id="emailErr"><?echo $emailErrText; ?></span>
				</br></br>
	
				<label><b>Password</b></label>
				<input id="password" type="password" class="txtBox" onBlur="checkPass()" placeholder="Enter Password" name="psw">
				<span class="error" id="passErr"><?echo $passErrText; ?></span>
				</br></br>
	
				<button type="submit" >Register</button>
			</div>

			<div class="container" style="background-color:#f1f1f1">
				<button type="button" class="backbtn" onclick="document.location.href = 'LoginPage.php'">Back</button>
			</div>
		</form>
		</body>
		<? if($passErr == true){
			echo "<script> checkPass(); </script>";
		}
				if($nameErr == true){
			echo "<script> checkName(); </script>";
		}
				if($emailErr == true || $emailExist == true){
			echo "<script> checkEmail(); </script>";
		}
	}
	else{
		
  $result1= mysqli_query($con,"INSERT INTO login_details VALUES('$name', '$email', '$encryptPass')")or die("Error: ".mysqli_error($con));
 
  $result2= mysqli_query($con,"SELECT Email FROM login_details WHERE Email = '$email'") or die("Error: ".mysqli_error($con));

   
   $rowcount=mysqli_num_rows($result2);
      if($rowcount !=0)
   {	   
	header("Location:RegisterSucess.php");
   }
	}
   
   # Close database    
   mysqli_close($con);
   
   
?>

</html>