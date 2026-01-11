


<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Laporan Laba Rugi</h2>
				<ul class="nav navbar-right panel_toolbox">
					<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
					</li>
					
					<li><a class="close-link"><i class="fa fa-close"></i></a>
					</li>
				</ul>
				<div class="clearfix">
				</div>
			</div>

			<div class="x_content">
				<!-- <?php if($this->session->flashdata('inv_added')): ?>
                  <button id="melinda" style="display: none;" class="btn btn-default source" onclick="new PNotify({
                                  title: 'Berhasil',
                                  text: '<?php echo $this->session->flashdata('inv_added'); ?>',
                                  type: 'success',
                                  hide: false,
                                  styling: 'bootstrap3'
                              });">Success</button>
                 	</div>
                 	
				<?php endif; ?> -->

				<form action="<?=  base_url("example/cari_laba_rugi");  ?>" method="post" >
							  <label for="">Kategori</label>
							  <?php 
							 $kategoris = $this->db->query("SELECT * FROM table_cat")->result_array(); 
							  ?>
							  <select name="kategori" id="" class="form-control">
								<option value="semua">Semua</option>
								<?php foreach($kategoris as $t) : ?>
									<option value="<?=  $t['nama_kategori'];  ?>"><?=  $t['nama_kategori'];  ?></option>
									<?php endforeach ?>
							  </select>
							  <br>
							  <button type="submit" class="btn btn-primary">Cari</button>
							  <br>
							  <br>
			</form>
			<br>
			<div class="text-center">
			<h3>Laporan Laba Rugi</h3>
			</div>
			<br>
				<table id="datatable-buttonss" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Barang</th>
							<th>Stok</th>
							<th>Jumlah Penjualan</th>
							<th>Jumlah Pembelian</th>
							<!-- <th>Nominal Stok</th> -->
							<th>Laba Rugi</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach($result as $i){
							$kode = $i->nama_barang;
							$tbl_med = $this->db->query("SELECT * FROM table_med WHERE nama_obat = '$kode'")->row_array();
							$total = $i->pemasukan - $i->pengeluaran + $tbl_med['harga_beli'] ;
							?>
						<tr>
							<td><?=  $no++;  ?></td>
							<td><?=  $i->nama_barang;  ?></td>
							<td><?php echo $tbl_med['stok'] ?></td>
							<td>Rp <?php echo number_format($i->pengeluaran) ?></td>
							<td>Rp <?php echo number_format($i->pemasukan) ?></td>
							<!-- <td><?php echo $i->stok_terakhir ?></td>	 -->
							<td>Rp <?php echo number_format($total) ?></td>	
							
						</tr>

						<?php } ?>
					</tbody>

				</table>
		</div>
	</div>
	</div>

</div>


