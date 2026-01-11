<div class="x_panel">
    <div class="x_title">
        <h2>Tambah Pembelian</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">
        <form action="<?= base_url('example/save_purchase') ?>" method="post">

            <!-- OBAT -->
            <label>Obat</label>
            <select name="id_obat" class="form-control" required>
                <option value="">-- Pilih Obat --</option>
                <?php foreach($obat as $o): ?>
                    <option value="<?= $o->id_obat ?>">
                        <?= $o->nama_obat ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>

            <!-- PEMASOK -->
            <label>Pemasok</label>
            <select name="nama_pemasok" class="form-control" required>
                <option value="">-- Pilih Pemasok --</option>
                <?php foreach($pemasok as $p): ?>
                    <option value="<?= $p->nama_pemasok ?>">
                        <?= $p->nama_pemasok ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <br>

            <!-- QTY -->
            <label>Jumlah</label>
            <input type="number" name="qty" class="form-control" required min="1">
            <br>

            <!-- HARGA BELI -->
            <label>Harga Beli</label>
            <input type="number" name="harga_beli" class="form-control" required>
            <br>

            <!-- HARGA JUAL -->
            <label>Harga Jual</label>
            <input type="number" name="harga_jual" class="form-control" required>
            <br>

            <!-- KEDALUWARSA -->
            <label>Kedaluwarsa</label>
            <input type="date" name="kedaluwarsa" class="form-control" required>
            <br>

            <button type="submit" class="btn btn-success">
                Simpan Pembelian
            </button>

        </form>
    </div>
</div>
