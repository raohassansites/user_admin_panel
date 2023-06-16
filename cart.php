<?php
require('top.inc.php');
$status="";



if (empty($_SESSION["shopping_cart"]) ) {

} else {
	

$items_data=json_encode($_SESSION["shopping_cart"],true);
setcookie("items",$items_data,time() + 60*100000, '/');
$items=json_decode($_COOKIE["items"],true);
// echo var_dump($items);
// if (isset($_POST['action']) && $_POST['action']=="remove"){
// if(!empty($_SESSION["shopping_cart"])) {
// 	foreach($_SESSION["shopping_cart"] as $key => $value) {
// 		if($_POST["remove"] == $key){
			
// 		unset($_SESSION["shopping_cart"][$key]);
// 		$status = "<div class=' mx-3 alert alert-danger alert-dismissible fade show' role='alert'>
	
// 		<div class='box' style='color:red;'>
// 				<strong>Product</strong> is removed from your cart!</div>
// 		  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
// 			<span aria-hidden='true'>&times;</span>
// 		  </button>
// 		</div>";
// 		}
// 		if(empty($_SESSION["shopping_cart"]))
// 		unset($_SESSION["shopping_cart"]);
// 			}		
// 		}
// }
if(isset($_GET["action"]))
{
	if($_GET["action"] == "delete")
	{
		foreach($_SESSION["shopping_cart"] as $key => $values)
		{
			if($values["p_id"] == $_GET["id"])
			{
				unset($_SESSION["shopping_cart"][$key]);
				$status = "<div class=' mx-3 alert alert-danger alert-dismissible fade show' role='alert'>
	
		<div class='box' style='color:red;'>
				<strong>Product</strong> is removed from your cart!</div>
		  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
		  </button>
		</div>";
			}
				{	if(empty($_SESSION["shopping_cart"]))
		unset($_SESSION["shopping_cart"]);
			}		

		}
	}
}
if (isset($_POST['action']) && $_POST['action']=="change"){
  foreach($_SESSION["shopping_cart"] as &$value){
	 echo var_dump($value);
    if($value['p_id'] === $_POST["p_id"]){
        $value['quantity'] = $_POST["quantity"];
        break; // Stop the loop after we've found the product
    }
}
  	
}}
?>

<div style="padding:0px 100px;">

<h2 style="padding:20px 0px;">My Cart</h2>   
<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>


<div class="cart">
<?php

if(isset($_SESSION["shopping_cart"])){
  
	# code...

?>	
<table class="table">
<tbody>
<tr>
<td>ITEM NAME</td>
<td>CATEGORY</td>
<td>DESCRIPTION</td>

<td>QUANTITY</td>
<td>UNIT PRICE</td>
<td>ITEMS TOTAL</td>
</tr>	
<?php		
foreach ($items as $product){
	$total_price = 0;
	$p_id=$product["p_id"];
$res = mysqli_query($con,"SELECT * FROM `product_list` WHERE `p_id`='$p_id'");
$a=0;
while ($row = mysqli_fetch_assoc($res)) {$a++;
	// echo var_dump($row);
?>
<tr>
	<td ><img src='uploads/<?php echo $row["product_img"]; ?>' width="50" height="40" style="object-fit:contain ;" />
	<?php echo $row['product_name']?>
<a style="
    padding-left: 18px;
" href="cart.php?action=delete&id=<?php echo $product["p_id"]; ?>"><span class="text-danger">Remove</span></a></td>
<td ><?php echo $row['category']?></td>	
<td ><?php echo $row['desc']?></td>	
	

<td>
<form method='post' action=''>
<input type='hidden' name='p_id' value="<?php echo $product["p_id"]; ?>" />
<input type='hidden' name='action' value="change" />
<select name='quantity' class='quantity' onchange="this.form.submit()">
<option <?php if($product["quantity"]==1) echo "selected";?> value="1">1</option>
<option <?php if($product["quantity"]==2) echo "selected";?> value="2">2</option>
<option <?php if($product["quantity"]==3) echo "selected";?> value="3">3</option>
<option <?php if($product["quantity"]==4) echo "selected";?> value="4">4</option>
<option <?php if($product["quantity"]==5) echo "selected";?> value="5">5</option>
<option <?php if($product["quantity"]==6) echo "selected";?> value="6">6</option>
<option <?php if($product["quantity"]==7) echo "selected";?> value="7">7</option>
<option <?php if($product["quantity"]==8) echo "selected";?> value="8">8</option>
<option <?php if($product["quantity"]==9) echo "selected";?> value="9">9</option>
<option <?php if($product["quantity"]==10) echo "selected";?> value="10">10</option>
</select>
</form>
</td>
<td><?php echo "$".$row['price']; ?></td>
<td><?php echo "$".$row["price"]*$product["quantity"]; ?></td>
</tr>
<?php
$total_price += ($row["price"]*$product["quantity"]);
}}
?>
<tr >
<td colspan="7"  align="left">
<strong>TOTAL: <?php echo "$".$total_price; ?></strong>
</td>
</tr>
<tr>
<td colspan="7" align="right">
<a class="btn btn-dark" href="show_products.php">Buy More Products</a></td></tr>
<td colspan="7" align="right">
	<?php 

	if (isset($_SESSION['ADMIN_LOGIN']) && $_SESSION['ADMIN_LOGIN']!='' ) {
		?><form method='post' action='checkout.php'>
		<button type='checkout' value="checkout" class=' btn btn-dark'>Checkout</button>
		</form>
		</td>
	</tbody>
	</table>
		<?php
	} else {
		echo '<a href="login.php">Login</a> to complete your purchase';
	}
	
	
	?>
	

		
  <?php

}else{
	echo "<h4>Your cart is empty!</h4>";
	}
?>
</div>

<div style="clear:both;"></div>




<br /><br />
</div>
<?php
require('footer.inc.php');
?>