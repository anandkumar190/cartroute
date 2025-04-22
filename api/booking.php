<?php 
include("../connect.php");

if(isset($_GET['productcategory']))
{  
    $query = "Select id AS CategoryID, name As CategoryName from product_cat";
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)) {
            $datas[] = $row;

        }
    }

    $new_array = array();

    foreach ($datas as $data) {
        $new_array["data"] ["Category Details"][]  = array(
            "category_id" => $data["CategoryID"],
            "category_name" => $data["CategoryName"],
        );
        
    }

    echo json_encode($new_array, JSON_PRETTY_PRINT); 
}

if(isset($_GET['productdetails']))
{
    
    $query = "SELECT product_cat.id AS ProductCategoryID, product_cat.name AS ProductCategoryName , parduct_sub_cat.name AS ProductSubCategoryName, parduct_sub_cat.id AS ProductSubCategoryID, parduct_sub_cat.pmrp, parduct_sub_cat.punit, parduct_sub_cat.prate, parduct_sub_cat.cunit, parduct_sub_cat.cmrp, parduct_sub_cat.unit_no, parduct_sub_cat.discount, skus.id AS ProductID, skus.productname AS ProductName , skus.productid AS ProductShortName, skus.image AS ProductImage
    FROM skus
    INNER JOIN product_cat ON skus.catid = product_cat.id
    INNER JOIN parduct_sub_cat ON skus.scatid = parduct_sub_cat.id " ;
    $result = mysqli_query($con, $query);

    if(mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)) {
            $datas[] = $row;
            
        }
    }

    $new_array = array();

    foreach ($datas as $data) {
        $new_array["data"] [$data['ProductCategoryName']][][$data['ProductSubCategoryName']] = array(
            "product-details" => array(
                "category_id" => $data["ProductCategoryID"],
                "category_name" => $data["ProductCategoryName"],
                "subCategory_id" => $data["ProductSubCategoryID"],
                "subCategory_name" => $data["ProductSubCategoryName"],
                "product_id" => $data["ProductID"],
                "product_name" => $data["ProductName"],
                "product_short Name" => $data["ProductShortName"],
                "product_image" => $data["ProductImage"]
            )
        );
        
    }

    echo json_encode($new_array, JSON_PRETTY_PRINT); 

}

if(isset($_GET['productbyid']))
{
    extract($_GET);

    $query = "SELECT product_cat.id AS ProductCategoryID, product_cat.name AS ProductCategoryName , parduct_sub_cat.name AS ProductSubCategoryName, parduct_sub_cat.id AS ProductSubCategoryID, parduct_sub_cat.pmrp, parduct_sub_cat.punit, parduct_sub_cat.prate, parduct_sub_cat.cunit, parduct_sub_cat.cmrp, parduct_sub_cat.unit_no, parduct_sub_cat.discount, skus.id AS ProductID, skus.productname AS ProductName , skus.productid AS ProductShortName, skus.image AS ProductImage
    FROM skus
    INNER JOIN product_cat ON skus.catid = product_cat.id
    INNER JOIN parduct_sub_cat ON skus.scatid = parduct_sub_cat.id 
    WHERE parduct_sub_cat.id = '$productbyid' " ;
    $result = mysqli_query($con, $query);
    $new_array = array();

    if(mysqli_num_rows($result) > 0){
    while($row=mysqli_fetch_assoc($result)) {
        $new_array["data"]["product-details"][] = array(
            "category_id" => $row["ProductCategoryID"],
            "category_name" => $row["ProductCategoryName"],
            "subCategory_id" => $row["ProductSubCategoryID"],
            "subCategory_name" => $row["ProductSubCategoryName"],
            "product_id" => $row["ProductID"],
            "product_name" => $row["ProductName"],
            "product_short_name" => $row["ProductShortName"],
            "product_image" => $row["ProductImage"]
        );
    }
    }else{
        http_response_code(400);
    }


    echo json_encode($new_array, JSON_PRETTY_PRINT); 

}

