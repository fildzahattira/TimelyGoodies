
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
      <?php
        $url_sampai_pengiriman = base_url("pengantaran/mark_done");
        echo <<<HTMLCODE
          <input type="hidden" name="mark-done-url" value="{$url_sampai_pengiriman}">
        HTMLCODE;
      ?>
            <div class="container">
              <div class="row mb-5">
                <div class="site-blocks-table">
                  <?php
                    $nama_label = "Kurir Pengantar";
                    $additional_html = <<<HTMLCODE
                      <th class "product-total">Keterangan</th>
                    HTMLCODE;

                    switch($tipe_page){
                      case "original_kurir":
                        $nama_label = "Username Penerima";
                        $additional_html = <<<HTMLCODE
                          <th class="product-total">Action</th>
                        HTMLCODE;
                        break;
                    }
                    
                    $table_head = <<<HTMLCODE
                    <table class="table">
                      <thead>
                        <tr>
                          <th class="product-name">Nama Jadwal</th>
                          <th class="product-price">Status Pengiriman</th>
                          <th class="product-price">{$nama_label}</th>
                          <th class="product-price">Harga</th>
                          <th class="product-price">Alamat</th>
                          {$additional_html}
                        </tr>
                      </thead>
                      <tbody>
                    HTMLCODE;

                    $table_foot = <<<HTMLCODE
                      </tbody>
                    </table>
                    HTMLCODE;

                    $table_body1 = "";
                    $table_body2 = "";

                    $ada_pengantaran = FALSE;
                    $ada_pengantaran_secondary = FALSE;
                    foreach($list_pengantaran as $pengantaran){
                      $id_pengantaran = $pengantaran["id_pengantaran"];
                      $id_jadwal = $pengantaran["id_jadwal"];
                      $id_user = $pengantaran["id_user"];
                      $id_kurir = $pengantaran["id_kurir"];

                      $nama_jadwal = "-";
                      $nama_akun = "-";
                      $total_harga = "-";
                      $alamat = "-";
                      $keterangan = $pengantaran["keterangan_penerima"];
                      if(strlen($keterangan) <= 0)
                        $keterangan = "-";

                      $current_status = $pengantaran["status"];

                      $data_user = $UserModel->get_user_data($id_user);
                      $data_kurir = $KurirModel->get_user_data($id_kurir);
                      if($data_user["error"] == Base_Controller::generic_error_ok)
                        $data_user = $data_user["data"];
                      else
                        $data_user = NULL;

                      if($data_kurir["error"] == Base_Controller::generic_error_ok)
                        $data_kurir = $data_kurir["data"];
                      else
                        $data_kurir = NULL;

                      
                      if($data_user != NULL){
                        $alamat = $data_user["alamat"];
                      }

                      $data_jadwal = $DataJadwalModel->get_data_jadwal($id_jadwal);
                      if($data_jadwal["error"] == Base_Controller::generic_error_ok){
                        $data_jadwal = $data_jadwal["data"];
                        $f_res = $KeranjangJadwalModel->get_total_harga($id_jadwal);
                        if($f_res["error"] == Base_Controller::generic_error_ok){
                          $total_harga = $f_res["data"]["harga"];
                        }

                        $nama_jadwal = $data_jadwal["nama_jadwal"];
                      }
                      
                      $readable_status = array(
                        "idle" => "Masih belum diambil.",
                        "diproses" => "Sedang diproses",
                        "diantar" => "Lagi diantar.",
                        "sampai" => "Sudah sampai!",
                        "batal" => "Dibatalkan.",
                        "telat" => "Pengiriman telat dikirim.",
                        "saldo_tidak_cukup" => "Saldo tidak mencukupi.",
                        "tidak_ada_barang" => "Tidak ada barang pada jadwal."
                      );

                      $readable_color_status = array(
                        "idle" => "E5E535",
                        "diproses" => "E5E535",
                        "diantar" => "E5E535",
                        "sampai" => "12E007",
                        "batal" => "D53200",
                        "telat" => "D53200",
                        "saldo_tidak_cukup" => "D53200",
                        "tidak_ada_barang" => "D53200"
                      );

                      switch($tipe_page){
                        case "original_kurir":
                          if($data_user != NULL){
                            $nama_akun = $data_user["username"];
                          }

                          break;

                        default:
                          if($data_kurir != NULL){
                            $nama_akun = $data_kurir["username"];
                          }

                          break;
                      }
                      
                      $new_html_part = <<<HTMLCODE
                        <td class="product-name">
                          <h5><b>
                            {$nama_jadwal}
                          </b></h5>
                        </td>
                        
                        <td>
                          <label style='text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000; color: #{$readable_color_status[$current_status]}'>
                            {$readable_status[$current_status]}
                          </label>
                        </td>

                        <td>
                          {$nama_akun}
                        </td>

                        <td>
                          Rp. {$total_harga}
                        </td>

                        <td>
                          {$alamat}
                        </td>
                      HTMLCODE;
                      
                      switch($tipe_page){
                        case "original_kurir":
                          $additional_html = <<<HTMLCODE
                            <td><button disabled>Tidak ada yang bisa dilakukan</button></td>
                          HTMLCODE;

                          $action_format = <<<HTMLCODE
                            <td><button onclick="changeStatus({$id_pengantaran}, '%s')">Ganti ke '%s'</button></td>
                          HTMLCODE;
                          switch($current_status){
                            case "idle":
                              $additional_html = <<<HTMLCODE
                                <td><button onclick="ambilPengiriman({$id_pengantaran})">Ambil Pengantaran?</button><td>
                              HTMLCODE;
                              break;

                            case "diproses":
                              $additional_html = sprintf($action_format, "diantar", "diantar");
                              break;

                            case "diantar":
                              $additional_html = sprintf($action_format, "sampai", "sampai");
                              break;
                          }

                          $new_html_part .= $additional_html;

                          switch($current_status){
                            case "idle":
                              $table_body2 .= "<tr>{$new_html_part}<tr>";
                              $ada_pengantaran_secondary = TRUE;
                              break;
                              
                            default:
                              $table_body1 .= "<tr>{$new_html_part}<tr>";
                              $ada_pengantaran = TRUE;
                              break;
                          }

                          break;

                        default:
                          $new_html_part .= <<<HTMLCODE
                            <td>
                              {$keterangan}
                            <td>
                          HTMLCODE;

                          $table_body1 .= "<tr>{$new_html_part}<tr>";
                          $ada_pengantaran = TRUE;
                          break;
                      }
                    }

                    switch($tipe_page){
                      case "original_kurir":
                        echo <<<HTMLCODE
                        <h4>
                          List Pengantaran Sedang Aktif
                        </h4>
                        HTMLCODE;

                        echo $table_head;
                        echo $table_body1;
                        echo $table_foot;
                        if(!$ada_pengantaran){
                          echo <<<HTMLCODE
                            <div id="label-no-pengantaran" style="text-align: center;">Tidak ada pengantaran yang sedang diambil</div>
                          HTMLCODE;
                        }

                        echo <<<HTMLCODE
                        <br><br>
                        <h4>
                          List Pengantaran Idle
                        </h4>
                        HTMLCODE;

                        echo $table_head;
                        echo $table_body2;
                        echo $table_foot;
                        if(!$ada_pengantaran_secondary){
                          echo <<<HTMLCODE
                            <div id="label-no-pengantaran" style="text-align: center;">Tidak ada pengantaran yang bisa diambil :(</div>
                          HTMLCODE;
                        }

                        break;

                      default:
                        echo $table_head;
                        echo $table_body1;
                        echo $table_foot;
                        if(!$ada_pengantaran){
                          echo <<<HTMLCODE
                            <div id="label-no-pengantaran" style="text-align: center;">Tidak ada pengantaran yang aktif :(</div>
                          HTMLCODE;
                        }
                        break;
                    }
                  ?>
                </div>
              </div>
        
              <div class="row">
                <div class="col-md-6">
                  <div class="row mb-5">
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
        <script src="<?php echo base_url("static/js/list_pengantaran.js"); ?>"></script>