
<?php
require('top.inc.php');
$status="";

if (isset($_POST['p_id']) && $_POST['p_id']!=""){
$p_id = $_POST['p_id'];
$res = mysqli_query($con,"SELECT * FROM `product_list` WHERE `p_id`='$p_id'");
$row = mysqli_fetch_assoc($res);
$p_id=$row['p_id'];
$product_name = $row['product_name'];
$product_img = $row['product_img'];
$category = $row['category'];
$price = $row['price'];
$desc = $row['desc'];

$cartArray = array(
	$p_id=>array(
	'p_id'=>$p_id,	
	// 'product_name'=>$product_name,
	// 'product_img'=>$product_img,
	// 'category'=>$category,
	// 'price'=>$price,
	'quantity'=>1,
	// 'desc'=>$desc
	)
);
if(empty($_SESSION["shopping_cart"])) {
	$_SESSION["shopping_cart"] = $cartArray;
	$status = "<div class=' mx-3 alert alert-info alert-dismissible fade show' role='alert'>
	
	<div class='box' style='color:blue;'>
			<strong>First Product</strong> is  added to your cart.</div>
	  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
	  </button>
	</div>";
}else{
	$array_keys = array_keys($_SESSION["shopping_cart"]);
	if(in_array($p_id,$array_keys)) {
		$status = "<div class=' mx-3 alert alert-danger alert-dismissible fade show' role='alert'>
	
		<div class='box' style='color:red;'>
				<strong>Product</strong> is already added to your cart!</div>
		  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
		  </button>
		</div>";	
	} else {
	$_SESSION["shopping_cart"] = array_merge($_SESSION["shopping_cart"],$cartArray);
	$status = "<div class=' mx-3 alert alert-success alert-dismissible fade show' role='alert'>
	
	<div class='box' style='color:green;'>
			<strong>Product</strong> is  added to your cart.</div>
	  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
		<span aria-hidden='true'>&times;</span>
	  </button>
	</div>";
	}

	}
}
?>
 <?php

if (isset($_GET['pageno']))  {
	$pageno = $_GET['pageno'];
} else {
	$pageno = 1;
}
$no_of_records_per_page = 10;
$offset = ($pageno-1) * $no_of_records_per_page;



