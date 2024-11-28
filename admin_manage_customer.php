<?php
require_once 'includes/load.php';

/**
 * Check each script if login is authenticated or if session is already expired
 */



// either new or old, it should live at most for another hour

if (is_login_auth()) {

  /** SESSION BASE TO TIME TODAY */

  if (is_session_expired()) {
    $_SESSION['msg'] = "<b>SESSION EXPIRED:</b> Please Login Again.";
    $_SESSION['msg_type'] = "danger";

    unset($_SESSION['user_id']);
    unset($_SESSION['name']);
    unset($_SESSION['user_type']);
    unset($_SESSION['user_status']);

    unset($_SESSION['login_time']);

    /**TIME TO DAY + 315360000 THAT EQUIVALENT TO 10 YEARS*/

    redirect("login", false);
  }
} else {
  redirect("login", false);
}

?>
<?php include 'views/header.php'; ?>
<?php include 'views/nav_header.php'; ?>
<?php include 'views/top_bar.php'; ?>
<?php

$tb_customer = $db->query('SELECT * FROM tb_customer ORDER BY id DESC')->fetch_all();

?>


<div class="row">
  <div class="col-lg-12 col-md-12 col-sm-12">
    <?php
    if (isset($_SESSION['msg'])) {
    ?>
      <script>
        swal({

          title: "<?php echo $_SESSION['msg_heading']; ?>",
          text: "<?php echo $_SESSION['msg']; ?>",
          icon: "<?php echo $_SESSION['msg_type']; ?>",
          button: "Close",

        });
      </script>

    <?php

      unset($_SESSION['msg']);
      unset($_SESSION['msg_type']);
      unset($_SESSION['msg_heading']);
    }
    ?>
  </div>
</div>

<body>

  <!--*******************
        Preloader start
    ********************-->

  <div id="preloader">
    <div class="loader"></div>
  </div>

  <div id="main-wrapper">

    <div class="content-body">
      <div class="container-fluid">
        <!-- row -->

        <div class="row">
          <div class="col-lg-12">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Manage Customer</h4>
              </div>
              <div class="card-body">

                <div class="table-responsive">
                  <table id="example4" class="display">
                    <!-- <table class="table table-bordered table-responsive-sm display" id="view_asn_table"> -->
                    <thead>
                      <tr>
                        <th class="align-middle text-center  font-weight-bold ">ID</th>
                        <th class="align-middle text-center  font-weight-bold ">Ship to Code</th>
                        <th class="align-middle text-center  font-weight-bold ">Customer Name</th>
                        <th class="align-middle text-center  font-weight-bold ">Address</th>
                        <th class="align-middle text-center  font-weight-bold ">Shelf Life</th>
                        <th class="align-middle text-center  font-weight-bold ">Window Time</th>
                        <th class="align-middle text-center  font-weight-bold ">Pallet Requirement</th>
                        <th class="align-middle text-center  font-weight-bold ">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($tb_customer as $arr_key => $arr_val) { ?>
                        <tr>
                          <td class="align-middle text-center"><?php echo $arr_val['id']; ?></td>
                          <td class="align-middle text-center"><?php echo $arr_val['ship_to_code']; ?></td>
                          <td class="align-middle text-center"><?php echo $arr_val['ship_to_name']; ?></td>
                          <td class="align-middle text-center"><?php echo $arr_val['ship_to_address']; ?></td>
                          <td class="align-middle text-center"><?php echo $arr_val['req_shelf_life']*100 . "%"; ?></td>
                          <td class="align-middle text-center"><?php echo $arr_val['window_time']; ?></td>
                          <td class="align-middle text-center"><?php echo $arr_val['pallet_requirement']; ?></td>
                          <td>
                            <div class="d-flex">
                              <a data-toggle="modal" data-target="#update_details<?php echo $arr_val['id']; ?>" class="btn btn-info shadow btn-xs sharp" title="Update"><i class="fa-solid fa-pen-to-square"></i></a>
                            </div>												
						  </td>
                         
                          <!-- MODAL FOR PICKING START-->
                          <div id="update_details<?php echo $arr_val['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
                            <div role="document" class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h4 id="exampleModalLabel" class="modal-title">Update Customer Details</h4>

                                </div>
                                <div class="modal-body">
                                  <form action="update_customer_details" method="post">
                                    <div class="form-group">
                                      <div class="mt-1">
                                        <input type="hidden" class="form-control" name="db_id" id="db_id" value="<?php echo $arr_val['id']; ?>">
                                      </div>

                                      <!-- Ship to Code-->
                                      <div class="mt-1">
                                        <label for="ship_to_code" class="form-control-label text-uppercase text-primary font-weight-bold">Ship to Code</label>
                                        <input type="text" class="form-control" name="ship_to_code" id="ship_to_code" value="<?php echo $arr_val['ship_to_code']; ?>">
                                      </div>

                                      <!--Customer Name-->
                                      <div class="mt-1">
                                        <label for="customer_name" class="form-control-label text-uppercase text-primary font-weight-bold">Customer Name</label>
                                        <input type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $arr_val['ship_to_name']; ?>">
                                      </div>

                                      <!-- Address-->
                                      <div class="mt-1">
                                        <label for="address" class="form-control-label text-uppercase text-primary font-weight-bold">Address</label>
                                        <input type="text" class="form-control" name="address" id="address" value="<?php echo $arr_val['ship_to_address']; ?>">
                                      </div>

                                      <!-- Pallet-->
                                      <div class="mt-1">
                                        <label for="pallet_type" class="form-control-label text-uppercase text-primary font-weight-bold">Pallet Requirement</label>
                                        <input type="text" class="form-control" name="pallet_type" id="pallet_type" value="<?php echo $arr_val['pallet_requirement']; ?>">
                                      </div>

                                      <!-- Window Time-->
                                      <div class="mt-1">
                                        <label for="window_time" class="form-control-label text-uppercase text-primary font-weight-bold">Window Time</label>
                                        <input type="text" class="form-control" name="window_time" id="window_time" value="<?php echo $arr_val['window_time']; ?>">
                                      </div>

                                      <!-- Window Time-->
                                      <div class="mt-1">
                                        <label for="req_shelf_life" class="form-control-label text-uppercase text-primary font-weight-bold">Required Shelf Life</label>
                                        <input type="number" class="form-control" name="req_shelf_life" id="req_shelf_life" min="0" step=".01" value="<?php echo $arr_val['req_shelf_life']; ?>">
                                      </div>


                                    </div>
                                    <div class="d-grid gap-2 mx-auto mt-2">
                                        <button type="submit" class="btn btn-success">Update Details</button>
                                    </div>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                          <!-- End Modal -->
                         
                        </tr>
                      <?php
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  </div>


  <!--**********************************
        Scripts
    ***********************************-->

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="./vendor/global/global.min.js"></script>
  <script src="./vendor/chart.js/Chart.bundle.min.js"></script>
  <script src="./vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
  <!-- Apex Chart -->
  <script src="./vendor/apexchart/apexchart.js"></script>

  <!-- Datatable -->
  <script src="./vendor/datatables/js/jquery.dataTables.min.js"></script>
  <script src="./js/plugins-init/datatables.init.js"></script>

  <script src="vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>

  <script src="./js/custom.min.js"></script>
  <script src="./js/dlabnav-init.js"></script>
  <script src="./js/demo.js"></script>
  <script src="./js/styleSwitcher.js"></script>
  <script>
    $(document).ready(function() {
      $('#view_asn_table').DataTable({
        order: [
          [0, "desc"]
        ],
        lengthMenu: [
          [5],
          [5]
        ]
      });
    });
  </script>
</body>

</html>