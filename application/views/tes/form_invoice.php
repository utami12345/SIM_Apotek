<div class="row">
  <div class="col-md-12">
    <div class="x_panel">

      <div class="x_title">
        <h2>Tambah Penjualan Baru</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
          <li><a class="close-link"><i class="fa fa-close"></i></a></li>
        </ul>
        <div class="clearfix"></div>
      </div>

      <div class="x_content">

        <form action="<?= base_url('example/add_invoice') ?>" method="post" class="form-horizontal form-label-left">

          <!-- Nama Pembeli -->
          <div class="form-group">
            <label class="control-label col-md-3">Nama Pembeli</label>
            <div class="col-md-6">
              <input type="text" name="nama_pembeli" class="form-control" required>
            </div>
          </div>

          <!-- Tanggal -->
          <div class="form-group">
            <label class="control-label col-md-3">Tanggal Transaksi</label>
            <div class="col-md-6">
              <input type="date" name="tgl_beli" class="form-control" required>
            </div>
          </div>

          <!-- TABLE -->
          <table class="table table-bordered" id="prod">
            <thead>
              <tr>
                <th style="text-align:center">Obat yang dijual</th>
                <th style="text-align:center">Stok</th>
                <th style="text-align:center">Satuan</th>
                <th style="text-align:center">Harga</th>
                <th style="text-align:center">Qty</th>
                <th style="text-align:center">Subtotal</th>
                <th style="text-align:center">Aksi</th>
              </tr>
            </thead>

            <tbody id="tbody-produk"></tbody>

            <tfoot>
              <tr>
                <td colspan="5" style="text-align:right"><b>Grandtotal</b></td>
                <td><input type="text" name="grandtotal" id="grandtotal" class="form-control" readonly></td>
                <td></td>
              </tr>
            </tfoot>
          </table>

          <div class="ln_solid"></div>

          <!-- BUTTON -->
          <div class="form-group">
            <div class="col-md-6 col-md-offset-3">
              <a href="<?= base_url('example/table_invoice') ?>" class="btn btn-danger">Batal</a>
              <button type="button" id="addRow" class="btn btn-info">
                <i class="fa fa-plus"></i> Tambah Produk
              </button>
              <button type="submit" class="btn btn-success">Simpan</button>
            </div>
          </div>

        </form>
      </div>
    </div>
  </div>
</div>

<!-- ================= JAVASCRIPT ================= -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
/* ===== ADD ROW ===== */
$('#addRow').click(function () {
  let row = `
  <tr>
    <td>
      <select name="id_stok[]" class="form-control obat" required>
        <option value="">-- Pilih Obat --</option>
        <?php foreach ($obat as $o): ?>
          <option value="<?= $o->id_stok ?>"
            data-stok="<?= $o->stok ?>"
            data-satuan="<?= $o->unit ?>"
            data-harga="<?= $o->harga_jual ?>">
            <?= $o->nama_obat ?> (Exp: <?= date('d-m-Y', strtotime($o->kedaluwarsa)) ?>)
          </option>
        <?php endforeach; ?>
      </select>
    </td>

    <td><input type="text" class="form-control stok" readonly></td>
    <td><input type="text" class="form-control satuan" readonly></td>
    <td><input type="text" class="form-control harga" readonly></td>

    <td><input type="number" name="banyak[]" class="form-control banyak" min="1" value="1"></td>
    <td><input type="text" name="subtotal[]" class="form-control subtotal" readonly></td>
    <td style="text-align:center">
      <button type="button" class="btn btn-danger btn-sm remove"><i class="fa fa-trash"></i></button>
    </td>
  </tr>`;
  $('#tbody-produk').append(row);
});

/* ===== SELECT OBAT ===== */
$(document).on('change', '.obat', function () {
  let opt = $(this).find(':selected');
  let row = $(this).closest('tr');

  row.find('.stok').val(opt.data('stok'));
  row.find('.satuan').val(opt.data('satuan'));
  row.find('.harga').val(opt.data('harga'));

  hitungSubtotal(row);
});

/* ===== QTY CHANGE ===== */
$(document).on('input', '.banyak', function () {
  hitungSubtotal($(this).closest('tr'));
});

/* ===== HITUNG SUBTOTAL ===== */
function hitungSubtotal(row) {
  let harga = parseInt(row.find('.harga').val()) || 0;
  let banyak = parseInt(row.find('.banyak').val()) || 0;

  row.find('.subtotal').val(harga * banyak);
  hitungGrandtotal();
}

/* ===== HITUNG GRANDTOTAL ===== */
function hitungGrandtotal() {
  let total = 0;
  $('.subtotal').each(function () {
    total += parseInt($(this).val()) || 0;
  });
  $('#grandtotal').val(total);
}

/* ===== REMOVE ROW ===== */
$(document).on('click', '.remove', function () {
  $(this).closest('tr').remove();
  hitungGrandtotal();
});
</script>
