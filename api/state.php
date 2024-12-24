<?php
session_start();
if(!isset($_SESSION['tittu']))
{
	echo"invalid";
	exit();
}


  $userid=$_SESSION['id'];
  $usertype=$_SESSION['usertype'];
  $useremail=$_SESSION['tittu'];
  require('../connect.php');
  
  $time=date("H:i:s"); 
  $datetime = date("Y-m-d H:i:s");
  $date=date("Y-m-d");
  
		  $query="select * From states ";
	  
     $res=mysqli_query($con,$query);
	 $response=array();

	 
	 while($row=mysqli_fetch_array($res))
	 {
		 		 $rr=array("id"=>$row["id"],"status"=>$row["status"],"name"=>$row["name"]);
		 $response[]=$rr;
     }	 
	 $data=json_encode($response);
	 echo $data;
	 
	 
   
   if(isset($_GET['statestatus']))
   {
      $status=$_GET['status'];
	  $id=$_GET['id'];

	  $query1="update states set status='$status' where id='$id' ";
	  mysqli_query($con,$query1) or die(mysqli_error($con));
	  
	  if(mysqli_affected_rows($con)>0)
	  {  
		echo"success"; 
	  }
	  else
	  {
	    echo "error";
	  }
   }  else if(isset($_GET['deletestate']))
  { $id=$_GET['id'];
  	if(!empty($id)){
      $result=mysqli_query($con," DELETE FROM `states` WHERE id='$id'");
      if($result) {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
     }	
  	}
  }

 

?>