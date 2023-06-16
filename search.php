<?php

require('top.inc.php');?>

<div class="">
    <table class='table '>
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
					   </thead>
<?php
    $message='No results found';
	$query = $_POST['query']; 
	// gets value sent over search form
	
	$min_length=1;
	// you can set minimum length of the query if you want
	
	if(strlen($query) >= $min_length){ // if query length is more or equal minimum length then
		
		$query = htmlspecialchars($query); 
		// changes characters used in html to their equivalents, for example: < to &gt;
		
		$query = mysqli_real_escape_string($con,$query);
		// makes sure nobody uses SQL injection
		
		$raw_results = mysqli_query($con,"SELECT * FROM product_list
			WHERE (`category` LIKE '%".$query."%') OR (`product_name` LIKE '%".$query."%')") or die(mysqli_error($con));
			
		// * means that it selects all fields, you can also write: `id`, `title`, `text`
		// articles is the name of our table
		
		// '%$query%' is what we're looking for, % means anything, for example if $query is Hello
		// it will match "hello", "Hello man", "gogohello", if you want exact match use `title`='$query'
		// or if you want to match just full word so "gogohello" is out use '% $query %' ...OR ... '$query %' ... OR ... '% $query'
		
		if(mysqli_num_rows($raw_results) > 0){ // if one or more rows are returned do following
			$i=0;
			while($row = mysqli_fetch_array($raw_results)){$i++;
			// $results = mysql_fetch_array($raw_results) puts data from database into array, while it's valid it does the loop
			?>
           
            <?php
            echo "
            <tbody>
                 <form method='post' action='' >
                  <tr>
                  <td width='10%'>"  .$i."</td>
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
				// posts results gotten from database(title and text) you can also show id ($results['id'])
			}
			
		}
		else{ // if there is no matching rows do following
			echo "<h2>$message</h2>";
		}
		
	}
	else{ // if query length is less than minimum
		echo "Minimum length is ".$min_length;
	}

?>
</table>
            </div>
<?php
 
require('footer.inc.php');
?>