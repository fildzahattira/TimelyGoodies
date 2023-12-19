<<<<<<< HEAD
		<!-- Start Hero Section -->
			<div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>
                  <?php
                    $nama_page = $data_page["nama_general_barang"];
                    echo $nama_page;
                  ?>
                </h1>
							</div>
						</div>
						<div class="col-lg-7">
							
						</div>
					</div>
				</div>
			</div>
		<!-- End Hero Section -->

		<div class="untree_co-section before-footer-section">
            <div class="container">
              <div class="row mb-5">
                <form class="col-md-12" method="post">
                  <div class="site-blocks-table">
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="product-thumbnail">Image</th>
                          <th class="product-name">Product</th>
                          <th class="product-price">Price</th>
                          <!-- <th class="product-quantity">Quantity</th> -->
                          <!-- <th class="product-total">Total</th> -->
                          <th class="product-pick">Checkbox</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                          foreach($list_barang as $barang){
                            $id_barang = $barang["id_barang"];
                            $nama_barang = $barang["nama_barang"];
                            $base_harga = $barang["harga_barang"];
                            $image_link = "";
                            if(sizeof($barang["image_links"]) > 0)
                              $image_link = $barang["image_links"][0];

                            echo <<<HTMLCODE
                              <tr id="input-{$id_barang}">
                                <td hidden>
                                  <div id="hidden-data">
                                    <input type="hidden" id="id_barang" value="{$id_barang}">
                                    <input type="hidden" id="base_harga" value="{$base_harga}">
                                  </div>
                                </td>

                                <td class="product-thumbnail">
                                  <img src="{$image_link}" alt="Gambar {$nama_barang}" class="img-fluid">
                                </td>
                                <td class="product-name">
                                  <h2 class="h5 text-black">{$nama_barang}</h2>
                                </td>
                                <td>{$base_harga}</td>
                                <td>
                                    <input type="radio" onchange="setChecked()" name="id-barang-picked" value="{$id_barang}">
                                </td>
                              </tr>
                            HTMLCODE;
                          }
                        ?>
                      </tbody>
                    </table>
                  </div>
                </form>
              </div>
        
              <div class="row">
                <div class="col-md-6">
                  <div class="row mb-5">
                    <div class="col-md-6 mb-3 mb-md-0">
						
						  
                      <!-- <button class="btn btn-black btn-sm btn-block">Update Cart</button> -->
                    </div>
                    <div class="col-md-6">
                      <!-- <button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button> -->
                    </div>
                  </div>
                  <div class="row">
                    <!-- <div class="col-md-12">
                      <label class="text-black h4" for="coupon">Coupon</label>
                      <p>Enter your coupon code if you have one.</p>
                    </div>
                    <div class="col-md-8 mb-3 mb-md-0">
                      <input type="text" class="form-control py-3" id="coupon" placeholder="Coupon Code">
                    </div>
                    <div class="col-md-4">
                      <button class="btn btn-black">Apply Coupon</button>
                    </div> -->
                  </div>
                </div>
                <div class="col-md-6 pl-5">
                  <div class="row justify-content-end">
                    <div class="col-md-7">
                      <div class="row">
                        <div class="col-md-12 text-right border-bottom mb-5">
                          <h3 class="text-black h4 text-uppercase">DETAIL</h3>
                        </div>
                      </div>
                      <div class="row mb-3">
						<div class="col-md-6">
							<span class="text-black">Pilih Jadwal</span>
						  </div>
						  <div class="col-md-6 text-right">
								<select name="pilihan-jadwal" id="cars">
                  <option value="null">-</option>
                  <?php
                    foreach($list_jadwal as $jadwal){
                      $id_jadwal = $jadwal["id_jadwal"];
                      $nama_jadwal = $jadwal["nama_jadwal"];
                      $tanggal_selanjutnya = $DataJadwalModel->get_first_next_day($id_jadwal);
                      
                      $days_left_str = "ERR";
                      if($tanggal_selanjutnya["error"] == Base_Controller::generic_error_ok){
                        $tanggal_selanjutnya = $tanggal_selanjutnya["data"]["next_array"][0];

                        $days_left_str = floor(
                          (strtotime($tanggal_selanjutnya) - strtotime(date("Y-m-d"))) /
                          (60 * 60 * 24)
                        );
                      }
                      
                      echo <<<HTMLCODE
                        <option value="{$id_jadwal}">{$nama_jadwal} - {$days_left_str} Hari</option>
                      HTMLCODE;
                    }
                  ?>
								</select>
						  </div>
                        <div class="col-md-6">
                          <span class="text-black">Quantity</span>
                        </div>
                        <div class="col-md-6 text-right">
                          <strong class="text-black">
                            <button class="barang-quantity-decrease" onclick="quantityDecrease()">
                              -
                            </button>
                            <input type="number" class="barang-quantity" onchange="quantitySet()" value="1"/>
                            <button class="barang-quantity-increase" onclick="quantityIncrease()">
                              +
                            </button>
                          </strong>
                        </div>
                      </div>
                      <div class="row mb-5">
                        <div class="col-md-6">
                          <span class="text-black">Preview Harga</span>
                        </div>
                        <div class="col-md-6 text-right">
                          <strong class="text-black">
                            <label class="preview-harga">
                              Total Rp. 0
                            </label>
                          </strong>
                        </div>
                      </div>
        
                      <div class="row">
                        <div class="col-md-12">
                          <button class="btn btn-black btn-lg py-3 btn-block" onclick="addToCartClicked()">Add To cart</button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        <script src="<?php echo base_url("static/js/barang_page.js") ?>"></script>
=======
<?php 
  echo "<label>id_page: {$id_page}</label><br>";
  echo "<label>Nama barang: {$data_page["nama_general_barang"]}</label><br><br>";

  foreach($list_barang as $type_idx => $barang){
    echo <<<HTMLCODE
      <label>Tipe Barang: {$barang["nama_barang"]}</label>
      <br>
      <label>Harga Barang: {$barang["harga_barang"]}</label>
      <br>
      <label>ID Barang: {$barang["id_barang"]}</label>
      <br>
      <br>
    HTMLCODE;
  }

  echo "<label>Gambar barang:</label><br>";
  foreach($list_barang as $type_idx => $barang){
    echo "<br><label>Barang: {$barang["nama_barang"]}</label><br>";
    foreach($barang["image_links"] as $images){
      echo <<<HTMLCODE
        <img src="{$images}"><br>
      HTMLCODE;
    }
  }
?>
>>>>>>> 287d50661872511a97899037362e2b035ce9316b
