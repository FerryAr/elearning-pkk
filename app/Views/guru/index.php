<script>
  <?php
    if(!empty($_SESSION['msg'])) {
      echo "alert('".$_SESSION['msg']."')";
    }
  ?>
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
           <h1 class="m-0 text-dark"><?= $page ?></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?= $page ?></li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-6 mb-3">
          <a role="button" data-toggle="modal" data-target="#create" class="btn btn-primary btn-md">Create Data</a>
          <button type="button" class="btn btn-secondary btn-md" data-toggle="modal" data-target="#import">Import Data</button>
          <a href="<?= base_url('guru/export_guru') ?>" class="btn btn-success btn-md">Export Data</a>
          </div>
          <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-info btn-md" id="guru-not-user">Tampilkan Semua Guru</button>
          </div>
        </div>
        <table class="table table-bordered" id="masterguru">
            <thead>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1; ?>
                <?php foreach ($data_guru as $g) : ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $g->nip ?></td>
                    <td><?= $g->nama_guru ?></td>
                    <td><?= $g->alamat ?></td>
                    <th><?= $g->email ?></th>
                    <td><?= $g->no_telp ?></td>
                    <td>
                        <a role="button" href="<?= base_url('guru/edit') ?>" data-id="<?= $g->id ?>" data-toggle="modal" data-target="#edit" class="btn btn-md btn-warning">Edit</a>
                        <a role="button" href="<?= base_url('guru/delete') ?>" class="btn btn-md btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Guru</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
        </table>
        <div class="modal fade" id="import">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Import Data Guru</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= base_url('guru/import_excel') ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="file_excel">File</label>
                                <input type="file" class="form-control" name="fileexcel" id="file_excel">
                            </div>
                            <div class="form-group">
                                <button type="submit" name="submnit" class="btn btn-primary">Import</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <script src="<?php echo base_url();?>/assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?php echo base_url();?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Bootstrap 4 -->
<script src="<?php echo base_url();?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
  <script src="<?php echo base_url();?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url();?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
  $('#masterguru').DataTable({
    processing: true,
    "paging": true,
    "lengthChange": false,
    "searching": true,
    "ordering": true,
    "info": true,
    //"autoWidth": true,
    //"responsive": true,
    "order": [[ 0, "asc" ]],
    buttons: [
      'copy', 'csv', 'excel', 'pdf', 'print'
    ],
  });
</script>