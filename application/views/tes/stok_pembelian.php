


<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<div class="x_panel">
			<div class="x_title">
				<h2>Laporan Stok Pembelian</h2>
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

				<form action="<?=  base_url("example/cari_stok_pembelian");  ?>" method="post" >
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
							  <label for="">Waktu	</label>
							  <input type="date" name="waktu" class="form-control" required>
							  <br>
							  <button type="submit" class="btn btn-primary">Cari</button>
							  <br>
							  <br>
			</form>
			<br>
			<div class="text-center">
			<h3>Laporan Stok Pembelian</h3>
			<?php if(isset($cari)) : ?>
				<h4>Periode : <?=  date("d, F Y",strtotime($start));  ?></h4>
				Apotek Vanisa
				<br>
				Desa Berare-Moyo hilir
				<br>
				Sunagawa-Indonesia
				<?php endif; ?>
			</div>
			<br>
				<table id="datatable-buttonss" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>No</th>
							<th>Tanggal</th>
							<th>Nama Barang</th>
							<th>Satuan</th>
							<th>Pembelian</th>
							<th>Stok Terakhir</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$no = 1;
						foreach($result as $i){
							// $kode = $i->nama_obat;
							// $tbl_med = $this->db->query("SELECT * FROM table_med WHERE nama_obat = '$kode'")->row_array();
							?>
						<tr>
							<td><?=  $no++;  ?></td>
							<td><?php echo date('j F Y',strtotime($i->tanggal)) ?></td>
							<td><?=  $i->nama_barang;  ?></td>
							<td><?php echo $i->satuan ?></td>
							<td>Rp <?php echo number_format($i->pemasukan) ?></td>
							<td><?php echo $i->stok_terakhir ?></td>	
							
						</tr>

						<?php } ?>
					</tbody>

				</table>
		</div>
	</div>
	</div>

</div>


