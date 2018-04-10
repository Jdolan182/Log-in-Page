<?php
session_start();

session_unset(); 

session_destroy(); 

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


.backbtn {
    width: auto;
    padding: 10px 18px;
    background-color: darkblue;
}

.container {
    padding: 16px;
}


</style>
	<body>
	<h2> You are now logged out</h2>

		<form action="LoginPage.php">

  
		<div class="container">
			<p>Click here to go back to login page</p>
			<button type="submit" class="backbtn">Back</button>
        </div>

	</form>
	</body>
</html>