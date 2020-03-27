<?php

include '../unitelections-info.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

?>


<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
    <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

    <title>New Unit Election | Unit Elections Administration | Tulpe Lodge - Order of the Arrow, BSA</title>

    <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
    <link rel="stylesheet" href="../style.css">

</head>

<body id="dashboard">
  <div class="wrapper">
    <?php include 'navbar.php'; ?>

    <main class="container-fluid">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">New Unit Election</h5>
            <form action="create-election-process.php" method="post">
              <div class="form-row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="unitNumber" class="required">Unit Number</label>
                    <input id="unitNumber" name="unitNumber" type="number" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="unitCommunity" class="required">Unit Community</label>
                    <input id="unitCommunity" name="unitCommunity" type="text" class="form-control" required>
                  </div>
                </div>
              </div>
              <div class="form-row">
                <div class="col-md-2">
                  <div class="form-group">
                    <label for="numRegisteredYouth"># of Registered Youth</label>
                    <input id="numRegisteredYouth" name="numRegisteredYouth" type="number" class="form-control">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="dateOfElection" class="required">Date of Unit Election</label>
                    <input id="dateOfElection" name="dateOfElection" type="date" class="form-control" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="form-group">
                    <label for="chapter" class="required">Chapter</label>
                    <select id="chapter" name="chapter" class="form-control" required>
                      <option></option>
                      <option value="TestChapter">TestChapter</option>
                      <option value="annawon">Annawon</option>
                      <option value="blackstone">Blackstone</option>
                      <option value="metacomet">Metacomet</option>
                      <option value="wampanoag">Wampanoag</option>
                    </select>
                  </div>
                </div>
              </div>
              <hr></hr>
              <h6 class="card-title">Unit Leader Information</h6>
              <div class="form-row">
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="sm_name" name="sm_name" type="text" class="form-control" placeholder="Name">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="sm_address_line1" name="sm_address_line1" type="text" class="form-control" placeholder="Address">
                  </div>
                  <div class="form-group">
                    <input id="sm_address_line2" name="sm_address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)">
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="sm_city" name="sm_city" type="text" class="form-control" placeholder="City">
                  </div>
                  <div class="form-row">
                    <div class="col-md-4">
                      <div class="form-group">
                        <input id="sm_state" name="sm_state" type="text" class="form-control" placeholder="State">
                      </div>
                    </div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <input id="sm_zip" name="sm_zip" type="text" class="form-control" placeholder="Zip">
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <input id="sm_email" name="sm_email" type="email" class="form-control" placeholder="Email">
                  </div>
                  <div class="form-group">
                    <input id="sm_phone" name="sm_phone" type="text" class="form-control" placeholder="Phone">
                  </div>
                </div>
              </div>
              <input type="submit" class="btn btn-primary" value="Submit">
            </form>
          </div>
        </div>
      </div>
    </main>
  </div>
    <?php include "../footer.php"; ?>

    <script src="../libraries/jquery-3.4.1.min.js"></script>
    <script src="../libraries/popper-1.16.0.min.js"></script>
    <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>

</body>

</html>
