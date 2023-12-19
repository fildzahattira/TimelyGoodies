

		<!-- Start Hero Section -->
    <div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
                <h1>Tambahkan Saldo</h1>
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
		      	  <!--<form class="row g-3" method="post">-->
								<div class="col-auto">
                  <?php
                    echo <<<HTMLCODE
                      <input type="hidden" name="max_saldo" value="{$max_saldo}">
                      <label style="display: block;">Saldo yang ingin ditambahkan (min. {$max_saldo}):</label>
                    HTMLCODE;
                  ?>

                  <input class="form-control" type="number" name="input-saldo">
									<br/>
                  <label style="color: #ff5050;" name="error_message"></label><br>
									<button onclick="doSubmit()" class="btn btn-primary">
										<span>
                      Selesaikan Penambahan
                    </span>
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
							<!--</form>-->

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
		      	</div>
		    </div>
		</div>
    <script src="<?php echo base_url("static/js/add_saldo.js"); ?>"></script>