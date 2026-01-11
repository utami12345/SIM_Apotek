<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Daftar Obat</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <?php if($this->session->userdata('level') === 'pemilik'): ?>
                    <a href="<?= base_url('example/form_med') ?>" class="btn btn-success" style="margin-bottom:13px">
                        <span class="fa fa-plus"></span> Tambah Obat
                    </a>
                <?php endif; ?>

                <table id="datatable-obat" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th style="width:80px;">No</th>
                            <th>Nama Obat</th>
                            <th>Kategori</th>
                            <th>Satuan</th>
                            <th>Total Stok</th>
                            <th>Detail</th>

                            <?php if($this->session->userdata('level') === 'pemilik'): ?>
                                <th>Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sn = 1; ?>
                        <?php foreach($table_med as $m): ?>
                        <tr>
                            <td><?= $sn++; ?></td>
                            <td><?= $m->nama_obat ?></td>
                            <td><?= $m->nama_kategori ?></td>
                            <td><?= $m->unit ?></td>
                            <td><?= $m->total_stok ?></td>

                            <td style="text-align:center;">
                                <a href="<?= base_url('example/detail_obat/'.$m->id_obat) ?>" 
                                   class="btn btn-primary btn-xs">
                                    <span class="fa fa-eye"></span>
                                </a>
                            </td>

                            <?php if($this->session->userdata('level') === 'pemilik'): ?>
                            <td style="text-align:center;">
                                <?= anchor(
                                    'example/edit_form_med/'.$m->id_obat,
                                    '<button class="btn btn-info btn-xs"><span class="fa fa-pencil"></span></button>'
                                ); ?>
                                <?= anchor(
                                    'example/remove_med/'.$m->id_obat,
                                    '<button class="btn btn-danger btn-xs"><span class="fa fa-trash"></span></button>',
                                    'onclick="return confirm(\'Yakin ingin menghapus?\')"'
                                ); ?>
                            </td>
                            <?php endif; ?>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