if(isset($_GET['subcategorydetails'])){

    $query = "SELECT product_cat.id AS ProductCategoryID , parduct_sub_cat.id AS ProductSubCategoryID, parduct_sub_cat.name, parduct_sub_cat.pmrp, parduct_sub_cat.punit, parduct_sub_cat.prate, parduct_sub_cat.cunit, parduct_sub_cat.cmrp, parduct_sub_cat.unit_no, parduct_sub_cat.discount
    FROM parduct_sub_cat
    JOIN product_cat ON parduct_sub_cat.cat_id = product_cat.id " ;
    $result = mysqli_query($con, $query);


    if(mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)) {
            $datas[] = $row;
            
        }
    }

    $new_array = array();

    foreach ($datas as $data) {
        $new_array["data"] [$data['ProductCategoryID']][][$data['ProductSubCategoryID']] = array(

            "category-details" => array(
                "subCategory_name" => $data["name"],
                "pmrp" => $data["pmrp"],
                "punit" => $data["punit"],
                "prate" => $data["prate"],
                "cunit" => $data["cunit"],
                "cmrp" => $data["cmrp"],    
                "unit_no" => $data["unit_no"],
                "discount" => $data["discount"]
            )

        );
        
    }

    echo json_encode($new_array, JSON_PRETTY_PRINT); 


}

if(isset($_GET['subcategorybyid'])){

    extract($_GET);

    $query = "SELECT product_cat.id AS ProductCategoryID, product_cat.name AS ProductCategoryName , parduct_sub_cat.id AS ProductSubCategoryID, parduct_sub_cat.name, parduct_sub_cat.pmrp, parduct_sub_cat.punit, parduct_sub_cat.prate, parduct_sub_cat.cunit, parduct_sub_cat.cmrp, parduct_sub_cat.unit_no, parduct_sub_cat.discount
    FROM parduct_sub_cat
    JOIN product_cat ON parduct_sub_cat.cat_id = product_cat.id 
    WHERE product_cat.id = '$subcategorybyid'" ;

    $result = mysqli_query($con, $query);
    $new_array = array();

    if(mysqli_num_rows($result) > 0){
        while($row=mysqli_fetch_assoc($result)) {
            $new_array["data"]["category-details"][]=array(
                    "category_id" => $row["ProductCategoryID"],
                    "category_name" => $row["ProductCategoryName"],
                    "subCategory_id" => $row["ProductSubCategoryID"],
                    "subCategory_name" => $row["name"],
                    "pmrp" => $row["pmrp"],
                    "punit" => $row["punit"],
                    "prate" => $row["prate"],
                    "cunit" => $row["cunit"],
                    "cmrp" => $row["cmrp"],    
                    "unit_no" => $row["unit_no"],
                    "discount" => $row["discount"]
                
            );
        }
    }

    echo json_encode($new_array, JSON_PRETTY_PRINT); 


}


if(isset($_GET['orderproduct'])){
   //$data=$_POST;
    extract($_POST);
    // $str=$_POST["name"];
//     print_r($data);
//      // $data=json_decode($data,true);
 // print_r($data);
//$data = json_decode(file_get_contents('php://input'), true);

 //print_r($data);
 
 
// $data=json_encode($data,true);
//echo $data;
//echo json_encode(['msg' => 'Success!','data'=>$data]);
   //die('testing');



    $msg = 0;

    if(@$outlet_id == " "){
        echo json_encode(['msg' => 'Please Enter Outlet Id']);
        $msg = 1 ;
    }elseif(@$user_id == " "){
        echo json_encode(['msg' => 'Please Enter User Id']);
        $msg = 1 ;
    // }elseif(@$offer_qty == " "){
    //     echo json_encode(['msg' => 'Please Enter Offer Qty']);
    //     $msg = 1 ;
    }elseif(@$total_amount == " "){
        echo json_encode(['msg' => 'Please Enter Total Amout']);
        $msg = 1 ;
    }elseif(@$total_qty == " "){
        echo json_encode(['msg' => 'Please Enter Total Qty']);
        $msg = 1 ;
    }

    if($msg != 1){
        $result = mysqli_query($con, "insert into booking(outlet_id, user_id, offer_qty, total_amount, total_qty) values('$outlet_id', '$userid', '$offer_qty', '$total_amount', '$total_qty') ");

        $last_id = mysqli_insert_id($con);
        
        
    
        if ($last_id !="") {
            
        $category_id=explode(",",$category_id);
        $subcategory_id=explode(",",$subcategory_id);
        $product_id=explode(",",$product_id);
        $product_name=explode(",",$product_name);
        $qty_no=explode(",",$qty_no);
        $new_price=explode(",",$new_price);
        $product_wise_total_price=explode(",",$product_wise_total_price);
       
            
            // print_r($nameValuePairs);
            // die;

            for($i=0;$i<count($product_id);$i++){
                
                //extract($value);
                $result2 = mysqli_query($con, "insert into booking_item(booking_id_fk, category_id, subcategory_id, product_id, product_name, qty_no, new_price,total_price) values('$last_id', '$category_id[$i]', '$subcategory_id[$i]','$product_id[$i]','$product_name[$i]','$qty_no[$i]','$new_price[$i]','$product_wise_total_price[$i]')" );   
            }
            
            echo json_encode(['msg' => 'Success']);
        }
        else{
            echo json_encode(['msg' => 'Something Went Wrong!']);
        }
    }else{
        echo json_encode(['msg' => 'Please Send all Required Field']);
    }
  

}


