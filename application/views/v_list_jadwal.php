
		<!-- Start Hero Section -->
			<div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
								<h1>List jadwal</h1>
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
                          <!--<th class="product-thumbnail">ID Jadwal</th>-->
                          <th class="product-name">Nama Jadwal</th>
                          <th class="product-price">Total Pada Keranjang</th>
                          <th class="product-price">Tanggal Pengiriman Selanjutnya</th>
                          <th class="product-total">Detail Link</th>
                          <!--<th class="product-quantity">Total</th>-->
                          <!--<th class="product-remove">Remove</th>-->
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $ada_jadwal = FALSE;
                          foreach($list_jadwal_array as $jadwal): 
                            $id_jadwal = $jadwal["id_jadwal"];
                            $nama_jadwal = $jadwal["nama_jadwal"];
                            $tanggal_selanjutnya = $DataJadwalModel->get_first_next_day($jadwal["id_jadwal"]);

                            $total_harga = $jadwal["total_harga"];

                            $tanggal_invalid = FALSE;
                            if($tanggal_selanjutnya["error"] == DataJadwalModel::data_jadwal_error_ok){
                              $tanggal_selanjutnya = $tanggal_selanjutnya["data"]["next_array"][0];
                              $tanggal_invalid = FALSE;
                            }
                            else{
                              $tanggal_selanjutnya = "Invalid Interval";
                              $tanggal_invalid = TRUE;
                            }

                            $link_jadwal = base_url("jadwal/jadwal?id={$id_jadwal}");
                            $link_edit_jadwal = base_url("jadwal/edit_jadwal?id={$id_jadwal}");

                            $ada_jadwal = TRUE;
                        ?>
                        <tr>
                          <!--<td class="product-thumbnail">-->
                            <!--<img src="images/product-1.png" alt="Image" class="img-fluid">-->
                          <!--  <?= $id_jadwal ?>-->
                          <!--</td>-->
                          <td class="product-name">
                            <!--<h2 class="h5 text-black">Product 1</h2>-->
                            <h5><b><?= $nama_jadwal ?></b></h5>
                          </td>
                          <td>
                            <?php
                              if(is_nan($total_harga))
                                echo "Tidak bisa didapat, silahkan cek jadwal.";
                              else
                                echo "Rp. {$total_harga}";
                            ?>
                          </td>

                          <!--<td><?= $tanggal_selanjutnya ?></td>-->
                          <td>
                            <?php
                              $daysBeforeDelivery = "-";
                              if(!$tanggal_invalid){
                                $currentDate = date('Y-m-d');
  
                                $daysBeforeDelivery = floor((strtotime($tanggal_selanjutnya) - strtotime($currentDate)) / (60 * 60 * 24));
                              }
                            
                              echo "<b>{$daysBeforeDelivery} hari sebelum pengiriman</b><br/> ({$tanggal_selanjutnya})";
                            ?>
                          </td>

                          <td>
                            <!--<div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">-->
                            <!--  <div class="input-group-prepend">-->
                            <!--    <button class="btn btn-outline-black decrease" type="button">&minus;</button>-->
                            <!--  </div>-->
                            <!--  <input type="text" class="form-control text-center quantity-amount" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">-->
                            <!--  <div class="input-group-append">-->
                            <!--    <button class="btn btn-outline-black increase" type="button">&plus;</button>-->
                            <!--  </div>-->
                            <!--</div>-->
                                <a href="<?= $link_jadwal ?>"><i>Show Item</i></a>
                                <br>
                                <a href="<?= $link_edit_jadwal ?>"><i>Edit Jadwal</i></a>
                          </td>
                          <!--<td>$49.00</td>-->
                          <!--<td><a href="#" class="btn btn-black btn-sm">X</a></td>-->
                        </tr>
        
                        <!--<tr>-->
                        <!--  <td class="product-thumbnail">-->
                            <!--<img src="images/product-2.png" alt="Image" class="img-fluid">-->
                        <!--  </td>-->
                        <!--  <td class="product-name">-->
                            <!--<h2 class="h5 text-black">Product 2</h2>-->
                        <!--  </td>-->
                          <!--<td>$49.00</td>-->
                        <!--  <td>-->
                            <!--<div class="input-group mb-3 d-flex align-items-center quantity-container" style="max-width: 120px;">-->
                            <!--  <div class="input-group-prepend">-->
                            <!--    <button class="btn btn-outline-black decrease" type="button">&minus;</button>-->
                            <!--  </div>-->
                            <!--  <input type="text" class="form-control text-center quantity-amount" value="1" placeholder="" aria-label="Example text with button addon" aria-describedby="button-addon1">-->
                            <!--  <div class="input-group-append">-->
                            <!--    <button class="btn btn-outline-black increase" type="button">&plus;</button>-->
                            <!--  </div>-->
                            <!--</div>-->
        
                        <!--  </td>-->
                          <!--<td>$49.00</td>-->
                          <!--<td><a href="#" class="btn btn-black btn-sm">X</a></td>-->
                        <!--</tr>-->
                        <?php endforeach; ?>
                      </tbody>
                    </table>


                    <?php
                      $no_jadwal_hidden = "";
                      if($ada_jadwal)
                        $no_jadwal_hidden = "hidden";

                      echo <<<HTMLCODE
                        <div id="label-no-jadwal" style="text-align: center;" {$no_jadwal_hidden}>Anda masih belum ada jadwal :(</div>
                      HTMLCODE;
                    ?>
                  </div>
                </form>
              </div>
        
              <div class="row">
                <div class="col-md-6">
                  <div class="row mb-5">
                    <div class="col-md-6 mb-3 mb-md-0">
                      <!--<button class="btn btn-black btn-sm btn-block">Add Item</button>-->
                      <a href="<?php echo base_url('jadwal/add_jadwal'); ?>" class="btn btn-black btn-sm btn-block">Add Jadwal</a>


                    </div>
                    <div class="col-md-6">
                      <!--<button class="btn btn-outline-black btn-sm btn-block">Continue Shopping</button>-->
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
                <!--<div class="col-md-6 pl-5">-->
                  <!--<div class="row justify-content-end">-->
                  <!--  <div class="col-md-7">-->
                  <!--    <div class="row">-->
                  <!--      <div class="col-md-12 text-right border-bottom mb-5">-->
                          <!--<h3 class="text-black h4 text-uppercase">Cart Totals</h3>-->
                  <!--      </div>-->
                  <!--    </div>-->
                  <!--    <div class="row mb-3">-->
                  <!--      <div class="col-md-6">-->
                          <!--<span class="text-black">Subtotal</span>-->
                  <!--      </div>-->
                  <!--      <div class="col-md-6 text-right">-->
                          <!--<strong class="text-black">$230.00</strong>-->
                  <!--      </div>-->
                  <!--    </div>-->
                  <!--    <div class="row mb-5">-->
                  <!--      <div class="col-md-6">-->
                          <!--<span class="text-black">Total</span>-->
                  <!--      </div>-->
                  <!--      <div class="col-md-6 text-right">-->
                          <!--<strong class="text-black">$230.00</strong>-->
                  <!--      </div>-->
                  <!--    </div>-->
        
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