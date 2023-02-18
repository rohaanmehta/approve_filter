<!DOCTYPE html>
<html lang="en">
<head>
    <?php include('header.php') ?>
</head> 
<?php 
$db = db_connect();
$total = $db->table('csv')->countAllResults();
$approved = $db->table('csv')->where('is_approved','1')->countAllResults();
$unapproved = $db->table('csv')->where('is_approved','0')->countAllResults();
?>
<body class="bg-default">
  <div class="main-content">
    <div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
      <div class="container-fluid">
        <!-- <h2 class="mb-5 text-white">Stats Card</h2> -->
        <div class="header-body">
          <div class="row">
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats btn-primary mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 style='color:#fff !important' class="card-title text-uppercase text-muted mb-0">Total Records</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $total ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-chart-pie"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span  style='color:#fff' class="text-nowrap">Since Begining</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats btn-primary mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 style='color:#fff !important' class="card-title text-uppercase text-muted mb-0">Total Approved</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $approved ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                        <i class="fas fa-chart-bar"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span  style='color:#fff' class="text-nowrap">Since Begining</span>
                  </p>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6">
              <div class="card card-stats btn-primary mb-4 mb-xl-0">
                <div class="card-body">
                  <div class="row">
                    <div class="col">
                      <h5 style='color:#fff !important' class="card-title text-uppercase text-muted mb-0">Total Unapproved</h5>
                      <span class="h2 font-weight-bold mb-0"><?= $unapproved ?></span>
                    </div>
                    <div class="col-auto">
                      <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                        <i class="fas fa-chart-pie"></i>
                      </div>
                    </div>
                  </div>
                  <p class="mt-3 mb-0 text-muted text-sm">
                    <span  style='color:#fff' class="text-nowrap">Since Begining</span>
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
  </div>
</body>
</html>