<?php
require('top.inc.php');
$status="";
if (isset($_POST['action']) && $_POST['action']=="remove"){
if(!empty($_SESSION["shopping_cart"])) {
	foreach($_SESSION["shopping_cart"] as $key => $value) {
		if($_POST["product_name"] == $key){
		unset($_SESSION["shopping_cart"][$key]);
		$status = "<div class=' mx-3 alert alert-danger alert-dismissible fade show' role='alert'>
	
		<div class='box' style='color:red;'>
				<strong>Product</strong> is removed from your cart!</div>
		  <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
			<span aria-hidden='true'>&times;</span>
		  </button>
		</div>";
		}
		if(empty($_SESSION["shopping_cart"]))
		unset($_SESSION["shopping_cart"]);
			}		
		}
}
if (isset($_POST['action']) && $_POST['action']=="change"){
  foreach($_SESSION["shopping_cart"] as &$value){
    if($value['product_name'] === $_POST["product_name"]){
        $value['quantity'] = $_POST["quantity"];
        break; // Stop the loop after we've found the product
    }
}
  	
}
?>

<div style="padding:0px 100px;">

<h2 style="padding:20px 0px;">My Cart</h2>   
<div class="message_box" style="margin:10px 0px;">
<?php echo $status; ?>
</div>
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
}
?>

<div class="cart">
<?php
if(isset($_SESSION["shopping_cart"])){
    $total_price = 0;
?>	
<table class="table">
<tbody>
<tr>
<td>DESCRIPTION</td>
<td>ITEM NAME</td>
<td>QUANTITY</td>
<td>UNIT PRICE</td>
<td>ITEMS TOTAL</td>
</tr>	
<?php		
foreach ($_SESSION["shopping_cart"] as $product){
?>
<tr>

<td ><?php echo $product['desc']?></td>	
<td ><?php echo $product['product_name']?>
<form method='post' action=''>
<input type='hidden' name='product_name' value="<?php echo $product["product_name"]; ?>" />
<input type='hidden' name='action' value="remove" />
<button type='submit' class='remove btn btn-danger'>Remove</button>
</form>

</td>	

<td>
<form method='post' action=''>
<input type='hidden' name='product_name' value="<?php echo $product["product_name"]; ?>" />
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
<td><?php echo "$".$product["price"]; ?></td>
<td><?php echo "$".$product["price"]*$product["quantity"]; ?></td>
</tr>
<?php
$total_price += ($product["price"]*$product["quantity"]);
}
?>
<tr>
<td colspan="5" align="right">
<strong>TOTAL: <?php echo "$".$total_price; ?></strong>
</td>
</tr>
</tbody>
</table>		
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