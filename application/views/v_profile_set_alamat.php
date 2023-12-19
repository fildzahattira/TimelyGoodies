<?php
  $alamat = $user_data->get_alamat();

  // pakai fungsi htmlspecialchars agar string aman dipakai / memunculkan bug
  $alamat = htmlspecialchars($alamat);

  $username = $user_data->get_username();
  $saldo = $user_data->get_saldo();
  $alamat = $user_data->get_alamat();
?>

		<!-- Start Hero Section -->
			<div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>Update Alamat</h1>
							</div>
						</div>
						<div class="col-lg-7">
							
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->

		

		<div class="untree_co-section product-section before-footer-section">
		    <div class="container">
		      	<div class="row">
		      	    	<form action=""<?php echo base_url('UserController/set_alamat'); ?>"" class="row g-3" method="post">
								<div class="col-auto">
								    <h3>Biodata</h3>
<textarea cols="50" rows="5"><?php echo $alamat; ?></textarea>
<br/>
									<button class="btn btn-primary">
										<span>Update</span>
									</button>
								</div>
								<!--<div class="col-auto">-->
								<!--	<input type="email" class="form-control" placeholder="Enter your email">-->
								<!--</div>-->
								<!--<div class="col-auto">-->
								<!--	<button class="btn btn-primary">-->
								<!--		<span class="fa fa-paper-plane"></span>-->
								<!--	</button>-->
								<!--</div>-->
							</form>

		      		 <!--Start Column 1 -->
					<!--<div class="col-12 col-md-4 col-lg-3 mb-5">-->
					<!--	<a class="product-item" href="#">-->
					<!--		<img src="images/product-3.png" class="img-fluid product-thumbnail">-->
					<!--		<h3 class="product-title">Nordic Chair</h3>-->
					<!--		<strong class="product-price">$50.00</strong>-->

					<!--		<span class="icon-cross">-->
					<!--			<img src="images/cross.svg" class="img-fluid">-->
					<!--		</span>-->
					<!--	</a>-->
					</div> 
					 <!--End Column 1 -->
						
					 <!--Start Column 2 -->
					<!--<div class="col-12 col-md-4 col-lg-3 mb-5">-->
					<!--	<a class="product-item" href="#">-->
					<!--		<img src="images/product-1.png" class="img-fluid product-thumbnail">-->
					<!--		<h3 class="product-title">Nordic Chair</h3>-->
					<!--		<strong class="product-price">$50.00</strong>-->

					<!--		<span class="icon-cross">-->
					<!--			<img src="images/cross.svg" class="img-fluid">-->
					<!--		</span>-->
					<!--	</a>-->
					<!--</div> -->
					 <!--End Column 2 -->

					 <!--Start Column 3 -->
					<!--<div class="col-12 col-md-4 col-lg-3 mb-5">-->
					<!--	<a class="product-item" href="#">-->
					<!--		<img src="images/product-2.png" class="img-fluid product-thumbnail">-->
					<!--		<h3 class="product-title">Kruzo Aero Chair</h3>-->
					<!--		<strong class="product-price">$78.00</strong>-->

					<!--		<span class="icon-cross">-->
					<!--			<img src="images/cross.svg" class="img-fluid">-->
					<!--		</span>-->
					<!--	</a>-->
					<!--</div>-->
					 <!--End Column 3 -->

					 <!--Start Column 4 -->
					<!--<div class="col-12 col-md-4 col-lg-3 mb-5">-->
					<!--	<a class="product-item" href="#">-->
					<!--		<img src="images/product-3.png" class="img-fluid product-thumbnail">-->
					<!--		<h3 class="product-title">Ergonomic Chair</h3>-->
					<!--		<strong class="product-price">$43.00</strong>-->

					<!--		<span class="icon-cross">-->
					<!--			<img src="images/cross.svg" class="img-fluid">-->
					<!--		</span>-->
					<!--	</a>-->
					<!--</div>-->
					 <!--End Column 4 -->


					 <!--Start Column 1 -->
					<!--<div class="col-12 col-md-4 col-lg-3 mb-5">-->
					<!--	<a class="product-item" href="#">-->
					<!--		<img src="images/product-3.png" class="img-fluid product-thumbnail">-->
					<!--		<h3 class="product-title">Nordic Chair</h3>-->
					<!--		<strong class="product-price">$50.00</strong>-->

					<!--		<span class="icon-cross">-->
					<!--			<img src="images/cross.svg" class="img-fluid">-->
					<!--		</span>-->
					<!--	</a>-->
					<!--</div> -->
					 <!--End Column 1 -->
						
					 <!--Start Column 2 -->
					<!--<div class="col-12 col-md-4 col-lg-3 mb-5">-->
					<!--	<a class="product-item" href="#">-->
					<!--		<img src="images/product-1.png" class="img-fluid product-thumbnail">-->
					<!--		<h3 class="product-title">Nordic Chair</h3>-->
					<!--		<strong class="product-price">$50.00</strong>-->

					<!--		<span class="icon-cross">-->
					<!--			<img src="images/cross.svg" class="img-fluid">-->
					<!--		</span>-->
					<!--	</a>-->
					<!--</div> -->
					 <!--End Column 2 -->

					 <!--Start Column 3 -->
					<!--<div class="col-12 col-md-4 col-lg-3 mb-5">-->
					<!--	<a class="product-item" href="#">-->
					<!--		<img src="images/product-2.png" class="img-fluid product-thumbnail">-->
					<!--		<h3 class="product-title">Kruzo Aero Chair</h3>-->
					<!--		<strong class="product-price">$78.00</strong>-->

					<!--		<span class="icon-cross">-->
					<!--			<img src="images/cross.svg" class="img-fluid">-->
					<!--		</span>-->
					<!--	</a>-->
					<!--</div>-->
					 <!--End Column 3 -->

					 <!--Start Column 4 -->
					<!--<div class="col-12 col-md-4 col-lg-3 mb-5">-->
					<!--	<a class="product-item" href="#">-->
					<!--		<img src="images/product-3.png" class="img-fluid product-thumbnail">-->
					<!--		<h3 class="product-title">Ergonomic Chair</h3>-->
					<!--		<strong class="product-price">$43.00</strong>-->

					<!--		<span class="icon-cross">-->
					<!--			<img src="images/cross.svg" class="img-fluid">-->
					<!--		</span>-->
					<!--	</a>-->
					<!--</div>-->
					 <!--End Column 4 -->

		      	</div>
		    </div>
		</div>