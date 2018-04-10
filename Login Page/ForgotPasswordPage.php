<?php
session_start();


 if (isset($_SESSION['name'])) {
	header("Location:LoginSuccess.php");
 }
 ?>
<!DOCTYPE html>
<html>
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
   document.getElementById("emailErr").innerHTML = "Invalid email";
   
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
<body>
<h2> Forgot Password?</h2>

<form action="SendPassword.php" method="post" onSubmit="return continueOrNot();">

  <div class="container">
	<label><b>Email Address</b></label>
	<input id="email" class="txtBox" onBlur="checkEmail()" type="text" placeholder="Enter your email address" name="email">
	<span class="error" id="emailErr"></span>
	
    <button type="submit">Send password reset email</button>
      </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="backbtn" onclick="document.location.href = 'LoginPage.php'">Back</button>
  </div>
</form>
</body>
</html>
