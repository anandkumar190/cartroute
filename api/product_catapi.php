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
 
 

	 
	 
   
   if(isset($_GET['statestatus']))
   {
      $status=$_GET['status'];
	  $id=$_GET['id'];

	  $query1="update product_cat set status='$status' where id='$id' ";
	  mysqli_query($con,$query1) or die(mysqli_error($con));
	  
	  if(mysqli_affected_rows($con)>0)
	  {  
		echo"success"; 
	  }
	  else
	  {
	    echo "error";
	  }
   }
   
     
  if(isset($_GET['insert']))
  {
	  //$_POST=json_decode(file_get_contents("php://input"));
	  extract($_POST);
	
	  $query = "select name from product_cat where `name` = '$name'";
	  //echo($pshort);
	  $res=mysqli_query($con,$query);
	  if( mysqli_num_rows($res) > 0 ){
			echo "name";
			return;
	  }

	 	  $name=ucwords($name);
	mysqli_query($con,"insert into `product_cat`(name) values('$name')") or die(mysqli_error($con));
	
	if(mysqli_affected_rows($con)>0)
	{
	       echo"success";
	  
	}
	else
	  {
        echo"error";
	  }
	
  } 
   else if(isset($_GET['deletecatid']))
  { $id=$_GET['id'];
  	if(!empty($id)){
      $result=mysqli_query($con," DELETE FROM `product_cat` WHERE id='$id'");
      if($result) {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
     }	
  	}
  }

    else if(isset($_GET['edit']))
  {
	  //$_POST=json_decode(file_get_contents("php://input"));
	  extract($_POST);
	
	  //var_dump($_POST);
	  
/*	  $query = "select city from cities where  city = '$name'";
	  //echo($pshort);
	  $res=mysqli_query($con,$query);
	  if( mysqli_num_rows($res)> 0 ){
			echo "name";
			return;
	  }*/
	  
	      //$filename=$pname.$pshort.".jpg";
	      	  $name=ucwords($name);
	      mysqli_query($con,"update product_cat set name='$name' where id='$id'") or die(mysqli_error($con));
	      if(mysqli_affected_rows($con)>0)
       	  {
	          echo"success";  
	      }
		  else
		  {
			  echo"No changes affected...";
		  }
	   
  }else{
       $query="SELECT id,name,status FROM product_cat ";
	  
          $res=mysqli_query($con,$query);
	      $response=array();
     

	 
	 while($row=mysqli_fetch_array($res))
	 {
		 $rr=array("id"=>$row["id"],"name"=>$row["name"],"status"=>$row["status"]);
         $response[]=$rr;
     }
     
  
	 $data=json_encode($response);
	 echo $data;
      
  }
  
  
 

?>