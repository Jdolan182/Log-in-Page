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
			var emailErrText = document.getElementById("emailErr").innerHTML;
			if(emailErrText != "Invalid email"){
			document.getElementById("emailErr").innerHTML = "";
			}
			emailTaken = false;
		}
    }
  };
  var email = document.form["email"].value;
  xhttp.open("GET", "EmailValidate.php?email="+email, true);
  xhttp.send();
}


function continueOrNot(){

	var emailBool = checkEmail();
	var passBool = checkPass();
	var nameBool = checkName();
	
	if(emailBool && passBool && nameBool && emailTaken == false){
		return true;
	}
	else{
		return false;
	}

	

}
</script>
<body>
<h2> Register Form</h2>

<form name="form" id="myForm" action="AddUser.php" method="post" onSubmit=" return continueOrNot();">

  <div class="container">
    <label><b>Name</b></label>
    <input id="name" type="text" class="txtBox" onBlur="checkName()" placeholder="Enter your name" name="name">
	<span class="error" id="nameErr"></span>
	</br></br>
	
	<label><b>Email Address</b></label>
	<input id="email" type="text" class="txtBox" onBlur="checkEmail(); emailValidate();" placeholder="Enter your email address" name="email">
    <span class="error" id="emailErr"></span>
	</br></br>
	
    <label><b>Password</b></label>
    <input id="password" type="password" class="txtBox" onBlur="checkPass()" placeholder="Enter Password" name="psw">
	<span class="error" id="passErr"></span>
	</br></br>
	
    <button type="submit" >Register</button>
      </div>

  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="backbtn" onclick="document.location.href = 'LoginPage.php'">Back</button>
  </div>
</form>
</body>
</html>
