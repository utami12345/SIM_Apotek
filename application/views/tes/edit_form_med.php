<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Ubah Obat</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">

        <?php foreach($table_med as $m){ ?>
        <form action="<?php echo base_url('example/update_medicine'); ?>" 
              method="post" 
              class="form-horizontal form-label-left" 
              novalidate>

          <input type="hidden" name="id_obat" value="<?php echo $m->id_obat; ?>">

          <!-- Nama Obat -->
          <div class="item form-group">
            <label class="control-label col-md-3">Nama Obat</label>
            <div class="col-md-6">
              <input type="text" id="nama_obat" name="nama_obat"
                     class="form-control" required
                     value="<?= $m->nama_obat ?>">
            </div>
          </div>

          <!-- Satuan -->
          <div class="item form-group">
            <label class="control-label col-md-3">Satuan</label>
            <div class="col-md-6">
              <select id="id_satuan" name="unit" class="form-control select2_single" required>
                <option disabled>Pilih Satuan</option>
                <?php foreach($get_unit as $gu): ?>
                  <option value="<?= $gu->id_unit ?>"
                    <?= ($gu->id_unit == $m->unit ? 'selected' : '') ?>>
                    <?= $gu->unit ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Kategori -->
          <div class="item form-group">
            <label class="control-label col-md-3">Kategori</label>
            <div class="col-md-6">
              <select id="id_kat" name="nama_kategori" class="form-control select2_single" required>
                <option disabled>Pilih Kategori</option>
                <?php foreach($get_cat as $gc): ?>
                  <option value="<?= $gc->id_kat ?>"
                    <?= ($gc->id_kat == $m->nama_kategori ? 'selected' : '') ?>>
                    <?= $gc->nama_kategori ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <!-- Tombol -->
          <div class="ln_solid"></div>
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="<?php echo base_url('example/table_med'); ?>" class="btn btn-danger">Batal</a>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </div>

        </form>
        <?php } ?>

      </div>
    </div>
  </div>
</div>
