  <div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Obat Habis</h2>
        <ul class="nav navbar-right panel_toolbox">
          <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
          </li>
          
          </li>
          <li><a class="close-link"><i class="fa fa-close"></i></a>
          </li>
        </ul>
        <div class="clearfix">
        </div>
      </div>
    
        
        <table id="datatable" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nama Obat</th>
              <th>Kategori</th>
              <th>Stok</th>
              <th>Satuan</th>
              
            </tr>
          </thead>
          <tbody>

            <?php foreach($table_stock as $os){ ?>
            <tr>
              <td><?php echo $os->nama_obat ?></td>
              <td><?php echo $os->nama_kategori ?></td>
              <td><?php echo $os->total_stok ?></td>
              <td><?php echo $os->unit ?></td>
              
            </tr>

            <?php } ?>
          </tbody>

        </table>
    </div>
  </div>
</div>
  </div>


<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Obat Hampir Habis</h2>
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
        <p>Obat dengan stok kurang dari sama dengan 5</p>
        
        <table id="nambah" class="table table-striped table-bordered">
          <thead>
            <tr>
              <th>Nama Obat</th>
              <th>Kategori</th>
              <th>Stok</th>
              <th>Satuan</th>
              
            </tr>
          </thead>
          <tbody>

            <?php foreach($table_alstock as $as){ ?>
            <tr>
              <td><?php echo $as->nama_obat ?></td>
              <td><?php echo $as->nama_kategori ?></td>
              <td><?php echo $as->total_stok ?></td>
              <td><?php echo $as->unit ?></td>
              
            </tr>

            <?php } ?>
          </tbody>

        </table>
    </div>
  </div>
</div>



  </div>






