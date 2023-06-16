<?php
require ('top.inc.php');

$items=json_decode($_COOKIE["items"],true);
if(isset($_POST['reset'])){
  unset ($_SESSION['shopping_cart']);
   header ("location:show_products.php");
   exit();
   
}; 

//stored data from session array to database




?>

<div style="padding:0px 100px;">

<h2 style="padding:20px 0px;">Thank you for purchasing.</h2>   

<div class="cart">
<?php
if(isset($_SESSION["shopping_cart"])){
    $total_price = 0;
    $total_prices = 0;
    $total_amount = 0;
    $products='';
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
  if($_SERVER['REQUEST_METHOD'] == 'POST') { 

    $username=($_SESSION["ADMIN_USERNAME"]);
    $order_id=uniqid() ;
    $user_id=($_SESSION["ADMIN_ID"]);
    foreach ($items as $product){
      $p_id=$product["p_id"];
      $res_0 = mysqli_query($con,"SELECT * FROM `product_list` WHERE `p_id`='$p_id'");
      $l=0;
      while ($row_0 = mysqli_fetch_assoc($res_0)) {$l++;
    
  ($total_amount = $row_0["price"]);
   $quantity= $product["quantity"];
   $products=($row_0['product_name']) ;   


   $ql=mysqli_query($con,"INSERT INTO `invoice`(`user_id`,`total_amount`,`product_names`,`quantity`,`order_id`) VALUES ('$user_id','$total_amount','$products','$quantity','$order_id')");

}};
} else{
  echo "<h3>error printing invoice</h3>";
};	
foreach ($items as $product){
  $total_price = 0;
	$p_id=$product["p_id"];
$res = mysqli_query($con,"SELECT * FROM `product_list` WHERE `p_id`='$p_id'");
$a=0;
while ($row = mysqli_fetch_assoc($res)) {$a++;
?>
<tr>
<td ><img src='uploads/<?php echo $row["product_img"]; ?>' width="50" height="40" style="object-fit:contain ;" />
	<?php echo $row['product_name']?>


</td>
<td ><?php echo $row['category']?></td>	
<td ><?php echo $row['desc']?></td>	
	


<td style="text-align:center ;"><?php echo $product["quantity"]; ?></td>


<td><?php echo "$".$row["price"]; ?></td>
<td><?php echo "$".$row["price"]*$product["quantity"]; ?></td>
</tr>
<?php
$total_price += ($row["price"]*$product["quantity"]);
}}
?>
<tr>
  <?php
  
  
  ?>
<td>   <form action="" method="post"><input name="reset" type="submit" value="Buy More Products"class="btn btn-dark"></form> </td>    
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


<?php
    

require('footer.inc.php');
?>
