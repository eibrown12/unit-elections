<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

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

    <title>Edit Unit Election | Tulpe Lodge - Order of the Arrow, BSA</title>

    <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
    <link rel="stylesheet" href="../style.css">

</head>

<body id="dashboard">
  <div class="wrapper">
    <?php include 'navbar.php'; ?>

    <main class="container-fluid">

      <?php
      if (isset($_GET['accessKey'])) {
        if (preg_match("/^([a-z\d]){8}-([a-z\d]){4}-([a-z\d]){4}-([a-z\d]){4}-([a-z\d]){12}$/", $_GET['accessKey'])) {
          $accessKey = $_POST['accessKey'] = $_GET['accessKey'];
          ?>
          <section class="row">
              <div class="col-12">
                  <h2>Unit Election Administration</h2>
              </div>
          </section>
          <?php
          $getUnitElectionsQuery = $conn->prepare("SELECT * from unitElections where accessKey = ?");
          $getUnitElectionsQuery->bind_param("s", $accessKey);
          $getUnitElectionsQuery->execute();
          $getUnitElectionsQ = $getUnitElectionsQuery->get_result();
          if ($getUnitElectionsQ->num_rows > 0) {
            //print election info
            ?>
            <?php $getUnitElections = $getUnitElectionsQ->fetch_assoc(); ?>
            <?php if ($getUnitElections['status'] == "closed") { ?>
              <div class="card mb-3">
                <div class="card-body">
                  <p>This election has ended.</p>
                  <form action="set-status.php" method="POST">
                    <input type="hidden" value="<?php echo $getUnitElections['id']; ?>" name="unitElectionId" id="unitElectionId">
                    <input type="hidden" value="open" name="unitElectionStatus" id="unitElectionStatus">
                    <input type="submit" value="Re-Open Election" class="btn btn-sm btn-outline-danger">
                  </form>
                </div>
              </div>
            <?php } ?>
            <div class="card mb-3">
              <div class="card-body">
                <h3 class="card-title d-inline-flex">Edit Unit Election Information</h3>
                <form action="edit-election-process.php" method="post">
                  <input type="hidden" id="unitId" name="unitId" value="<?php echo $getUnitElections['id']; ?>">
                  <input type="hidden" id="accessKey" name="accessKey" value="<?php echo $getUnitElections['accessKey']; ?>">
                  <div class="form-row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="unitNumber" class="required">Unit Number</label>
                        <input id="unitNumber" name="unitNumber" type="number" class="form-control" value="<?php echo $getUnitElections['unitNumber']; ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="unitCommunity" class="required">Unit Community</label>
                        <input id="unitCommunity" name="unitCommunity" type="text" class="form-control" value="<?php echo $getUnitElections['unitCommunity']; ?>" required>
                      </div>
                    </div>
                  </div>
                  <div class="form-row">
                    <div class="col-md-2">
                      <div class="form-group">
                        <label for="numRegisteredYouth"># of Registered Youth</label>
                        <input id="numRegisteredYouth" name="numRegisteredYouth" type="number" class="form-control" value="<?php echo $getUnitElections['numRegisteredYouth']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <label for="dateOfElection" class="required">Date of Unit Election</label>
                        <input id="dateOfElection" name="dateOfElection" type="date" class="form-control" value="<?php echo $getUnitElections['dateOfElection']; ?>" required>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="form-group">
                        <label for="chapter" class="required">Chapter</label>
                        <select id="chapter" name="chapter" class="custom-select" required>
                          <option></option>
                          <option value="TestChapter" <?php echo ($getUnitElections['chapter'] == 'TestChapter' ? 'selected' : ''); ?> >TestChapter</option>
                          <option value="annawon" <?php echo ($getUnitElections['chapter'] == 'Annawon' ? 'selected' : ''); ?> >Annawon</option>
                          <option value="blackstone" <?php echo ($getUnitElections['chapter'] == 'Blackstone' ? 'selected' : ''); ?> >Blackstone</option>
                          <option value="metacomet" <?php echo ($getUnitElections['chapter'] == 'Metacomet' ? 'selected' : ''); ?> >Metacomet</option>
                          <option value="wampanoag" <?php echo ($getUnitElections['chapter'] == 'Wampanoag' ? 'selected' : ''); ?> >Wampanoag</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <hr></hr>
                  <h6 class="card-title">Unit Leader Information</h6>
                  <div class="form-row">
                    <div class="col-md-3">
                      <div class="form-group">
                        <input id="sm_name" name="sm_name" type="text" class="form-control" placeholder="Name" value="<?php echo $getUnitElections['sm_name']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input id="sm_address_line1" name="sm_address_line1" type="text" class="form-control" placeholder="Address" value="<?php echo $getUnitElections['sm_address_line1']; ?>">
                      </div>
                      <div class="form-group">
                        <input id="sm_address_line2" name="sm_address_line2" type="text" class="form-control" placeholder="Address Line 2 (optional)" value="<?php echo $getUnitElections['sm_address_line2']; ?>">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input id="sm_city" name="sm_city" type="text" class="form-control" placeholder="City" value="<?php echo $getUnitElections['sm_city']; ?>">
                      </div>
                      <div class="form-row">
                        <div class="col-md-4">
                          <div class="form-group">
                            <input id="sm_state" name="sm_state" type="text" class="form-control" placeholder="State" value="<?php echo $getUnitElections['sm_state']; ?>">
                          </div>
                        </div>
                        <div class="col-md-8">
                          <div class="form-group">
                            <input id="sm_zip" name="sm_zip" type="text" class="form-control" placeholder="Zip" value="<?php echo $getUnitElections['sm_zip']; ?>">
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="form-group">
                        <input id="sm_email" name="sm_email" type="email" class="form-control" placeholder="Email" value="<?php echo $getUnitElections['sm_email']; ?>">
                      </div>
                      <div class="form-group">
                        <input id="sm_phone" name="sm_phone" type="text" class="form-control" placeholder="Phone" value="<?php echo $getUnitElections['sm_phone']; ?>" >
                      </div>
                    </div>
                  </div>
                  <a href="index.php" class="btn btn-secondary">Cancel</a>
                  <input type="submit" class="btn btn-primary" value="Save">
                </form>
              </div>
            </div>
            <?php
          } else {
            ?>
            <div class="alert alert-danger" role="alert">
              There are no elections in the database.
            </div>
            <?php
          }
        } else {
          //accesskey bad
          ?>
          <div class="alert alert-danger" role="alert">
            <h5 class="alert-heading">Invalid Access Key</h5>
            You have an invalid access key. Please use the personalized link provided in your email, or enter your access key below.
          </div>
          <div class="card col-md-6 mx-auto">
            <div class="card-body">
              <h5 class="card-title">Access Key </h5>
              <form action='' method="get">
                <div class="form-group">
                  <label for="accessKey">Access Key</label>
                  <input type="text" id="accessKey" name="accessKey" class="form-control" >
                </div>
                <input type="submit" class="btn btn-primary" value="Submit">
              </form>
            </div>
          </div>
          <?php
        }
      } else {
        //no accessKey
        ?>
        <div class="card col-md-6 mx-auto">
          <div class="card-body">
            <h5 class="card-title">Access Key </h5>
            <form action='' method="get">
              <div class="form-group">
                <label for="accessKey">Access Key</label>
                <input type="text" id="accessKey" name="accessKey" class="form-control" >
              </div>
              <input type="submit" class="btn btn-primary" value="Submit">
            </form>
          </div>
        </div>
        <?php
      }
    ?>
    </main>
  </div>
    <?php include "../footer.php"; ?>

    <script src="../libraries/jquery-3.4.1.min.js"></script>
    <script src="../libraries/popper-1.16.0.min.js"></script>
    <script src="../libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>

</body>

</html>