$total_pages_sql = "SELECT COUNT(*) FROM product_list";
$result = mysqli_query($con,$total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql = "SELECT * FROM product_list LIMIT $offset, $no_of_records_per_page";
$res_data = mysqli_query($con,$sql);

?>
<html>
<head>
<title></title>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<?php
 if (isset($_SESSION['ADMIN_ROLE']) && ($_SESSION['ADMIN_ROLE']==0)) {
	echo'<h2 style="padding: 50px 50px 20px;
    margin: 20px 0px 20px 20px;
	color: #868e96;
    background-color: white;">Welcome</h2>';
 }else{
 

?>	 
<h2 style="padding:50px 50px 20px;">Product List</h2> 
<div><?php echo $status; ?></div>

<div style="padding:20px;">

  

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<div class="cart_div mb-4 text-right">
<a href="cart.php">
 <strong >Cart</strong> 
<span ><small class="  bg-danger text-light px-2 py-1 font-weight-bold rounded-circle"><?php echo $cart_count; ?></small></span></a>
</div>
<?php
}?>
<div class='card-body--'>

  <p>From below dropdown menus you can apply product_list</p>
  <form action="" method="post">
    <div class="row mb-4 ">
    <div class="col-sm-3">
        <div class="form-group">
            <select class="form-control" name="category">
                <option value="none">Select Category</option>
                <option value="cryptocurrency">Cryptocurrency</option>
                <option value="logo">Logo</option>
				<option value="electronics">Electronics</option>
            </select>
        </div>
    </div>
	<button type="submit"  class="btn btn-dark">Apply</button>
	<div>
	</form>

	<form action="" method="POST">
	<input type="text" minlength="1" name="query" required/>
	<input type="submit" value="Search" />
</form>
	</div>
	
</div>

<div class="row"><table class='table '>
					   <thead>
						  <tr>
							 <th class='serial'>#</th>
							 <th width='30%'>PRODUCT IMAGE</th>
							 <th width='30%'>PRODUCT NAME</th>
							 <th width='30%'>CATEGORY</th>
							 <th width='30%'>DESCRIPTION</th>
							 <th width='20%'>PRICE</th>
							 <th width='40%'></th>
						  </tr>
					   </thead><?php
					
error_reporting( error_reporting() & ~E_NOTICE );
@$category = $_POST['category'];
@$query = $_POST['query']; 
$min_length = 1;
if (isset($_POST['category']) || strlen($query) >= $min_length ) {
	$query = htmlspecialchars($query); 
		// changes characters used in html to their equivalents, for example: < to &gt;
		
		$query = mysqli_real_escape_string($con,$query);
    $qry = "SELECT * FROM product_list  WHERE category ='$category'"; 
		$ress = mysqli_query($con,"SELECT * FROM product_list
		WHERE (`category` LIKE '%".$query."%') OR (`product_name` LIKE '%".$query."%')");
		$num = mysqli_num_rows($ress);
		$i=0;
		  if($num > 0) while($row = mysqli_fetch_assoc($ress)){$i++; ?>
          
                        <?php
                       
                        echo "
                        <tbody>
                             <form method='post' action='' >
                              <tr>
							  <td width='10%'>" .$row['p_id']."</td>
                              <td width='30%'> <div class='image'><img width='50' height='40' style='object-fit:contain ;' src='uploads/".$row['product_img']."' /></div></td>
                              <td style='display:none;'><input type='hidden' name='product_name' value=".$row['product_name']." /></td>
                              <td width='30%'><div class='name'>".$row['product_name']."</div></td>
                              <td width='30%'> <div class='category'>".$row['category']."</div></td>
                              <td width='30%'> <div class='desc'>".$row['desc']."</div></td>
                              <td width='20%'><div class='price'>$".$row['price']."</div></td>
                              <td width='40%'><button type='submit' class='buy btn btn-success'>Add To Cart</button></td>
                              </tr>
                             </form>
                        </tbody>
                     ";} else{
						echo "<div class=' mx-3 alert alert-danger alert-dismissible fade show' role='alert'>
	
						<div class='box' style='color:red;'>
								<strong>No Product</strong> is filtered.</div>
						  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
							<span aria-hidden='true'>&times;</span>
						  </button>
						</div>";
					 }
					}
                        


if (isset($_POST['category'])=='' && isset($_POST['query'])=='' ) {
    
$res = mysqli_query($con,"SELECT * FROM `product_list`");
$i=0;
while($row = mysqli_fetch_assoc($res_data)){$i++;
		echo "
					   <tbody>
							<form method='post' action='' >
							 <tr>
							 <td width='10%'>" .($pageno - 1) * 10 + $i."</td>
							 <td width='30%'> <div class='image'><img width='50' height='40' style='object-fit:contain ;' src='uploads/".$row['product_img']."' /></div></td>
							 <td style='display:none;'><input type='hidden' name='p_id' value=".$row['p_id']." /></td>
							 <td width='30%'><div class='name'>".$row['product_name']."</div></td>
							 <td width='30%'> <div class='category'>".$row['category']."</div></td>
							 <td width='30%'> <div class='desc'>".$row['desc']."</div></td>
							 <td width='20%'><div class='price'>$".$row['price']."</div></td>
							 
							 <td width='40%'><button type='submit' class='buy btn btn-success'>Add To Cart</button></td>
							 </tr>
							</form>
					   </tbody>
					";
}
}

mysqli_close($con);

?>

</table>



<ul class="pagination" style="width:100%; justify-content:space-between; padding:0px 20px;">
                    <li><a href="?pageno=1">First</a></li>
                    <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                     <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
                    </li>
                    <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
                     <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
                    </li>
                    <li><a href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
                </ul>
</div>


				</div>

<?php
   }
require('footer.inc.php');
?>