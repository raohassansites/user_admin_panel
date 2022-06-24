<?php
require('top.inc.php');
?>

<div class="content pb-0">
	<div class="orders">
	   <div class="row">
		  <div class="col-xl-12">
			 <div class="card p-3">
				<div class="card-body">
				  <h2 class="box-title">WELCOME <?php echo $_SESSION['ADMIN_USERNAME']?></h2>
				  <h4 class="box-title">DASHBOARD </h4>
				</div>
			</div>
		  </div>
	   </div>
	</div>
</div>
<?php				
require('footer.inc.php');
?>