if(isset($_GET['search'])){
    
    $employee=trim($_GET['employee']);
    $reservation=trim($_GET['reservation']);
    $outlet=trim($_GET['outlet']);
    $distibuter=trim($_GET['distibuter']);
    $dates=explode("-",$reservation);
    $start=strtotime(trim($dates[0]));
    $end=strtotime(trim($dates[1]));
    $start=date("Y-m-d",$start);
    $end=date("Y-m-d",$end);

    $sqlqry='where bk.id > 0 ';
    if(!empty($employee)){
         $sqlqry.="and bk.user_id = '$employee'";  
    }

    if(!empty($end) and !is_null($start)){
        $end=$end." 23:59:00";
        $start=$start." 00:00:00";
        $sqlqry.=" and bk.booking_time >= '$start' and bk.booking_time <= '$end' " ;
     }

 
    if(!empty($outlet)){
        $sqlqry.=" and bk.outlet_id = '$outlet'";  
     } 
    if(!empty($distibuter)){
        $sqlqry.=" and outlet.distributorid = '$distibuter'";  
     }
    $salesmans=array();
    $outlets=array();
    $res=mysqli_query($con,"select * from employees where usertype='1'");
    while($row=mysqli_fetch_array($res)){
        $salesmans[$row['id']]= $row['name'];  
    }
 
    $res1=mysqli_query($con,"select * from outlets");
    while($row1=mysqli_fetch_array($res1)){
        $outlets[$row1['id']]= $row1['name'];   
    }
 
    $res5=mysqli_query($con,"select id,name from employees where usertype='3'");
    while($row5=mysqli_fetch_array($res5)){
        $distibuters[$row5['id']]= $row5['name'];    
    }

   $booking=mysqli_query($con,"SELECT bk.id,bk.outlet_id,bk.user_id,bk.offer_qty,bk.offer_qty,bk.total_amount,bk.total_qty,bk.booking_time,outlet.distributorid FROM booking bk join outlets outlet on bk.outlet_id=outlet.id ".$sqlqry);

        $total=0; 
        $bookinglist=array();
        
        while($row2=mysqli_fetch_array($booking)){ 
            $tt=array();
            $b_id=$row2['id'];
            $booking_items=mysqli_query($con,"select * from booking_item  where booking_id_fk='$b_id'");
            $items=array();
            $row3=0;
            while( $row3=mysqli_fetch_array($booking_items)){
                $items['qty_no'][$row3['product_id']]=$row3['qty_no'];
                $items['new_price'][$row3['product_id']]=$row3['new_price'];
                $items['total_price'][$row3['product_id']]=$row3['total_price'];
            }
            if (!empty($row2) ) {
                $tt['booking_time'] = @$row2['booking_time'];
                $tt['outlet_id']= @$outlets[$row2['outlet_id']];
                $tt['user_id']=@$salesmans[$row2['user_id']];
                $tt['distibuter']=@$distibuters[$row2['distributorid']];
            }else {
                $tt['booking_time'] = '';
                $tt['outlet_id']= '';
                $tt['user_id']='';
                $tt['distibuter']='';
            }

            $cat=mysqli_query($con,"select id,name from product_cat"); 
        
            while($catrow=mysqli_fetch_array($cat)){
                $subcat=mysqli_query($con,"select id,name from parduct_sub_cat where cat_id=".$catrow['id']."  "); 
                while($subcatrow=mysqli_fetch_array($subcat)){   
                    $catTotal=0.00;
                    $tempQty=0;
                    $res=mysqli_query($con,"select id,productid from skus where scatid=".$subcatrow['id']." "); 
                    while($row=mysqli_fetch_array($res)){

                            $tempQty+=$tt[@$subcatrow['id'].$row['id']]=@$items['qty_no'][@$row['id']];
                            $catTotal=@$items['total_price'][@$row['id']]+$catTotal;
                                
                        if(!empty($items['new_price'][$row['id']])){
                                $tt['price'.$subcatrow['id']]=@$items['new_price'][@$row['id']];
                            }   

                    }
                    if(empty($tt['price'.$subcatrow['id']])){
                        $tt['price'.$subcatrow['id']]=0;
                    }
                    $tt['subcattotal'.$subcatrow['id']] =@$tt['price'.$subcatrow['id']]*$tempQty;
                   // $tt['cattotal'.$subcatrow['id']]=$catTotal;
                 }
            } 
            $tt['total']=$row2['total_amount'];
            $total+=$row2['total_amount'];
            array_push($bookinglist,$tt);
        }
        
        $data=json_encode($bookinglist);
	   echo $data;
	   return; 
}


