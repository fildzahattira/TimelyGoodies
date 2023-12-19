

		<!-- Start Hero Section -->
			<div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>Lihat Detail jadwal</h1>
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
          <div class="site-blocks-table">
            <h1>
              <?php
                $nama_jadwal = $data_jadwal["nama_jadwal"];
                $id_jadwal = $data_jadwal["id_jadwal"];
                echo <<<HTMLCODE
                  <h5>Nama Jadwal: <b>'{$nama_jadwal}' </b><br> ID: <b>{$id_jadwal}</b></h5>
                  <input type="hidden" id="data-id-jadwal" value="{$id_jadwal}">
                HTMLCODE;
              ?>
            </h1>
            <br>
            <h4>Detail Item : </h4>
              <table class="table">
                <thead>
                  <tr>
                    <th class="product-thumbnail">Nama Barang</th>
                    <th class="product-name">Gambar Barang</th>
                    <th class="product-price">Quantity</th>
                    <th class="product-total">Harga</th>
                    <th class="product-quantity">Action</th>
                    <!--<th class="product-remove">Remove</th>-->
                  </tr>
                </thead>
                <tbody>
                  <!-- php code -->
                  <?php
                    $total_harga = 0;
                    $ada_barang = FALSE;
                    foreach($list_barang as $barang){
                      $id_barang = $barang["id_barang"];
                      $quantitas = $barang["jumlah"];
              
                      $data_barang = $BarangModel->get_barang($id_barang);
                      if($data_barang["error"] != BarangModel::barang_error_ok)
                        continue;
              
                      $ada_barang = TRUE;
                      $data_barang = $data_barang["data"];
              
                      $nama_barang = $data_barang["nama_barang"];
                      $harga_barang = $data_barang["harga_barang"];
              
                      $total_harga = $quantitas * $harga_barang;
                      
                      $image_link = "";
                      $image_barang_data = $BarangModel->get_barang_image($id_barang);
                      if($image_barang_data["error"] == BarangModel::barang_error_ok && sizeof($image_barang_data["data"]) > 0)
                        $image_link = $image_barang_data["data"][0]["link_image"];
                      
                      echo <<<HTMLCODE
                        <tr id="input-{$id_barang}">
                          <td hidden>
                            <div id="hidden-data">
                              <input type="hidden" id="id_barang" value="{$id_barang}">
                              <input type="hidden" id="base_harga" value="{$harga_barang}">
                              <input type="hidden" id="quantity" value="{$quantitas}">
                            </div>
                          </td>

                          <td>{$nama_barang}</td>
                          <td><img src='{$harga_barang}' alt="Gambar {$nama_barang}" style="max-width: 150px; max-height: 150px;"/></td>
                        
                          <td>
                            <div>
                              <button class="barang-quantity-decrease" onclick="quantityDecrease({$id_barang})">
                                -
                              </button>
                              <input type="number" class="barang-quantity" onchange="quantitySet({$id_barang})" value="{$quantitas}"/>
                              <button class="barang-quantity-increase" onclick="quantityIncrease({$id_barang})">
                                +
                              </button>
                            </div>
                          </td>
                          <td>
                            <label class="barang-harga">
                              Rp. {$harga_barang}
                            </label>
                          </td>
                          <td>
                            <button class="barang-delete-button" onclick="deleteBarang({$id_barang})">
                              Delete
                            </button>
                          </td>
                        </tr>
                      HTMLCODE;
                    }
                  ?>
                </tbody>
              </table>

              <?php
                $no_barang_hidden = "";
                if($ada_barang)
                  $no_barang_hidden = "hidden";

                echo <<<HTMLCODE
                  <div id="label-no-barang" style="text-align: center;" {$no_barang_hidden}>Tidak ada barang :(</div><br><br>
                  <label id="label-total-harga"></label>
                HTMLCODE;
              ?>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="row mb-5">
                <div class="col-md-6 mb-3 mb-md-0">
                  <!--<button class="btn btn-black btn-sm btn-block">Update Cart</button>-->
                  <a href="<?php echo base_url('barang'); ?>" class="btn btn-black btn-sm btn-block">Add Item</a>
                </div>
                <div class="col-md-6">
                  <!--<button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>-->
                </div>
              </div>
              <div class="row">
                <!-- <div class="col-md-12">
                  <label class="text-black h4" for="coupon">Coupon</label>
                  <p>Enter your coupon code if you have one.</p>
                </div> -->
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <!--<button class="btn btn-black btn-lg py-3 btn-block" onclick="window.location='checkout.html'">Proceed To Checkout</button>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url("static/js/lihat_jadwal.js"); ?>"></script>

<script>
  // Enable Bootstrap dropdown on hover
  $(document).ready(function(){
    $('.navbar-nav .nav-item.dropdown').hover(function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(300);
    }, function() {
      $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(300);
    });
  });
</script>