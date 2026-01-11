<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Tambah Obat Baru</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">
        <form action="<?php echo base_url('example/add_medicine'); ?>" method="post" class="form-horizontal form-label-left" novalidate>

          <!-- Nama Obat -->
          <div class="item form-group">
            <label class="control-label col-md-3" for="nama_obat">Nama Obat</label>
            <div class="col-md-6">
              <input type="text" id="nama_obat" name="nama_obat" class="form-control" required>
            </div>
          </div>


          <!-- Satuan -->
          <div class="item form-group">
            <label class="control-label col-md-3" for="satuan">Satuan</label>
            <div class="col-md-6">
              <select id="id_satuan" name="unit" class="form-control select2_single" required>
                <option value="" disabled selected>Pilih Satuan</option>
                <?php foreach($get_unit as $gu): ?>
                  <option value="<?php echo $gu->id_unit; ?>"><?php echo $gu->unit; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Kategori -->
          <div class="item form-group">
            <label class="control-label col-md-3" for="satuan">Kategori</label>
            <div class="col-md-6">
              <select id="id_kat" name="nama_kategori" class="form-control select2_single" required>
                <option value="" disabled selected>Pilih Kategori</option>
                <?php foreach($get_cat as $gc): ?>
                  <option value="<?php echo $gc->id_kat; ?>"><?php echo $gc->nama_kategori; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>
          
          <!-- Tombol -->
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="<?php echo base_url('example/table_med'); ?>" class="btn btn-danger">Batal</a>
              <button type="submit" id="send" class="btn btn-success">Simpan</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>
