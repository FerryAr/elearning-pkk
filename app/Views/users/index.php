<!-- Content Wrapper. Contains page content -->
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
        <!-- Small boxes (Stat box) -->
          <table id="masteruser" class="table table-striped table-bordered" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              <?php $i = 1; foreach($data_user as $ds) {?>
                <tr>
                  <td><?= $i++ ?></td>
                  <td><?= $ds->username ?></td>
                  <td><?= $ds->email ?></td>
                  <td><?= $ds->name?></td>
                  <td>
                    <a id="edit-btn" role="button" class="btn btn-primary btn-md" data-id="<?= $ds->id ?>" data-toggle="modal" data-target="#edit">Edit</a>
                    <a role="button" class="btn btn-danger btn-md" href="<?= base_url() ?>User/delete">Hapus</a>
                  </td>
                <?php } ?>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </tfoot>
        </table>
        <div class="modal fade" id="edit">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Edit Data</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <input type="text" name="user_id" id="user_id"/>
                  <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" class="form-control"/>
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control"/>
                  </div>
                  <div class="form-group">
                    <label for="role">Role</label>
                    <select class="form-control" id="role" name="role">
                      <?php foreach($role as $r) { ?>
                        <option value="<?= $r->id ?>"><?= $r->name ?></option>
                      <?php } ?>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="password">Password
                    </label>
                    <input type="password" id="password" name="password" class="form-control">
                  </div>
              </div>
              <div class="modal-footer">
              <input type="button" name="submit" class="btn btn-md btn-info" id="submit" value="Submit"/>
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
    $('#masteruser').DataTable({
      processing: true,
      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
      "paging": true,
      "order": [[ 1, 'asc' ]],
      "lengthChange": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
    });
    $('#edit').on('show.bs.modal', function (e) {
      let id = $(e.relatedTarget).data("id");
      console.log(id);
      $.ajax({
        type: "POST",
        url: "<?= base_url('User/json') ?>",
        data: {
          'id':  id,
        },
        dataType: "json",
        success: function (response) {
          console.log(response)
          $.each(response, function (key, value) { 
             $('#user_id').val(id);
             $('#username').val(value.username);
             $('#email').val(value.email);
             let role_id = value.role_id;
             $('#role').val(role_id);
          });
        },
        error: function (request, status, error) {
          console.log(request.responseText);
        }
      });
    });
    $('#submit').on('click', function (e) {
      let id = $('#user_id').val();
      console.log(id);
      let username = $('#username').val();
      let email = $('#email').val();
      let password = $('#password').val();
      let role = $('#role option:selected').val();
      $.ajax({
        type: "POST",
        url: "<?= base_url() ?>/User/edit/"+id,
        data: {
          'id': id,
          'username': username,
          'email': email,
          'role': role,
          'password': password
        },
        dataType: "json",
        success: function (response) {
          console.log(response);
        },
        error: function (request, status, error) {
          console.log(request.responseText);
        }
      });
    });
  });

    // var t = $('#masteruser').DataTable({
    //       processing: true,
    //       serverSide: true,
    //       order: [],
    //       ajax:{
    //           url: '<?= base_url() ?>/user/json',
    //           method: "POST",
    //       },
    //       columnDefs: [
    //       {
    //         "targets": -1,
    //         "data": null,
    //         "orderable": false,
	  //   "defaultContent": "<a role='button' href='#' class='btn btn-info btn-md'>Edit</a> <a role='button' class='btn btn-danger btn-md' href='#'>Hapus</a>"
    //       },	
    //     ],
    //     "order": [[ 1, 'asc' ]],
    //     "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
    //     "paging": true,
    //   "lengthChange": false,
    //   "ordering": true,
    //   "info": true,
    //   "autoWidth": false,
    //   //"responsive": true,
    //   });
    //   $.fn.dataTable.ext.errMode = 'throw';
</script>
 
