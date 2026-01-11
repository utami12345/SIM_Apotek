<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Kategori Obat</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <!-- NOTIFIKASI -->
                <?php if($this->session->flashdata('cat_added')): ?>
                <script>
                    $(document).ready(function(){
                        new PNotify({
                            title: 'Berhasil',
                            text: '<?= $this->session->flashdata('cat_added'); ?>',
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                    });
                </script>
                <?php endif; ?>

                <!-- TOMBOL TAMBAH (PEMILIK SAJA) -->
                <?php if($this->session->userdata('level') === 'pemilik'): ?>
                    <a href="<?= base_url('example/form_cat') ?>" class="btn btn-success" style="margin-bottom:13px">
                        <span class="fa fa-plus"></span> Tambah Kategori
                    </a>
                <?php endif; ?>

                <table id="datatable-kategori" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th style="width:70px;">No</th>
                            <th>Nama Kategori</th>
                            <th>Deskripsi</th>

                            <?php if($this->session->userdata('level') === 'pemilik'): ?>
                                <th style="width:120px; text-align:center;">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sn = 1; ?>
                        <?php foreach($table_cat as $c): ?>
                        <tr>
                            <td><?= $sn++; ?></td>
                            <td><?= $c->nama_kategori; ?></td>
                            <td><?= $c->des_kat; ?></td>

                            <?php if($this->session->userdata('level') === 'pemilik'): ?>
                            <td style="text-align:center;">
                                <?= anchor(
                                    'example/edit_form_cat/'.$c->id_kat,
                                    '<button class="btn btn-info btn-xs">
                                        <i class="fa fa-pencil"></i>
                                     </button>'
                                ); ?>
                                <?= anchor(
                                    'example/remove_cat/'.$c->id_kat,
                                    '<button class="btn btn-danger btn-xs">
                                        <i class="fa fa-trash"></i>
                                     </button>',
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