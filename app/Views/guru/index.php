<script>
  <?php
    if(!empty($_SESSION['msg'])) {
      ?>
        alert('<?php echo $_SESSION['msg']; ?>');
      <?php
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
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody >
                <?php $i = 1; ?>
                <?php foreach ($data_guru as $g) : ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $g->nip ?></td>
                    <td><?= $g->first_name ?></td>
                    <td><?= $g->last_name ?></td>
                    <td><?= $g->alamat ?></td>
                    <th><?= $g->email ?></th>
                    <td><?= $g->no_telp ?></td>
                    <td>
                        <a role="button" data-id="<?= $g->id ?>" data-toggle="modal" data-target="#edit" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></a>
                        <a role="button" href="<?= base_url('guru/delete') ?>?id=<?= $g->id ?>" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>NIP</th>
                    <th>Nama Depan</th>
                    <th>Nama Belakang</th>
                    <th>Alamat</th>
                    <th>Email</th>
                    <th>No. Telp</th>
                    <th>Aksi</th>
                </tr>
            </tfoot>
        </table>
        <div class="modal fade" id="create">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Create Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <div class="form-group">
                    <label for="nip">NIP</label>
                    <input type="text" class="form-control" id="nip" name="nip" placeholder="NIP">
                  </div>
                  <div class="form-group">
                    <label for="first_name">Nama Depan</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Nama Depan">
                  </div>
                  <div class="form-group">
                    <label for="last_name">Nama Belakang</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Nama Belakang">
                  </div>
                  <div class="form-group">
                    <label for="alamat">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <label for="no_telp">No. Telp</label>
                    <input type="text" class="form-control" id="no_telp" name="no_telp" placeholder="No. Telp">
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button id="submit-create" type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
        </div>
        <div class="modal fade" id="edit">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  <input type="hidden" id="id-edit" name="id">
                  <div class="form-group">
                    <label for="nip-edit">NIP</label>
                    <input type="text" class="form-control" id="nip-edit" name="nip" placeholder="NIP">
                  </div>
                  <div class="form-group">
                    <label for="first_name-edit">Nama Depan</label>
                    <input type="text" class="form-control" id="first_name-edit" name="first_name-edit" placeholder="Nama Depan">
                  </div>
                  <div class="form-group">
                    <label for="last_name-edit">Nama Belakang</label>
                    <input type="text" class="form-control" id="last_name-edit" name="last_name-edit" placeholder="Nama Belakang">
                  </div>
                  <div class="form-group">
                    <label for="alamat-edit">Alamat</label>
                    <textarea class="form-control" id="alamat-edit" name="alamat" rows="3"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email-edit" name="email" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <label for="no_telp-edit">No. Telp</label>
                    <input type="text" class="form-control" id="no_telp-edit" name="no_telp" placeholder="No. Telp">
                  </div>
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                    <button id="submit-edit" type="submit" class="btn btn-primary">Simpan</button>
                  </div>
                </form>
              </div>
            </div>
            <!-- /.modal-content -->
          </div>
        </div>
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
  $(document).ready(function () {
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
    $('#submit-create').on('click', function () {
      var nip = $('#nip').val();
      var first_name = $('#first_name').val();
      var last_name = $('#last_name').val();
      var alamat = $('#alamat').val();
      var email = $('#email').val();
      var no_telp = $('#no_telp').val();
      $.ajax({
        url: '<?= base_url('guru/create') ?>',
        type: 'POST',
        data: {
          'nip': nip,
          'first_name': first_name,
          'last_name': last_name,
          'alamat': alamat,
          'email': email,
          'no_telp': no_telp
        },
        success: function (response) {
          $('#create').modal('hide');
          $('#nip').val('');
          $('#nama_guru').val('');
          $('#alamat').val('');
          $('#email').val('');
          $('#no_telp').val('');
          $.each(response, function (key, value) { 
             alert(value);
          });
          window.location.reload();
        }
      });
    });
    $('#edit').on('show.bs.modal', function (e) {
      var id = $(e.relatedTarget).data('id');
      console.log(id);

      $.ajax({
        url: '<?= base_url('guru/json') ?>',
        type: 'POST',
        data: {
          'id': id
        },
        dataType: 'json',
        success: function (response) {
          console.log(response);
          $.each(response, function (key, value) {
            $('#nip-edit').val(value.nip);
            $('#first_name-edit').val(value.first_name);
            $('#last_name-edit').val(value.last_name);
            $('#alamat-edit').val(value.alamat);
            $('#email-edit').val(value.email);
            $('#no_telp-edit').val(value.no_telp);
            $('#id-edit').val(id);
          });
        }
      });
    });
    $('#submit-edit').on('click', function () {
      let id = $('#id-edit').val();
      let nip = $('#nip-edit').val();
      let first_name = $('#first_name-edit').val();
      let last_name = $('#last_name-edit').val();
      let alamat = $('#alamat-edit').val();
      let email = $('#email-edit').val();
      let no_telp = $('#no_telp-edit').val();
      $.ajax({
        type: "POST",
        url: "<?= base_url('guru/edit') ?>",
        data: {
          'id': id,
          'nip': nip,
          'first_name': first_name,
          'last_name': last_name, 
          'alamat': alamat,
          'email': email,
          'no_telp': no_telp
        },
        dataType: "json",
        success: function (response) {
          $('#edit').modal('hide');
          $('#nip-edit').val('');
          $('#nama_guru-edit').val('');
          $('#alamat-edit').val('');
          $('#email-edit').val('');
          $('#no_telp-edit').val('');
          $.each(response, function (key, value) {
            alert(value);
          });
          window.location.reload();
        },
        error: function (request, status, error) {
          alert(request.responseText);
        }
      });
    });
    $('#guru-not-user').on('click', function () {
      $.ajax({
        type: "POST",
        url: "<?= base_url('guru/json_read_all_guru') ?>",
        //data: "data",
        dataType: "json",
        success: function (response) {
          console.log(response);
          
          let i = 1;
          $('#masterguru').DataTable().clear();
          $.each(response, function (key, value) {
            $('#masterguru').DataTable().row.add([
              i,
              value.nip,
              value.first_name,
              value.last_name,
              value.alamat,
              value.email,
              value.no_telp,
              '<a role="button" data-id="'+value.id+'" data-toggle="modal" data-target="#edit" class="btn btn-sm btn-secondary"><i class="fas fa-edit"></i></a>' +
              ' <a role="button" href="<?= base_url('guru/delete') ?>?id='+value.id+'" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>'
            ]).draw(false);
            i++;
          });
          
        }
        
      });

    });
    
  });
</script>