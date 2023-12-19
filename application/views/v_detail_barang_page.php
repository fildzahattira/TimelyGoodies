

		<!-- Start Hero Section -->
			<div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1><?php echo "<label> {$data_page['nama_general_barang']}</label><br><br>"; ?>
</b> </h1>
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
				<!--<form class="card card-sm">-->
				<!--	<div class="card-body row no-gutters align-items-center">-->
				<!--		<div class="col-auto">-->
				<!--			<i class="fas fa-search h4 text-body"></i>-->
				<!--		</div>-->
						<!--end of col-->
				<!--		<div class="col">-->
				<!--			<input class="form-control form-control-lg form-control-borderless" type="search" placeholder="Search item, example : wortel">-->
				<!--		</div>-->
						<!--end of col-->
				<!--		<div class="col-auto">-->
				<!--			<button class="btn btn-lg btn-success" type="submit">Search</button>-->
				<!--		</div>-->
						<!--end of col-->
				<!--	</div>-->
				<!--</form>-->
				<br/>
				<br/>
		      	<div class="row">
		      	    
		      	    <!-- Start Column 1 -->
		      	    <?php foreach ($list_barang as $type_idx => $barang) : ?>
    <div class="col-12 col-md-4 col-lg-3 mb-5">
        <a class="product-item" href="<?= base_url('BarangController/barang/?id=1') ?>">
           <?php foreach ($barang["image_links"] as $images) : ?>
    <img src="<?php echo $images; ?>" class="img-fluid product-thumbnail">
<?php endforeach; ?>
            <h3 class="product-title"><?= $barang["nama_barang"] ?></h3>
            <strong class="product-price"><?= $barang["harga_barang"] ?></strong>
            <span class="icon-cross">
								<img src="<?php echo base_url() ?>assets/images/cart.svg" class="img-fluid">
							</span>
        </a>
    </div>
<?php endforeach; ?>

    					<!-- End Column 1 -->
    					
		      	    
		      	    
					

		      	</div>
		    </div>
		</div>


		<!-- Start Footer Section -->
		<footer class="footer-section">
			<div class="container relative">

				<div class="sofa-img">
					<!-- <img src="images/sofa.png" alt="Image" class="img-fluid"> -->
				</div>

				<div class="row">
					<div class="col-lg-8">
						<div class="subscription-form">
							<!-- <h3 class="d-flex align-items-center"><span class="me-1"><img src="images/envelope-outline.svg" alt="Image" class="img-fluid"></span><span>Subscribe to Newsletter</span></h3> -->

							<!-- <form action="#" class="row g-3">
								<div class="col-auto">
									<input type="text" class="form-control" placeholder="Enter your name">
								</div>
								<div class="col-auto">
									<input type="email" class="form-control" placeholder="Enter your email">
								</div>
								<div class="col-auto">
									<button class="btn btn-primary">
										<span class="fa fa-paper-plane"></span>
									</button>
								</div>
							</form> -->

						</div>
					</div>
				</div>

				<div class="row g-5 mb-5">
					<div class="col-lg-4">
						<div class="mb-4 footer-logo-wrap"><a href="#" class="footer-logo">TimelyGoodies<span>.</span></a></div>
						<p class="mb-4">Donec facilisis quam ut purus rutrum lobortis. Donec vitae odio quis nisl dapibus malesuada. Nullam ac aliquet velit. Aliquam vulputate velit imperdiet dolor tempor tristique. Pellentesque habitant</p>

						<ul class="list-unstyled custom-social">
							<!-- <li><a href="#"><span class="fa fa-brands fa-facebook-f"></span></a></li>
							<li><a href="#"><span class="fa fa-brands fa-twitter"></span></a></li>
							<li><a href="#"><span class="fa fa-brands fa-instagram"></span></a></li>
							<li><a href="#"><span class="fa fa-brands fa-linkedin"></span></a></li> -->
						</ul>
					</div>

					<div class="col-lg-8">
						<div class="row links-wrap">
							<!-- <div class="col-6 col-sm-6 col-md-3">
								<ul class="list-unstyled">
									<li><a href="#">About us</a></li>
									<li><a href="#">Services</a></li>
									<li><a href="#">Blog</a></li>
									<li><a href="#">Contact us</a></li>
								</ul>
							</div>

							<div class="col-6 col-sm-6 col-md-3">
								<ul class="list-unstyled">
									<li><a href="#">Support</a></li>
									<li><a href="#">Knowledge base</a></li>
									<li><a href="#">Live chat</a></li>
								</ul>
							</div>

							<div class="col-6 col-sm-6 col-md-3">
								<ul class="list-unstyled">
									<li><a href="#">Jobs</a></li>
									<li><a href="#">Our team</a></li>
									<li><a href="#">Leadership</a></li>
									<li><a href="#">Privacy Policy</a></li>
								</ul>
							</div>

							<div class="col-6 col-sm-6 col-md-3">
								<ul class="list-unstyled">
									<li><a href="#">Nordic Chair</a></li>
									<li><a href="#">Kruzo Aero</a></li>
									<li><a href="#">Ergonomic Chair</a></li>
								</ul>
							</div> -->
						</div>
					</div>

				</div>

				<div class="border-top copyright">
					<div class="row pt-4">
						<div class="col-lg-6">
							<p class="mb-2 text-center text-lg-start">Copyright &copy;<script>document.write(new Date().getFullYear());</script>. All Rights Reserved. &mdash; Designed with love by <a href="https://untree.co">Untree.co</a>  Distributed By <a href="https://themewagon.com">ThemeWagon</a> <!-- License information: https://untree.co/license/ -->
            </p>
						</div>

						<div class="col-lg-6 text-center text-lg-end">
							<ul class="list-unstyled d-inline-flex ms-auto">
								<!-- <li class="me-4"><a href="#">Terms &amp; Conditions</a></li>
								<li><a href="#">Privacy Policy</a></li> -->
							</ul>
						</div>

					</div>
				</div>

			</div>
		</footer>
		<!-- End Footer Section -->	


		<script src="<?php echo base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/tiny-slider.js"></script>
		<script src="<?php echo base_url() ?>assets/js/custom.js"></script>
	</body>

</html>
