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
    <!--**********************************
            Content body start
        ***********************************-->
    <div class="content-body">
      <div class="container-fluid">
        <div class="row justify-content-md-center">
            <div class="col-lg-6">
                <!-- row -->
                <div class="card">
                <div class="card-header">
                    IRIS a Product of Arrowgo-Logistics Inc.
                </div>
                <div class="card-body">
                    <h5 class="card-title">Outgoing Pallet</h5>
                    <p class="card-text">Create Pallet Dispatching Transaction</p>
                        <div class="form-validation">
                            <form action="outgoing_pallet_proc" method="post" class="needs-validation" novalidate>
                            <div class="form-group">

                                <!-- Fields Required
                                - Outbound Reference No.
                                - Transaction Date
                                - Driver
                                - Checker
                                - Pallet Type
                                - Qty
                                - Remarks
                                -->
                                 <!-- Origin/Destination -->
                                 <div class="row mt-1">
                                    <div class="col-lg-6 col-md-6">
                                        <label class="col-form-label text-primary font-weight-bold text-uppercase" for="origin">Enter Origin
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="origin" id="origin" placeholder="Enter Origin" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label class="col-form-label text-primary font-weight-bold text-uppercase" for="destination">Enter Destination
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="destination" id="destination" placeholder="Enter Destination" required>
                                    </div>
                                </div>

                                 <!-- Driver -->
                                 <div class="row mt-1">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label class="col-form-label text-primary font-weight-bold text-uppercase" for="driver">Driver
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="driver" id="driver" placeholder="Enter Driver" required>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label class="col-form-label text-primary font-weight-bold text-uppercase" for="plate_no">Plate No.
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="plate_no" id="driver" placeholder="Enter Plate No." required>
                                    </div>
                                </div>
                                
                                 <!-- Forwarder -->
                                 <div class="row mt-1">
                                    <div class="col-lg-12 col-md-12">
                                        <label class="col-form-label text-primary font-weight-bold text-uppercase" for="trucker">Forwarder/Trucker
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="trucker" id="trucker" placeholder="Enter Name of Trucker/Forwarder" required>
                                    </div>
                                </div>

                                <!-- Outbound Reference No. -->
                                <div class="row mt-1">
                                    <div class="col-lg-6 col-md-6">
                                        <label class="col-form-label text-primary font-weight-bold text-uppercase" for="inb_reference_no">Enter Delivery Receipt Reference No.
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="inb_reference_no" id="inb_reference_no" placeholder="Enter Outboung Reference No. / Delivery Receipt Reference No." required>     
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <label class="col-form-label text-primary font-weight-bold text-uppercase" for="date_received">Date Dispatched
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="date" class="form-control" name="date_received" id="date_received" placeholder="Select Transaction Date" required>     
                                    </div>
                                </div>

                                <!-- Pallet Type-->
                                <div class="row mt-1">
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="pallet_type" class="col-form-label text-uppercase text-primary font-weight-bold">Select Pallet Type
                                        <span class="text-danger">*</span>
                                        </label>
                                        <select name="pallet_type" id="pallet_type" class="form-control" required>
                                            <option value="">Select Pallet</option>
                                            <option value="PL-01">Plastic Pallet (1mx1m)</option>
                                            <option value="PL-02">SMY Plastic Pallet</option>
                                            <option value="PL-03">RPPC/Red Pallet</option>
                                            <option value="PL-04">Loscam</option>
                                            <option value="PL-05">Sancar</option>
                                            <option value="PL-06">Others(please indicate in the remarks)</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6">
                                        <label for="qty" class="col-form-label text-uppercase text-primary font-weight-bold">Received Quantity
                                        <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" name="qty" id="qty" placeholder="Enter Quantity to Dispatch" required>
                                    </div>
                                </div>

                                <!-- Remarks -->
                                <div class="row mt-1">
                                    <div class="col-lg-12 col-md-12">
                                        <label class="col-form-label text-primary font-weight-bold text-uppercase" for="remarks">Remarks
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="remarks" id="remarks" placeholder="Add some remarks if applicable. If none put N/A" required>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="row mt-3">
                                    <div class="col-lg-12">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block">Confirm Transaction</button>
                                    </div>
                                </div>
                            </div>            
                            </form>
                        </div>
                </div>
            </div>
            <div class="card-footer text-muted text-center">
                <?php echo "Today is ". date('M-d-Y'); ?>
            </div>
            </div>
        </div>
      </div>
  </div>



  <!--**********************************
        Main wrapper end
    ***********************************-->

  <!--**********************************
        Scripts
    ***********************************-->
  <!-- Required vendors -->
  <!-- Required vendors -->
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
      $('#view_report_table').DataTable({
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
  <script>
    (function() {
      'use strict'

      // Fetch all the forms we want to apply custom Bootstrap validation styles to
      var forms = document.querySelectorAll('.needs-validation')

      // Loop over them and prevent submission
      Array.prototype.slice.call(forms)
        .forEach(function(form) {
          form.addEventListener('submit', function(event) {
            if (!form.checkValidity()) {
              event.preventDefault()
              event.stopPropagation()
            }

            form.classList.add('was-validated')
          }, false)
        })
    })()
  </script>
</body>

</html>