<!DOCTYPE html>
<html lang="en">
<head>
<?php
  require_once 'webheader.html';
?>
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">

<?php
  require_once 'preload.html';
  require_once 'navbar.html';
  require_once 'mainsidebar.html';
?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Main row -->
        <div class="row">

          <div class="col-sm-8">
            <div class="form-group">
              <select id="report_year" class="form-control">
              </select>
            </div>
          </div>

          <!-- Left col -->
          <div class="col-md-8">

            <!-- TABLE: LATEST ORDERS -->
            <div class="card">
              <div class="card-header border-transparent">
                <h3 class="card-title">จำนวนเด็กของหน่วยงานเฉลี่ยต่อวันทั้งปีงบ 2564 </h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" onClick="exportTableToExcel('datatb')">
                    <i class="fas fa-download"></i>
                  </button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table m-0" id="datatb">
                    <thead>
                    <tr>
                      <th>หน่วยงาน</th>
                      <th>ชาย</th>
                      <th>หญิง</th>
                      <th>รวม</th>
                    </tr>
                    </thead>
                    <tbody id="tableBody">
                    </tbody>
                  </table>
                </div>
                <!-- /.table-responsive -->
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <!-- <footer class="main-footer">
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer> -->
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.js"></script>

<!-- PAGE PLUGINS -->
<!-- jQuery Mapael -->
<script src="plugins/jquery-mousewheel/jquery.mousewheel.js"></script>
<script src="plugins/raphael/raphael.min.js"></script>
<script src="plugins/jquery-mapael/jquery.mapael.min.js"></script>
<script src="plugins/jquery-mapael/maps/usa_states.min.js"></script>
<!-- ChartJS -->
<script src="plugins/chart.js/Chart.min.js"></script>

<script src="dist/js/demo.js"></script>
<script src="js/utils.js"></script>
<script src="controller/count_avg_stat.js?v=<?php echo filemtime('controller/count_avg_stat.js'); ?>"></script>

<script src="js/switchthemecheckbox.js"></script>
</body>
</html>
