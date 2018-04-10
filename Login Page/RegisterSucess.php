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
	width: 20%;
}

input[type=text], input[type=password] {
    width: 100%;
    padding: 12px 20px;
    margin: 8px 0;
    display: inline-block;
    border: 1px solid #ccc;
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

.loginbtn {
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

</style>
<body>
<h2> User registered</h2>

<form action="LoginPage.php">

  
  <div class="container">
	<p>You have registered an account. Click here to login</p>
    <button type="submit" class="loginbtn">Login</button>
      </div>

</form>
</body>
</html>
