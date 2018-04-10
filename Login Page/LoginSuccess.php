<?php
session_start();
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

.container {
    padding: 16px;
}


</style>
	<body>
	<h2> You are logged in</h2>

		<form action="LogoutPage.php">

  
		<div class="container">
			<p>Hello <?php echo $_SESSION['name']?></p>
			<button type="submit" class="logoutbtn">Logout</button>
        </div>

	</form>
	</body>
</html>