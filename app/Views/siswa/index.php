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
                    <a href="<?= base_url('siswa/export_siswa') ?>" class="btn btn-success btn-md">Export Data</a>
                </div>
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-info btn-md" id="siswa-not">Tampilkan Semua Siswa</button>
                </div>
            </div>
            <!-- /.row (main row) -->

            <table class="table table-bordered" id="mastersiswa">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    foreach ($siswa as $s) : ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $s->nis ?></td>
                            <td><?= $s->first_name ?></td>
                            <td><?= $s->last_name ?></td>
                            <td><?= $s->nama_kelas ?></td>
                            <td><?= $s->nama_jurusan ?></td>
                            <td><?= $s->email ?></td>
                            <td><?= $s->alamat ?></td>
                            <td><?= $s->tanggal_lahir ?></td>
                            <td>
                                <a href="<?= base_url('siswa/edit/') . $s->nis ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('siswa/delete/') . $s->nis ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Tanggal Lahir</th>
                        <th>Action</th>
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
                        <form>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="nis">NIS</label>
                                    <input type="text" class="form-control" id="nis" name="nis" placeholder="NIS">
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
                                    <label for="kelas">Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas">
                                        <option selected>Pilih Kelas</option>
                                        <?php foreach ($kelas as $k) : ?>
                                            <option value="<?= $k->id ?>"><?= $k->nama_kelas ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="3"></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="tanggal_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir">
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary" id="submit-create">Simpan</button>
                            </div>
                        </form>

                    </div>

                </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<script src="<?php echo base_url(); ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url(); ?>/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url(); ?>/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/jszip/jszip.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/pdfmake/pdfmake.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/pdfmake/vfs_fonts.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="<?php echo base_url(); ?>/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
<script>
    $(document).ready(function() {
        $('#mastersiswa').DataTable({
            processing: true,
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            //"autoWidth": true,
            //"responsive": true,
            "order": [
                [0, "asc"]
            ],
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
        });
        $('#submit-create').on('click', function() {
            let nis = $('#nis').val();
            let first_name = $('#first_name').val();
            let last_name = $('#last_name').val();
            let kelas = $('#kelas option:selected').val();
            let email = $('#email').val();
            let alamat = $('#alamat').val();
            let tanggal_lahir = $('#tanggal_lahir').val();
            $.ajax({
                type: "POST",
                url: "<?= base_url('siswa/create') ?>",
                data: {
                    nis: nis,
                    first_name: first_name,
                    last_name: last_name,
                    kelas: kelas,
                    email: email,
                    alamat: alamat,
                    tanggal_lahir: tanggal_lahir
                },
                dataType: "json",
                success: function(response) {
                    $('#create').modal('hide');
                    $('#nis').val('');
                    $('#first_name').val('');
                    $('#last_name').val('');
                    $('#kelas').val('');
                    $('#email').val('');
                    $('#alamat').val('');
                    $('#tanggal_lahir').val('');
                    $.each(response, function(key, value) {
                        alert(value);
                    });
                    //$('#mastersiswa').DataTable().ajax.reload();
                }, error: function(xhr, status, error) {
                    alert(xhr.responseText);
                }
            });
        });
    });
</script>