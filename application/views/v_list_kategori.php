

		<!-- Start Hero Section -->
			<div class="hero">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>Category</b> </h1>
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
              <?php
                foreach($list_kategori as $kategori){
                  $id_kategori = $kategori["id_kategori"];
                  $nama_kategori = $kategori["nama_kategori"];
                  $url_page_kategori = base_url("item/kategori?id={$id_kategori}");
                  $url_img_kategori = base_url($kategori["url_image"]);

                  echo <<<HTMLCODE
                    <div class="col-12 col-md-4 col-lg-3 mb-5">
                      <a class="product-item" href="{$url_page_kategori}">
                        <img src="{$url_img_kategori}" class="img-fluid product-thumbnail">
                        <h3 class="product-title">{$nama_kategori}</h3>
                      </a>
                    </div>
                  HTMLCODE;
                }
              ?>
            </div>
		    </div>
		</div>