if(isset($_GET['routevistsummary'])){
    
    $employee=trim($_GET['salesman']);
    $area_id=trim($_GET['route_id']);


    $sqlqry='where bk.id > 0 ';
    if(!empty($employee)){
         $sqlqry.="and bk.user_id = '$employee'";  
    }

 
    $date = new DateTime();
    $start =$date->format("Y-m-d 00:00:00");
    $sqlqry.=" and bk.booking_time >= '$start' " ;
    $sqlqry.=" and outlet.routeid = '$area_id' " ;




    $res1=mysqli_query($con,"select  COUNT(id) AS total_count  from outlets where routeid = $area_id ");
    $row1=mysqli_fetch_array($res1);
     $totalOutlet= @$row1[0];  


    $res2=mysqli_query($con,"select  COUNT(id) AS total_count from outlets where routeid = $area_id and lastvisit >= '$start' ");
    $row2=mysqli_fetch_array($res2);
    $totalVistedOutlet = @$row2[0];  


    $res3=mysqli_query($con,"select  COUNT(id) AS total_count from outlets where routeid = $area_id and creationdate >= '$start'");
    $row3=mysqli_fetch_array($res3);
    $totalNewOutlet= @$row3[0]??0;  


    $bookingSum=mysqli_query($con,"SELECT SUM(bk.total_amount) totalSum FROM booking bk join outlets outlet on bk.outlet_id=outlet.id ".$sqlqry);
    $bookingSumArr=mysqli_fetch_array($bookingSum);
    $totalSumAmount= @$bookingSumArr[0]??0;  



    $totalProdectiveOutletQry=mysqli_query($con,"SELECT outlet.id,SUM(bk.total_amount) totalSum FROM booking bk join outlets outlet on bk.outlet_id=outlet.id ".$sqlqry." Group BY outlet.id HAVING totalSum > 0 ");
    $totalProdectiveOutletArr=mysqli_fetch_array($totalProdectiveOutletQry);
    
    $totalProdectiveOutlet=0;
    if(!empty($totalProdectiveOutletArr)){
        $totalProdectiveOutlet= count($totalProdectiveOutletArr);  
    }
   

   $booking=mysqli_query($con,"SELECT bki.subcategory_id ,SUM(bki.qty_no) AS total_qty  FROM booking_item bki join booking bk on bki.booking_id_fk=bk.id  join outlets outlet on bk.outlet_id=outlet.id ".$sqlqry." GROUP BY bki.subcategory_id ");
     
   	$bookinglist=$unitName= $subCategory=array();
        $query=mysqli_query($con,"SELECT psc.id,psc.name as sub_cat_name ,su.name as unit_name FROM parduct_sub_cat psc  join sku_unit su on  psc.punit = su.id");
   	 	 while($row=mysqli_fetch_array($query))
   	     {
            $subCategory[$row["id"]]=$row["sub_cat_name"];
            $unitName[$row["id"]]=$row["unit_name"];
           
        }	

 

        while($row2=mysqli_fetch_array($booking)){ 
            $tt=array();
      
            $tt['subcategory'] = @$subCategory[$row2['subcategory_id']]??0;
            $tt['unit']= @$unitName[$row2['subcategory_id']]??0;
            $tt['total_qty']=@$row2['total_qty']??0;
            $tt['subcategory_id']=$row2['subcategory_id']??0;
            array_push($bookinglist,$tt);
        }
           
      $prodectiveCell=($totalProdectiveOutlet>0 and $totalOutlet >0)? (($totalProdectiveOutlet/$totalOutlet)*100) :0;
        $data=json_encode([
            'bookinglist'=>$bookinglist,
            'total_outlet'=>($totalOutlet-$totalNewOutlet),
            'total_visted_outlet'=>$totalVistedOutlet,
            'total_new_outlet'=>$totalNewOutlet,
            'total_sum_amount'=>$totalSumAmount,
            'total_prodective_outlet'=>$totalProdectiveOutlet,
            'prodective_cell'=>$prodectiveCell."%",
            'no_outlet_after_new_'=>($totalOutlet),
            'outlet_not_visted'=>$totalOutlet-$totalVistedOutlet

          ]);

	   echo $data;
	   return; 
}



