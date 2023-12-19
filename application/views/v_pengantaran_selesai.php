

		<!-- Start Hero Section -->
    <div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
                <?php
                  echo <<<HTMLCODE
                    <input name='id_pengantaran' type='hidden' value='{$pengantaran_data['id_pengantaran']}'>
                    <h1>Selesaikan Pesanan <b>{$jadwal_data['nama_jadwal']}</b></h1>
                  HTMLCODE;
                ?>
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
                  <label style="display: block;">Keterangan Penyelesaian :</label>
                  <textarea class="form-control" name="input-keterangan" rows="5" cols="25"></textarea>
									<br/>
                  <label style="color: #ff5050;" name="error_message"></label>
									<button onclick='doSubmit()' class="btn btn-primary">
										<span>
                      Selesaikan Pengantaran
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
    <script src='<?php echo base_url("static/js/pengantaran_selesai.js"); ?>'></script>