<?php
  include('../connect.php');
 
    class Login
	{
	    var $con;	
		var $user;
		var $pass;
	   public function __construct($con,$user,$pass)
	   {
		   $this->user=$user;
		   $this->pass=$pass;
		   $this->con=$con;
	   }
	   public function login()
	   {
		   $res=mysqli_query($this->con,"select * from employees where email='$this->user' and password=password('$this->pass') and usertype='1' and designationid='1'") or die(mysqli_error($con));
		   if($row=mysqli_fetch_array($res))
		   {
			   $_SESSION['tittu']=$row['email'];
			   $_SESSION['empname']=$row['name'];
			   $_SESSION['empid']=$row['empid'];
			   $_SESSION['id']=$row['id'];
			   $_SESSION['image']=$row['image'];
			   $_SESSION['usertype']=$row['usertype'];
			   return true;	
		   }
		   else
		   {
			   return true;
		   }
	   }
    }
	

?>