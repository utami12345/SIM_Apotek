<div class="x_panel">
    <div class="x_title">
        <h2>Detail Obat</h2>
        <div class="clearfix"></div>
    </div>

    <div class="x_content">

        <h3><?= $obat->nama_obat ?></h3>
        <p>
            <strong>Kategori:</strong> <?= $obat->nama_kategori ?><br>
            <strong>Satuan:</strong> <?= $obat->unit ?>
        </p>

        <hr>

        <h4>Detail Stok</h4>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Pemasok</th>
                    <th>Kedaluwarsa</th>
                    <th>Stok</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($stok)): ?>
                    <?php foreach ($stok as $s): ?>
                        <tr>
                            <td><?= $s->nama_pemasok ?></td>
                            <td><?= date('d-m-Y', strtotime($s->kedaluwarsa)) ?></td>
                            <td><?= $s->stok ?></td>
                            <td>Rp <?= number_format($s->harga_beli) ?></td>
                            <td>Rp <?= number_format($s->harga_jual) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">Belum ada stok</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="<?= base_url('example/table_med') ?>" class="btn btn-default">
            Kembali
        </a>

    </div>
</div>
