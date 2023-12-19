

		<!-- Start Hero Section -->
			<div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>
                  <label><b>
                    <?php 
                      if(!isset($intro_title))
                        $intro_title = "List Barang";

                      echo "{$intro_title}"; 
                    ?>
                  </b></label>
                </h1>
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
              <?php
                $url_cart_logo = base_url("assets/iamges/cart.svg");

                // jika nggak ada data barang yang bisa ditampilkan
                if(sizeof($data_barang) <= 0){
                  echo "<label>Tidak ada barang yang sesuai dengan apa yang kamu mau :(</label>";
                }

                foreach($data_barang as $barang){
                  $data_page = $barang["page_data"];
                  $id_page = $data_page["id_page"];
                  $nama_barang = $data_page["nama_general_barang"];

                  $harga_barang = NAN;
                  if(sizeof($data_page["harga_list"]) > 0)
                    $harga_barang = $data_page["harga_list"][0];

                  $url_image_barang = "";
                  if(sizeof($data_page["image_links"]) > 0)
                    $url_image_barang = $data_page["image_links"][0];

                  $url_barang = base_url("item/barang?id={$id_page}");
                  
                  echo <<<HTMLCODE
                    <div class="product-item-input">
                    </div>
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                      <a class="product-item" href="{$url_barang}">
                      <img src="{$url_image_barang}" class="img-fluid product-thumbnail">
                      <h3 class="product-title">{$nama_barang}</h3>
                      <strong class="product-price">{$harga_barang}</strong>
                      <span class="icon-cross">
                        <img src="{$url_cart_logo}" class="img-fluid">
                      </span>
                      </a>
                    </div>
                  HTMLCODE;
                }
              ?>
		      	</div>
		    </div>
		</div>