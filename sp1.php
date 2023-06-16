<?php
require('top.inc.php');
$status="";

if (isset($_POST['product_name']) && $_POST['product_name']!=""){
$product_name = $_POST['product_name'];
$res = mysqli_query($con,"SELECT * FROM `product_list` WHERE `product_name`='$product_name'");
$row = mysqli_fetch_assoc($res);
$product_name = $row['product_name'];
$product_img = $row['product_img'];
$category = $row['category'];
$price = $row['price'];
$desc = $row['desc'];

$cartArray = array(
	$product_name=>array(
	'product_name'=>$product_name,
	'product_img'=>$product_img,
	'category'=>$category,
	'price'=>$price,
	'quantity'=>1,
	'desc'=>$desc)
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
	if(in_array($product_name,$array_keys)) {
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

if (isset($_GET['pageno'])) {
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
<h2 style="padding:50px 50px 20px;">Product List</h2> 
<div><?php echo $status; ?></div>

<div style="padding:20px;">

  

<?php
if(!empty($_SESSION["shopping_cart"])) {
$cart_count = count(array_keys($_SESSION["shopping_cart"]));
?>
<!-- <div class="cart_div mb-4 text-right">
<a href="cart.php">
 <strong >Cart</strong> 
<span ><small class="  bg-danger text-light px-2 py-1 font-weight-bold rounded-circle"><?php echo $cart_count; ?></small></span></a>
</div> -->
<?php
}?>
<div class='card-body--'>
				 <div class='table-stats order-table ov-h'>
					<table class='table '>
					   <thead>
						  <tr>
							 <th class='serial'>#</th>
							 <th width='30%'>PRODUCT IMAGE</th>
							 <th width='30%'>PRODUCT NAME</th>
							 <th width='30%'>CATEGORY</th>
							 <th width='30%'>DESCRIPTION</th>
							 <th width='20%'>PRICE</th>
						  </tr>
					   </thead>
<?php
$res = mysqli_query($con,"SELECT * FROM `product_list`");
$i=0;
while($row = mysqli_fetch_assoc($res_data)){$i++;
		echo "
					   <tbody>
							<form method='post' action='' >
							 <tr>
							 <td width='10%'>" .($pageno - 1) * 10 + $i."</td>
							 <td width='30%'> <div class='image'><img src='uploads/".$row['product_img']."' /></div></td>
							 <td style='display:none;'><input type='hidden' name='product_name' value=".$row['product_name']." /></td>
							 <td width='30%'><div class='name'>".$row['product_name']."</div></td>
							 <td width='30%'> <div class='category'>".$row['category']."</div></td>
							 <td width='30%'> <div class='desc'>".$row['desc']."</div></td>
							 <td width='20%'><div class='price'>$".$row['price']."</div></td>
							 </tr>
							</form>
					   </tbody>
					";
        }
mysqli_close($con);
?>
</table>




<br /><br />
<ul class="pagination" style="justify-content:space-between; padding:0px 20px;">
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

require('footer.inc.php');
?>