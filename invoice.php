<?php
require ('top.inc.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel='stylesheet' href='css/style.css' type='text/css' media='all' />
</head>
<body>
<div class="card m-4">
    <h2 class="text-center pt-4 pb-4 font-weight-bold">Invoices</h2>
      <div class="d-flex m-4 flex-wrap ">
        <?php
         
           

          $res = mysqli_query ($con,"SELECT *,GROUP_CONCAT(product_names),GROUP_CONCAT(total_amount),GROUP_CONCAT(quantity),SUM(total_amount) AS total_amounts   FROM invoice JOIN admin_users ON  admin_users.id=invoice.user_id GROUP BY order_id,user_id  ");
        
          $i=0;
          
            while($row = mysqli_fetch_assoc($res)){$i++;
                echo"<div class='invoice  card d-flex flex-column p-4 m-4'>
                <div class='d-flex justify-content-between '><p class='font-weight-bold text-dark pr-2 mr-2 '>Order ID: <span class='text-secondary' >".$row['order_id']."</span></p>
                <p class='font-weight-bold text-dark'>Customer Name: <span class='text-secondary'>".$row['username']."</span></p></div> 
                     <div class='d-flex justify-content-between '>
                     <p class='font-weight-bold pr-2 mr-2 text-dark  d-flex flex-column text-center'>Product Name  <span class='text-secondary'>".$row['GROUP_CONCAT(product_names)']."</span></p>
                     <p class='font-weight-bold d-flex pr-2 mr-2 text-dark  flex-column text-center'>Quantity <span class='text-secondary'>".$row['GROUP_CONCAT(quantity)']."</span></p>
                     <p class='font-weight-bold d-flex flex-column text-dark text-center'>Price <span class='text-secondary'>".$row['GROUP_CONCAT(total_amount)']."</span></p>
                     </div>
                     
                     <p class='font-weight-bold text-dark text-center'>Total Amount: <span class='text-secondary'>".'$'.$row['total_amounts']."</span></p>
                </div>";
                
                
        ;} ;
         
        
        // $query="select ord.*,ino.* from order_id ord, invoice ino where ord.orderno=ino.order_id";
        // $result=mysqli_query($con,$query);
        // while($row=mysqli_fetch_assoc($result)){
        //       echo"<div class='invoice  card d-flex flex-column p-4 m-4'>
        //       <div class='d-flex justify-content-between '><p class='font-weight-bold text-dark pr-2 mr-2 '>Order ID: <span class='text-secondary' >".$row['orderno']."</span></p>
        //       <p class='font-weight-bold text-dark'>Customer Name: <span class='text-secondary'>".$row['username']."</span></p></div>
                   
        //            <div class='d-flex justify-content-between '>
        //            <p class='font-weight-bold pr-2 mr-2 text-dark  d-flex flex-column text-center'>Product Name  <span class='text-secondary'>".$row['product_names']."</span></p>
        //            <p class='font-weight-bold d-flex pr-2 mr-2 text-dark  flex-column text-center'>Quantity <span class='text-secondary'>".$row['quantity']."</span></p>
        //            <p class='font-weight-bold d-flex flex-column text-dark text-center'>Price <span class='text-secondary'>".$row['total_amount']."</span></p>
        //            </div>
                   
        //            <p class='font-weight-bold text-dark text-center'>Total Amount: <span class='text-secondary'>".$row['quantity']*$row['total_amount']."</span></p>
        //       </div>";


        // }
        ?>
      </div>

</div>

</body>
</html>

<?php
require('footer.inc.php');
?>
