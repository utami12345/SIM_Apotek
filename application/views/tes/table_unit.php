<div class="row">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Satuan Obat</h2>
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <!-- NOTIFIKASI -->
                <?php if($this->session->flashdata('unit_added')): ?>
                <script>
                    $(document).ready(function(){
                        new PNotify({
                            title: 'Berhasil',
                            text: '<?= $this->session->flashdata('unit_added'); ?>',
                            type: 'success',
                            styling: 'bootstrap3'
                        });
                    });
                </script>
                <?php endif; ?>

                <!-- TOMBOL TAMBAH (PEMILIK SAJA) -->
                <?php if($this->session->userdata('level') === 'pemilik'): ?>
                    <a href="<?= base_url('example/form_unit') ?>" class="btn btn-success" style="margin-bottom:13px">
                        <span class="fa fa-plus"></span> Tambah Satuan
                    </a>
                <?php endif; ?>

                <table id="datatable-unit" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th style="width:80px;">No</th>
                            <th>Nama Satuan</th>

                            <?php if($this->session->userdata('level') === 'pemilik'): ?>
                                <th style="width:120px; text-align:center;">Aksi</th>
                            <?php endif; ?>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $sn = 1; ?>
                        <?php foreach($table_unit as $u): ?>
                        <tr>
                            <td><?= $sn++; ?></td>
                            <td><?= $u->unit; ?></td>

                            <?php if($this->session->userdata('level') === 'pemilik'): ?>
                            <td style="text-align:center;">
                                <?= anchor(
                                    'example/edit_form_unit/'.$u->id_unit,
                                    '<button class="btn btn-info btn-xs">
                                        <i class="fa fa-pencil"></i>
                                     </button>'
                                ); ?>
                                <?= anchor(
                                    'example/remove_unit/'.$u->id_unit,
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