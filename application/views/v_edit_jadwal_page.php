

		<!-- Start Hero Section -->
			<div class="hero" style="background: #28a745;">
				<div class="container">
					<div class="row justify-content-between">
						<div class="col-lg-5">
							<div class="intro-excerpt">
                <?php
                  $header_content = "";
                  if($tipe_page == "create"){
                    $header_content = "Tambah Jadwal";
                  }
                  else if($tipe_page == "edit"){
                    $header_content = "Edit Jadwal '{$prev_page_data['nama_jadwal']}'";
                    echo "<input id='data-id-jadwal' type='hidden' value='{$prev_page_data['id_jadwal']}'>";
                  }

                  echo "<input id='data-tipe-page' type='hidden' value='{$tipe_page}'>";
                  echo "<h1>{$header_content}</h1>";
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
                  <label>Nama Jadwal : </label>
                  <?php
                    $nama_jadwal = "";
                    $tanggal_mulai = "";

                    if($tipe_page == "edit"){
                      $nama_jadwal = $prev_page_data["nama_jadwal"];
                      $tanggal_mulai = $prev_page_data["tanggal_mulai"];
                    }

                    echo <<<HTMLCODE
                      <input type="text" class="form-control" name="nama_jadwal" value="{$nama_jadwal}">
                      <label>Tanggal Mulai Pengiriman : </label>
                      <input type="date" class="form-control" name="tanggal_mulai" value="{$tanggal_mulai}">
                    HTMLCODE;
                  ?>
                  
                  <label style="display: block;">Tipe Interval Pengiriman :</label>
                  <?php
                    $list_radio = array(
                      array(
                        "value" => "interval_hari",
                        "disp_name" => "Interval Hari"
                      ),

                      array(
                        "value" => "harian",
                        "disp_name" => "Harian"
                      )
                    );
                    
                    foreach($list_radio as $radio_data){
                      $value = $radio_data["value"];
                      $disp_name = $radio_data["disp_name"];
                      $checked = "";
                      
                      if($tipe_page == "edit"){
                        if($prev_page_data["tipe_interval"] == $value)
                          $checked = "checked";
                      }

                      echo <<<HTMLCODE
                        <input type="radio" name="tipe_interval" value='{$value}' id='{$value}_radio' onchange="toggleForms()" {$checked}>
                        <label for='{$value}' style="display: inline-block;">{$disp_name}</label><br>
                      HTMLCODE;
                    }
                  ?>

                  <div id="intervalForm" style="display: none;">
                    <?php
                      $jumlah_hari = "1";
                      if($tipe_page == "edit"){
                        $jumlah_hari = $prev_page_data["interval_hari"];
                      }

                      echo <<<HTMLCODE
                        <label for="jumlah_hari" style="display: block;">Masukkan Jumlah Hari:</label>
                        <input type="number" name="interval_hari" id="jumlah_hari" class="form-control" value="{$jumlah_hari}">
                      HTMLCODE;
                    ?>
                  </div>

                  <div id="harianForm" style="display: none;">
                    <label for="checkbox_harian" style="display: block;">Pilih Hari Pengiriman:</label>
                    <?php
                      $list_radio = array(
                        array(
                          "value" => "senin",
                          "disp_name" => "Senin"
                        ),
                        array(
                          "value" => "selasa",
                          "disp_name" => "Selasa"
                        ),
                        array(
                          "value" => "rabu",
                          "disp_name" => "Rabu"
                        ),
                        array(
                          "value" => "kamis",
                          "disp_name" => "Kamis"
                        ),
                        array(
                          "value" => "jumat",
                          "disp_name" => "Jum'at"
                        ),
                        array(
                          "value" => "sabtu",
                          "disp_name" => "Sabtu"
                        ),
                        array(
                          "value" => "minggu",
                          "disp_name" => "Minggu"
                        )
                      );

                      $list_hari = "";
                      if($tipe_page == "edit"){
                        $list_hari = $prev_page_data["list_hari"];
                      }

                      foreach($list_radio as $radio){
                        $value = $radio["value"];
                        $disp_name = $radio["disp_name"];
                        $checked = "";
                        
                        if(strrpos($list_hari, $value) !== FALSE){
                          $checked = "checked";
                        }

                        echo <<<HTMLCODE
                          <input type="checkbox" name="hari_hari" value="{$value}" style="display: inline-block;" {$checked}> {$disp_name}<br>
                        HTMLCODE;
                      }
                    ?>
                  </div>
                  
                  <br>
                  <label name='error_message' style='color: #ff5050;'></label>
                                    
									<!--<input type="email" class="form-control" placeholder="Enter your email"><br/>-->
									<br/>
									<button onclick='doSubmit()' class="btn btn-primary">
										<span>
                      <?php
                        if($tipe_page == "create")
                          echo "Add Jadwal";
                        else if($tipe_page == "edit")
                          echo "Apply";
                      ?>
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
    <script src='<?php echo base_url("static/js/edit_jadwal.js"); ?>'></script>