if(isset($_GET['outletwisesummary'])){
    
    $employee=trim($_GET['salesman']);
    $area_id=trim($_GET['route_id']);


    $sqlqry='where bk.id > 0 ';
    if(!empty($employee)){
         $sqlqry.="and bk.user_id = '$employee'";  
    }

 
    $date = new DateTime();
    $start =$date->format("Y-m-d 00:00:00");
    $sqlqry.=" and bk.booking_time >= '$start' " ;
    $sqlqry.=" and outlet.routeid = '$area_id' " ;



    $bookingSum=mysqli_query($con,"SELECT SUM(bk.total_amount) totalSum FROM booking bk join outlets outlet on bk.outlet_id=outlet.id ".$sqlqry);
    $bookingSumArr=mysqli_fetch_array($bookingSum);
    $totalSumAmount= @$bookingSumArr[0]??0;  



    $totalProdectiveOutletQry=mysqli_query($con,"SELECT outlet.id,outlet.name,outlet.address,SUM(bk.total_amount) total_sum FROM booking bk join outlets outlet on bk.outlet_id=outlet.id ".$sqlqry." Group BY outlet.id HAVING total_sum > 0 ");
    $bookinglist=[];
        while($row2=mysqli_fetch_array($totalProdectiveOutletQry)){ 
            $tt=array();
      
            $tt['name'] = $row2['name'];
            $tt['address']= $row2['address'];
            $tt['total_sum']=$row2['total_sum']??0;
            array_push($bookinglist,$tt);
        }
        
        $data=json_encode([

            'total_sum_amount'=>$totalSumAmount,
            'bookinglist'=>$bookinglist

          ]);

	   echo $data;
	   return; 
}




if(isset($_GET['notvist'])){
    
    $employee=trim($_GET['employee']);
    $reservation=trim($_GET['reservation']);
    $outlet=trim($_GET['outlet']);
    $distibuter=trim($_GET['distibuter']);
    $dates=explode("-",$reservation);
    $start=strtotime(trim($dates[0]));
    $end=strtotime(trim($dates[1]));
    $start=date("Y-m-d h:i:s ",$start);
    $end=date("Y-m-d h:i:s",$end);
	   
    $sqlqry='where bk.id > 0 ';

    if(!empty($end) and !is_null($start)){
    $sqlqry.=" and bk.booking_time >= '$start' and bk.booking_time <= '$end' " ;  
    }
    
    if(!empty($outlet)){
    $sqlqry.=" and bk.outlet_id = '$outlet'";  
    } 
    if(!empty($distibuter)){
    $sqlqry.=" and outlet.distributorid = '$distibuter'";  
    }

    $salesmans=array();
    $outlets=array();
    $res=mysqli_query($con,"select * from employees where usertype='1'");

    while($row=mysqli_fetch_array($res)){
        $salesmans[$row['id']]= $row['name'];   
    }
 
    $res1=mysqli_query($con,"select * from outlets");
    while($row1=mysqli_fetch_array($res1)){
        $outlets[$row1['id']]= $row1['name'];   
    }
 
    $res5=mysqli_query($con,"select id,name from employees where usertype='3'");
    while($row5=mysqli_fetch_array($res5)){
        $distibuters[$row5['id']]= $row5['name'];  
    }

   $booking=mysqli_query($con,"SELECT * FROM outlets where id not in (SELECT DISTINCT outlet.id FROM booking bk join outlets outlet on bk.outlet_id=outlet.id ".$sqlqry.")");
    $total=0; 
    $bookinglist=array();
    
    while($row2=mysqli_fetch_array($booking)){ 
        $tt=array();
        $tt['name'] = $row2['name'];
        $tt['address'] = $row2['address'];
        $tt['contactperson'] = $row2['contactperson'];
        $tt['contact'] = $row2['contact'];
        $tt['lastvisit'] = $row2['lastvisit'];
        $tt['distributorid']=$distibuters[$row2['distributorid']];             
        array_push($bookinglist,$row2);
    } 
     $data=json_encode($bookinglist);
    echo $data;
    return; 
}


?>
