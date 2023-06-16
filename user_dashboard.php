
<?php
require('top.inc.php');
$product_name='';
$product_img='';
$category='';
$desc='';
$price='';
$msg='';
if(isset($_GET['id']) && $_GET['id']!=''){
	$image_required='';
	$id=get_safe_value($con,$_GET['id']);
	$res=mysqli_query($con,"select * from product_list where id='$id' ");
	$check=mysqli_num_rows($res);
	if($check>0){
		$row=mysqli_fetch_assoc($res);
		$product_name=$row['product_name'];
		$product_img=$row['product_img'];
		$category=$row['category'];
		$desc=$row['desc'];
		$price=$row['price'];
	}else{
		header('location:show_product.php');
		die();
	}
}
if(isset($_POST['submit'])){
	$product_img = $_FILES["uploadfile"]["name"];
    $tempname = $_FILES["uploadfile"]["tmp_name"];
    $folder = "./uploads/" . $product_img;
 
 
    // Get all the submitted data from the form
    $sql = "INSERT INTO product_list (product_img) VALUES ('$product_img')";


	move_uploaded_file($tempname, $folder);

        
    

	$product_name=get_safe_value($con,$_POST['product_name']);
	$category=get_safe_value($con,$_POST['category']);
	$desc=get_safe_value($con,$_POST['desc']);
	$price=get_safe_value($con,$_POST['price']);
	
	$res=mysqli_query($con,"select * from product_list where product_name='$product_name'");
	$check=mysqli_num_rows($res);
	if($check>0){
		if(isset($_GET['id']) && $_GET['id']!=''){
			$getData=mysqli_fetch_assoc($res);
			$ress=mysqli_query($con, $sql);
			if($id==$getData['id']){
			  
			}else{
				$msg="Product already exist";
			}
		}else{
			$msg="Product already exist";
		}
	}
	
	if($msg==''){
		if(isset($_GET['product_name']) && $_GET['product_name']!=''){
			$update_sql="update product_list set product_name='$product_name', product_img='$product_img' , category='$category', desc='$desc', price='$price' where id='$id' ";
			mysqli_query($con,$update_sql);
		}else{
			mysqli_query($con,"insert into product_list(`product_name`, `product_img` , `category` , `desc`, `price`) values ('$product_name','$product_img','$category','$desc','$price')");
		}
		header('location:user_dashboard.php');
		die();
	}
	
}

?>

<div class="content pb-0">
            <div class="animated fadeIn">
               <div class="row">
                  <div class="col-lg-12">
                     <div class="card">
                        <div class="card-header"><strong>PRODUCT ADD</strong><small> </small></div>
                        <form method="post" enctype="multipart/form-data">
							<div class="card-body card-block">
							   
								
								<div class="form-group">
									<label for="categories" class=" form-control-label">PRODUCT NAME</label>
									<input type="text" name="product_name" placeholder="Enter product name" class="form-control" required value="<?php echo $product_name?>">
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">CATEGORY</label>
									<input type="text" name="category" placeholder="Enter category " class="form-control" required value="<?php echo $category?>">
								</div>
								<div class="form-group">
									<label for="categories" class=" form-control-label">Description</label>
									<input type="text"   step="any" name="desc" placeholder="Enter quantity" class="form-control" required value="<?php echo $desc?>">
								</div>
                                
								<div class="form-group">
									<label for="categories" class=" form-control-label">PRICE</label>
									<input type="number" min="1"  name="price" placeholder="Enter price" class="form-control" required value="<?php echo $price?>">
								</div>
								
								<input class="form-control" type="file" name="uploadfile" value="" />
															   <button id="payment-button" name="submit" type="submit" class="btn btn-lg btn-info btn-block">
							   <span id="payment-button-amount">ADD</span>
							   </button>
							   <div class="field_error"><?php echo $msg?></div>
							</div>
						</form>
						
                     </div>
                  </div>
               </div>
            </div>
         </div>
		 
         <?php
require('footer.inc.php');
?>		 
