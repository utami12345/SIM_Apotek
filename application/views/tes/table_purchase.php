<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Lihat Pembelian</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <!-- NOTIFIKASI -->
                <?php if($this->session->flashdata('pur_added')): ?>
                    <script>
                        $(document).ready(function(){
                            new PNotify({
                                title: 'Berhasil',
                                text: '<?= $this->session->flashdata('pur_added'); ?>',
                                type: 'success',
                                styling: 'bootstrap3'
                            });
                        });
                    </script>
                <?php endif; ?>

                <!-- TOMBOL TAMBAH -->
                <?php if ($this->session->userdata('level') === 'pemilik'): ?>
                    <a href="<?= base_url('example/form_purchase') ?>" class="btn btn-success" style="margin-bottom:13px">
                        <span class="fa fa-plus"></span> Tambah Pembelian
                    </a>
                <?php endif; ?>

                <!-- FORM CARI -->
                <form action="<?= base_url('example/cari_pembelian'); ?>" method="POST">
                    <label>Supplier</label>
                    <select name="supplier" class="form-control" required>
                        <option value="semua">Semua</option>
                        <?php 
                        $supplier = $this->db->get('table_sup')->result();
                        foreach($supplier as $s): ?>
                            <!-- pakai NAMA karena transaksi simpan nama -->
                            <option value="<?= $s->nama_pemasok ?>">
                                <?= $s->nama_pemasok ?>
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <br>

                    <label>Tanggal</label>
                    <input type="date" name="waktu" class="form-control" required>

                    <br>
                    <button type="submit" class="btn btn-primary">Cari</button>
                </form>

                <br>

                <!-- JUDUL LAPORAN -->
                <div class="text-center">
                    <h3>Laporan Pembelian</h3>
                    <?php if(isset($cari)): ?>
                        <h4>Periode : <?= date('d F Y', strtotime($start)); ?></h4>
                        Apotek Bunda<br>
                        Brang Bara<br>
                        Sumbawa - NTB
                    <?php endif; ?>
                </div>

                <br>

                <!-- TABEL -->
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No Transaksi</th>
                            <th>Tanggal</th>
                            <th>Nama Obat</th>
                            <th>Satuan</th>
                            <th>Harga (Rp)</th>
                            <th>Banyak</th>
                            <th>Total</th>
                            <th>Supplier</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $no = 1; foreach($table_purchase as $p): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $p->ref ?></td>
                            <td><?= date('j F Y', strtotime($p->tgl_beli)) ?></td>
                            <td><?= $p->nama_obat ?></td>
                            <td><?= $p->unit ?? '-' ?></td>
                            <td>Rp. <?= number_format($p->harga_beli) ?></td>
                            <td><?= $p->banyak ?></td>
                            <td>Rp. <?= number_format($p->subtotal) ?></td>
                            <td><?= $p->nama_pemasok ?></td>
                            <td class="text-center">
                                <?= anchor(
                                    'example/remove_purchase/'.$p->id_pembelian,
                                    '<button class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i>
                                     </button>',
                                    'onclick="return confirm(\'Hapus data ini?\')"'
                                ); ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
