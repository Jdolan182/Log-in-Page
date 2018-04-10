<?php
session_start();


 if (isset($_SESSION['name'])) {
	header("Location:LoginSuccess.php");
 }
 ?>
<html>
<!DOCTYPE html>
<header>
</header>
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
	document.getElementById("emailErr").innerHTML = "";
	
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
   document.getElementById("passErr").innerHTML = "Invalid password";
   
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
<body>
<h2> Login Form</h2>

<form name="form" id="myForm" action="LoginCheck.php" method="post" onSubmit=" return continueOrNot();">

  <div class="container">
    <label><b>Username (Email)	</b></label>
    <input id="username" class="txtBox" type="text" onBlur="checkEmail()" placeholder="Enter Username" name="uname">
	<span class="error" id="emailErr"></span>
	</br></br>

    <label><b>Password</b></label>
    <input id="password" class="txtBox" type="password" onBlur="checkPass()" placeholder="Enter Password" name="psw">
	<span class="error" id="passErr"></span>
	</br></br>
	
    <button type="submit" >Login</button>
      </div>
	  
  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="registerbtn" onclick="document.location.href = 'RegisterPage.php'">Register</button>
    <span class="psw" onclick="document.location.href = 'ForgotPasswordPage.php'">Forgot <a href="#">password?</a></span>
	  </div>

</form>


  
</body>
</html>
