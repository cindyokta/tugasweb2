    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->

        <?php $this->load->view('admin/_partials/navbar'); ?>
        
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <?php echo $this->session->flashdata('message'); ?>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">Admin</h6>
            </div>
            <div class="card-body">
              <a href="<?= base_url('admin/tambah_admin')?>" class="btn btn-primary mb-3">tambah admin</a>
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nama Lengkap</th>
                      <th>Username</th>
                      <th>Email</th>
                      <th>Aksi</th>
                     
                    </tr>
                  </thead>
                  <tbody>
                    <?php foreach($admin as $row): ?>
                    <tr <?php echo ($row['Id_Admin'] == $this->session->userdata('id_admin')) ? "hidden" : "" ?>>
                      <td><?= $row['Nama_Lengkap'] ?></td>
                      <td><?= $row['User_Name'] ?></td>
                      <td><?= $row['Email'] ?></td>
                      <td>
                        <a class="btn btn-success" href="<?= base_url('admin/ubah_admin/'.$row['Id_Admin'])?>">ubah</a>
                        <a class="btn btn-danger" href="<?= base_url('admin/hapus_admin/'.$row['Id_Admin'])?>" onclick="return confirm('apakah anda yakin?')">hapus</a>
                      </td>
                    </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->