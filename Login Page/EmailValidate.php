<?php
 //$email = $_GET['uname'];
 
 $email = $_GET["email"];
 
 
   $con=mysqli_connect("mysql0.cs.stir.ac.uk","jdo","jdo","jdo");
   
   //Check connection
   if (mysqli_connect_errno())
   {
   echo "Failed to connect to MySQL: " . mysqli_connect_error();
   }
   
  $result= mysqli_query($con,"SELECT Email FROM login_details WHERE Email = '$email'") or die("Error: ".mysqli_error($con));
 
  
  $rowcount=mysqli_num_rows($result);
      if($rowcount !=0)
   {
	   echo "true";
   }
   else{
	   echo "false";
   }
   
  
   mysqli_close($con);
   
?>
