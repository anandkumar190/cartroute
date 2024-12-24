<?php
  require('../connect.php');
  $time=date("H:i:s"); 
  $datetime = date("Y-m-d H:i:s");
  $date=date("Y-m-d");
  if(isset($_GET['insert']))
  {

/*	  var_dump($_POST);
	  $_POST=json_decode(file_get_contents("php://input"));*/

	extract($_POST);
	  $query = "select productid from skus where productid = '$pshort'";
	  //echo($pshort);
	  $res=mysqli_query($con,$query);
	  if( mysqli_num_rows($res)> 0 ){
			echo "get_value";
			return;
	  }
	$filename=$_FILES['pimage']['name'];
	$tmpname=$_FILES['pimage']['tmp_name'];
	$filesize=$_FILES['pimage']['size'];
	$filetype=$_FILES['pimage']['type'];
	if($filetype!="image/jpg" && $filetype!="image/png" && $filetype!="image/jpeg")
	{
	  echo"Please Upload Images(PNG,JPG & JPEG) Files Only...";
	  return;
	}
	if($filesize>800000)
	{
	  echo"Image can't be Greater than 800KB .";
	  return;
	}
	
	$filename=$pname.$pshort.".jpg";
	mysqli_query($con,"insert into skus(productname,productid,catid,scatid, brandname,quantity,image,creationdate,createdby) values('$pname','$pshort','$catid','$scatid','FRIC BERGEN','0','$filename','$datetime','0')") or die(mysqli_error($con));
	if(mysqli_affected_rows($con)>0)
	{
	  if(move_uploaded_file($tmpname,"../imgproduct/".$filename))
	  {
	    echo"success";
	  }
	  else
	  {
      echo"error";
	  }
	}
	
  }

  else if(isset($_GET['show']))
  {
     $res=mysqli_query($con,"SELECT skus.id,skus.productname,skus.productid,sku_unit.name AS unit ,skus.rate,skus.brandname,skus.mrp,product_cat.name AS catname,parduct_sub_cat.name AS sub_catname,skus.image FROM skus LEFT JOIN product_cat on product_cat.id=skus.catid LEFT JOIN parduct_sub_cat on parduct_sub_cat.id= skus.scatid LEFT JOIN sku_unit s_unit on s_unit.id=skus.cunit LEFT JOIN sku_unit on sku_unit.id=skus.unit");

	 $response=array();
	 while($row=mysqli_fetch_array($res))
	 {
		 $rr=array("id"=>$row["id"],"productname"=>$row["productname"],"productid"=>$row["productid"],"unit"=>$row["unit"],"mrp"=>$row["mrp"],"rate"=>$row["rate"],"brandname"=>$row["brandname"],"image"=>$row["image"]);
		 $response[]=$rr;
     }	 
	 $data=json_encode($response);
	 echo $data;
  }

  else if(isset($_GET['deleteskus']))
  { $id=$_GET['id'];
  	if(!empty($id)){
      $result=mysqli_query($con," DELETE FROM `skus` WHERE id='$id'");
      if($result) {
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		exit;
     }	
  	}
  }

  else if(isset($_GET['edit']))
  {
	  extract($_POST);
	  
	  $query = "select productid from skus where productid = '$pshort' && id='$pid'";
	  //echo($pshort);
	  $res=mysqli_query($con,$query);
	  if( mysqli_num_rows($res)<=0 ){
			$query = "select productid from skus where productid = '$pshort'";
	     //echo($pshort);
	     $res=mysqli_query($con,$query);
	     if( mysqli_num_rows($res)> 0 ){
	 		echo "get_value";
			return;
	    }
	}
	  
	  
	  if(isset($_FILES['pimage']['name']) && $_FILES['pimage']['name']!="" && !isset($_POST['pimage']) )
	  {
		  
	     $filename=$_FILES['pimage']['name'];
	     $tmpname=$_FILES['pimage']['tmp_name'];
	     $filesize=$_FILES['pimage']['size'];
	     $filetype=$_FILES['pimage']['type'];
	     if($filetype!="image/jpg" && $filetype!="image/png" &&   $filetype!="image/jpeg")
	     {
	       echo"Please Upload Images(PNG,JPG & JPEG) Files Only...";
 	       return;
      	 }
	     if($filesize>800000)
	     {
	       echo"Image can't be Greater than 800KB .";
	       return;
	      }
		  
	      $filename=$pname.$pshort.".jpg";
	      mysqli_query($con,"update  skus set productname='$pname',productid='$pshort',catid='$catid',scatid='$scatid',image='$filename' where id='$pid'") or die(mysqli_error($con));
		  
	      if(mysqli_affected_rows($con)>0)
       	  {
	       if(move_uploaded_file($tmpname,"../imgproduct/".$filename))
	        {
	          echo"success";
	        }
	       else
	        {
             echo"Image error";
	        }
	      }
		  else
		  {
			if(move_uploaded_file($tmpname,"../imgproduct/".$filename))
	        {
	          echo"success";
	        }
	       else
	        {
             echo"Image error";
	        }  
		  }  
	   }
	   else
	   {
		   
	      //$filename=$pname.$pshort.".jpg";
		  
	      mysqli_query($con,"update skus set productname='$pname',productid='$pshort',unit='$punit',mrp='$pmrp',rate='$prate'  where id='$pid'") or die(mysqli_error($con));
	      if(mysqli_affected_rows($con)>0)
       	  {
	          echo"success";  
	      }
		  else
		  {
			  echo"No changes affected...";
		  }
	   }
  }


?>