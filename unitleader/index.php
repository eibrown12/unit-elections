<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
    <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

    <title>Unit Election Administration | Tulpe Lodge - Order of the Arrow, BSA</title>

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
      if ($_GET['status'] == 1) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Saved!</strong> Your data has been saved! Thanks!
            <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
    <?php } ?>
        <?php
          include '../unitelections-info.php';
          // Create connection
          $conn = new mysqli($servername, $username, $password, $dbname);
          // Check connection
          if ($conn->connect_error) {
              die("Connection failed: " . $conn->connect_error);
          }

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
                <div class="card mb-3">
                  <div class="card-body">
                    <a href="edit-unit-election.php?accessKey=<?php echo $accessKey; ?>" class="btn btn-sm btn-secondary mb-2 d-inline-flex float-right">edit</a>
                    <h3 class="card-title d-inline-flex">Scheduled Unit Election Information</h3>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Unit Number</th>
                            <th scope="col">Unit Community</th>
                            <th scope="col"># of Registered Youth</th>
                            <th scope="col">Chapter</th>
                            <th scope="col">Date of Election</th>
                            <th scope="col">Time of Election</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php $getUnitElections = $getUnitElectionsQ->fetch_assoc(); ?>
                          <tr>
                            <td><?php echo $getUnitElections['unitNumber']; ?></td>
                            <td><?php echo $getUnitElections['unitCommunity']; ?></td>
                            <td><?php echo $getUnitElections['numRegisteredYouth']; ?></td>
                            <td><?php echo $getUnitElections['chapter']; ?></td>
                            <td><?php echo date("m-d-Y", strtotime($getUnitElections['dateOfElection'])); ?></td>
                            <td>5pm to 8:59pm</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                    <h5 class="card-title">Unit Leader Information</h5>
                    <div class="row">
                      <div class="col-md-3">
                        <?php echo $getUnitElections['sm_name']; ?><br>
                      </div>
                      <div class="col-md-3">
                        <?php echo $getUnitElections['sm_address_line1']; ?><br>
                        <?php echo ($getUnitElections['sm_address_line2'] == "" ? '' : $getUnitElections['sm_address_line2'] . "<br>"); ?>
                        <?php echo $getUnitElections['sm_city']; ?>, <?php echo $getUnitElections['sm_state']; ?> <?php echo $getUnitElections['sm_zip']; ?><br>
                      </div>
                      <div class="col-md-3">
                        <?php echo $getUnitElections['sm_email']; ?><br>
                        <?php echo $getUnitElections['sm_phone']; ?><br>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="card mb-3">
                  <div class="card-body">
                    <h3 class="card-title">Eligible Scouts</h3>
                    <form action="add-scouts.php" method="post">
                      <input type="hidden" id="unitId" name="unitId" value="<?php echo $getUnitElections['id']; ?>">
                      <input type="hidden" id="accessKey" name="accessKey" value="<?php echo $accessKey; ?>">
                      <div id="eligible-scouts">
                        <?php $counterEligibleScouts = 0;
                        $eligibleScoutsQuery = $conn->prepare("SELECT * from eligibleScouts where unitId = ?");
                        $eligibleScoutsQuery->bind_param("s", $getUnitElections['id']);
                        $eligibleScoutsQuery->execute();
                        $eligibleScoutsQ = $eligibleScoutsQuery->get_result();
                        if ($eligibleScoutsQ->num_rows > 0) {
                          while ($eligibleScout = $eligibleScoutsQ->fetch_assoc()) {
                            if ($counterEligibleScouts > 0) { ?>
                              <hr></hr>
                            <?php } ?>
                            <input type="hidden" name="eligibleScoutId[<?php echo $counterEligibleScouts; ?>]" value="<?php echo $eligibleScout['id']; ?>">
                            <div class="form-row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="firstName[<?php echo $counterEligibleScouts; ?>]">First Name</label>
                                  <input type="text" id="firstName[<?php echo $counterEligibleScouts; ?>]" name="firstName[<?php echo $counterEligibleScouts; ?>]" class="form-control" value="<?php echo $eligibleScout['firstName']; ?>" >
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="lastName[<?php echo $counterEligibleScouts; ?>]">Last Name</label>
                                  <input type="text" id="lastName[<?php echo $counterEligibleScouts; ?>]" name="lastName[<?php echo $counterEligibleScouts; ?>]" class="form-control" value="<?php echo $eligibleScout['lastName']; ?>" >
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="dob[<?php echo $counterEligibleScouts; ?>]">Birthday</label>
                                  <input type="date" id="dob[<?php echo $counterEligibleScouts; ?>]" name="dob[<?php echo $counterEligibleScouts; ?>]" class="form-control" value="<?php echo $eligibleScout['dob']; ?>" >
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="rank[<?php echo $counterEligibleScouts; ?>]">Rank</label>
                                  <select class="custom-select" id="rank[<?php echo $counterEligibleScouts; ?>]" name="rank[<?php echo $counterEligibleScouts; ?>]">
                                    <option></option>
                                    <option value="first_class" <?php echo ($eligibleScout['rank'] == 'first_class' ? 'selected' : ''); ?> >First Class</option>
                                    <option value="star" <?php echo ($eligibleScout['rank'] == 'star' ? 'selected' : ''); ?> >Star</option>
                                    <option value="life" <?php echo ($eligibleScout['rank'] == 'life' ? 'selected' : ''); ?> >Life</option>
                                    <option value="eagle" <?php echo ($eligibleScout['rank'] == 'eagle' ? 'selected' : ''); ?> >Eagle</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>Address</label>
                                  <input id="address_line1[<?php echo $counterEligibleScouts; ?>]" name="address_line1[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="Address" value="<?php echo $eligibleScout['address_line1']; ?>" >
                                </div>
                                <div class="form-group">
                                  <input id="address_line2[<?php echo $counterEligibleScouts; ?>]" name="address_line2[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="Address Line 2 (optional)" value="<?php echo $eligibleScout['address_line2']; ?>">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>City, State, Zip</label>
                                  <input id="city[<?php echo $counterEligibleScouts; ?>]" name="city[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="City" value="<?php echo $eligibleScout['city']; ?>" >
                                </div>
                                <div class="form-row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <input id="state[<?php echo $counterEligibleScouts; ?>]" name="state[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="State" value="<?php echo $eligibleScout['state']; ?>" >
                                    </div>
                                  </div>
                                  <div class="col-md-8">
                                    <div class="form-group">
                                      <input id="zip[<?php echo $counterEligibleScouts; ?>]" name="zip[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="Zip" value="<?php echo $eligibleScout['zip']; ?>" >
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>Contact Information</label>
                                  <input id="email[<?php echo $counterEligibleScouts; ?>]" name="email[<?php echo $counterEligibleScouts; ?>]" type="email" class="form-control" placeholder="Email" value="<?php echo $eligibleScout['email']; ?>" >
                                </div>
                                <div class="form-group">
                                  <input id="phone[<?php echo $counterEligibleScouts; ?>]" name="phone[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="Phone" value="<?php echo $eligibleScout['phone']; ?>" >
                                </div>
                              </div>
                            </div>
                            <?php
                            $counterEligibleScouts++;
                          }
                        } else {
                          while ($counterEligibleScouts < 2) {
                            if ($counterEligibleScouts > 0) { ?>
                              <hr></hr>
                            <?php } ?>
                            <input type="hidden" name="eligibleScoutId[<?php echo $counterEligibleScouts; ?>]" value="new">
                            <div class="form-row">
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="firstName[<?php echo $counterEligibleScouts; ?>]">First Name</label>
                                  <input type="text" id="firstName[<?php echo $counterEligibleScouts; ?>]" name="firstName[<?php echo $counterEligibleScouts; ?>]" class="form-control" >
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="lastName[<?php echo $counterEligibleScouts; ?>]">Last Name</label>
                                  <input type="text" id="lastName[<?php echo $counterEligibleScouts; ?>]" name="lastName[<?php echo $counterEligibleScouts; ?>]" class="form-control" >
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="dob[<?php echo $counterEligibleScouts; ?>]">Birthday</label>
                                  <input type="date" id="dob[<?php echo $counterEligibleScouts; ?>]" name="dob[<?php echo $counterEligibleScouts; ?>]" class="form-control" >
                                </div>
                              </div>
                              <div class="col-md-3">
                                <div class="form-group">
                                  <label for="rank[<?php echo $counterEligibleScouts; ?>]">Rank</label>
                                  <select class="custom-select" id="rank[<?php echo $counterEligibleScouts; ?>]" name="rank[<?php echo $counterEligibleScouts; ?>]">
                                    <option></option>
                                    <option value="first_class">First Class</option>
                                    <option value="star">Star</option>
                                    <option value="life">Life</option>
                                    <option value="eagle">Eagle</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                            <div class="form-row">
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>Address</label>
                                  <input id="address_line1[<?php echo $counterEligibleScouts; ?>]" name="address_line1[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="Address" >
                                </div>
                                <div class="form-group">
                                  <input id="address_line2[<?php echo $counterEligibleScouts; ?>]" name="address_line2[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="Address Line 2 (optional)">
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>City, State, Zip</label>
                                  <input id="city[<?php echo $counterEligibleScouts; ?>]" name="city[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="City" >
                                </div>
                                <div class="form-row">
                                  <div class="col-md-4">
                                    <div class="form-group">
                                      <input id="state[<?php echo $counterEligibleScouts; ?>]" name="state[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="State" >
                                    </div>
                                  </div>
                                  <div class="col-md-8">
                                    <div class="form-group">
                                      <input id="zip[<?php echo $counterEligibleScouts; ?>]" name="zip[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="Zip" >
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-group">
                                  <label>Contact Information</label>
                                  <input id="email[<?php echo $counterEligibleScouts; ?>]" name="email[<?php echo $counterEligibleScouts; ?>]" type="email" class="form-control" placeholder="Email" >
                                </div>
                                <div class="form-group">
                                  <input id="phone[<?php echo $counterEligibleScouts; ?>]" name="phone[<?php echo $counterEligibleScouts; ?>]" type="text" class="form-control" placeholder="Phone" >
                                </div>
                              </div>
                            </div>
                            <?php
                            $counterEligibleScouts++;
                          }
                        } ?>
                      </div>
                      <div>
                        <button type="button" class="btn btn-secondary" onclick="addScout('eligible-scouts')">Add another</button>
                        <input type="submit" class="btn btn-primary" value="Save">
                      </div>
                      <script>
                          var counter = <?php echo $counterEligibleScouts; ?>;

                          function addScout(divName) {
                              var hr = document.createElement('hr');
                              var formRow = document.createElement('div');
                              formRow.innerHTML = "<input type='hidden' name='eligibleScoutId["+ counter +"]' value='new'><div class='form-row'>  <div class='col-md-3'><div class='form-group'><label for='firstName["+ counter +"]'>First Name</label><input type='text' id='firstName["+ counter +"]' name='firstName["+ counter +"]' class='form-control' ></div>  </div>  <div class='col-md-3'><div class='form-group'><label for='lastName["+ counter +"]'>Last Name</label><input type='text' id='lastName["+ counter +"]' name='lastName["+ counter +"]' class='form-control' ></div>  </div>  <div class='col-md-3'><div class='form-group'>  <label for='dob["+ counter +"]'>Birthday</label>  <input type='date' id='dob["+ counter +"]' name='dob["+ counter +"]' class='form-control' ></div>  </div>  <div class='col-md-3'><div class='form-group'><label for='rank["+ counter +"]'>Rank</label><select class='custom-select' id='rank["+ counter +"]' name='rank["+ counter +"]'><option></option><option value='first_class'>First Class</option><option value='star'>Star</option><option value='life'>Life</option><option value='eagle'>Eagle</option>  </select></div>  </div></div><div class='form-row'>  <div class='col-md-4'><div class='form-group'>  <label>Address</label>  <input id='address_line1["+ counter +"]' name='address_line1["+ counter +"]' type='text' class='form-control' placeholder='Address' ></div><div class='form-group'>  <input id='address_line2["+ counter +"]' name='address_line2["+ counter +"]' type='text' class='form-control' placeholder='Address Line 2 (optional)'></div>  </div>  <div class='col-md-4'><div class='form-group'>  <label>City, State, Zip</label>  <input id='city["+ counter +"]' name='city["+ counter +"]' type='text' class='form-control' placeholder='City' ></div><div class='form-row'>  <div class='col-md-4'><div class='form-group'>  <input id='state["+ counter +"]' name='state["+ counter +"]' type='text' class='form-control' placeholder='State' ></div>  </div>  <div class='col-md-8'><div class='form-group'>  <input id='zip["+ counter +"]' name='zip["+ counter +"]' type='text' class='form-control' placeholder='Zip' ></div>  </div></div>  </div>  <div class='col-md-4'><div class='form-group'>  <label>Contact Information</label>  <input id='email["+ counter +"]' name='email["+ counter +"]' type='email' class='form-control' placeholder='Email' ></div><div class='form-group'>  <input id='phone["+ counter +"]' name='phone["+ counter +"]' type='text' class='form-control' placeholder='Phone' ></div></div></div>";
                              document.getElementById(divName).appendChild(hr);
                              document.getElementById(divName).appendChild(formRow);
                              counter++;
                          }

                      </script>
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
                      <label for="accessKey" class="required">Access Key</label>
                      <input type="text" id="accessKey" name="accessKey" class="form-control" required>
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
                    <label for="accessKey" class="required">Access Key</label>
                    <input type="text" id="accessKey" name="accessKey" class="form-control" required>
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
