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

    <title>Dashboard | Unit Elections Administration | Tulpe Lodge - Order of the Arrow, BSA</title>

    <link rel="stylesheet" href="../libraries/bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="../libraries/fontawesome-free-5.12.0/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
    <link rel="stylesheet" href="../style.css">

</head>

<body id="dashboard">
  <div class="wrapper">
    <?php include 'navbar.php'; ?>

    <main class="container-fluid col-xl-11">
      <?php
      if ($_GET['status'] == 1) { ?>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Saved!</strong> Your data has been saved! Thanks!
            <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
        </div>
    <?php } ?>
        <section class="row">
            <div class="col-12">
                <h2>Unit Elections Dashboard</h2>
                <h5>Showing Elections for <?php echo date("Y"); ?></h5>
                <div class="alert alert-dark">
                  Unit Leaders can edit their unit information and add eligible Scouts at <a href="https://elections.tulpelodge.org/unitleader" class="alert-link" target="_blank">https://elections.tulpelodge.org/unitleader</a> with the access key listed below.
                </div>
            </div>
        </section>

        <?php
          $getChaptersQuery = $conn->prepare("SELECT DISTINCT chapter FROM unitElections WHERE YEAR(dateOfElection) = YEAR(CURDATE()) ORDER BY chapter ASC");
          $getChaptersQuery->execute();
          $getChaptersQ = $getChaptersQuery->get_result();
          if ($getChaptersQ->num_rows > 0) {
            while ($getChapters = $getChaptersQ->fetch_assoc()) {
              $getUnitElectionsQuery = $conn->prepare("SELECT * from unitElections where chapter = ? and YEAR(dateOfElection) = YEAR(CURDATE()) ORDER BY dateOfElection ASC");
              $getUnitElectionsQuery->bind_param("s", $getChapters['chapter']);
              $getUnitElectionsQuery->execute();
              $getUnitElectionsQ = $getUnitElectionsQuery->get_result();
              if ($getUnitElectionsQ->num_rows > 0) {
                //print election info
                ?>
                <div class="card mb-3">
                  <div class="card-body">
                    <h5 class="card-title"><?php echo $getChapters['chapter']; ?></h5>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th scope="col">Unit</th>
                            <th scope="col">Date of Election</th>
                            <th scope="col"># of Submissions</th>
                            <th scope="col">accessKey</th>
                            <th scope="col">Status</th>
                            <th scope="col">Eligible Scouts</th>
                            <th scope="col">View Results</th>
                            <th scope="col">Edit</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php while ($getUnitElections = $getUnitElectionsQ->fetch_assoc()){
                            ?><tr>
                              <td><?php echo $getUnitElections['unitNumber'] . " " . $getUnitElections['unitCommunity']; ?></td>
                              <td><?php echo date("m-d-Y", strtotime($getUnitElections['dateOfElection'])); ?></td>
                              <?php
                              $submissionsQuery = $conn->prepare("SELECT COUNT(*) AS unitTotal FROM submissions WHERE unitId=?");
                              $submissionsQuery->bind_param("s", $getUnitElections['id']);
                              $submissionsQuery->execute();
                              $submissionsQ = $submissionsQuery->get_result();
                              if ($submissionsQ->num_rows > 0) {
                                $submissions = $submissionsQ->fetch_assoc();
                                ?><td><?php echo $submissions['unitTotal']; ?> out of <?php echo $getUnitElections['numRegisteredYouth']; ?> Scouts</td>
                              <?php }
                              $submissionsQuery->close();
                              ?>
                              <td>
                                Access Key: <?php echo $getUnitElections['accessKey']; ?><br>
                                <a href="https://elections.tulpelodge.org/?accessKey=<?php echo $getUnitElections['accessKey']; ?>">https://elections.tulpelodge.org/?accessKey=<?php echo $getUnitElections['accessKey']; ?></a>
                              </td>
                              <td>
                                <?php if ($getUnitElections['status'] == "closed") {
                                  ?><input class="btn btn-sm btn-secondary disabled" value="closed" type="submit" disabled><?php
                                } else {
                                  $tz = 'America/New_York';
                                  $timestamp = time();
                                  $dt = new DateTime("now", new DateTimeZone($tz));
                                  $dt->setTimestamp($timestamp);

                                  $date = $dt->format("Y-m-d");
                                  $hour = $dt->format("H");
                                  if ((strtotime($getUnitElections['dateOfElection']) < strtotime($date)) || ($getUnitElections['dateOfElection'] == $date && $hour >= 21)) {
                                    $updateElectionStatus = $conn->prepare("UPDATE unitElections SET status='closed' WHERE id = ?");
                                    $updateElectionStatus->bind_param("s", $getUnitElections['id']);
                                    $updateElectionStatus->execute();
                                    $updateElectionStatus->close();
                                    ?><input class="btn btn-sm btn-secondary disabled" value="closed" type="submit" disabled><?php
                                  } else { ?>
                                    <form action="set-status.php" method="POST">
                                    <?php if ($getUnitElections['status'] == "new") { ?>
                                        <input type="hidden" value="<?php echo $getUnitElections['id']; ?>" name="unitElectionId" id="unitElectionId">
                                        <input type="hidden" value="open" name="unitElectionStatus" id="unitElectionStatus">
                                        <input type="submit" value="Start Election" class="btn btn-sm btn-danger">
                                    <?php } ?>
                                    <?php if ($getUnitElections['status'] == "open") { ?>
                                        <input type="hidden" value="<?php echo $getUnitElections['id']; ?>" name="unitElectionId" id="unitElectionId">
                                        <input type="hidden" value="closed" name="unitElectionStatus" id="unitElectionStatus">
                                        <input type="submit" value="End Election" class="btn btn-sm btn-danger">
                                    <?php } ?>
                                    </form>
                                  <?php } ?>
                                <?php } ?>
                              </td>
                              <td><a href="eligible-scouts.php?accessKey=<?php echo $getUnitElections['accessKey']; ?>">Eligible Scouts</a></td>
                              <td>
                                <?php

                                $tz = 'America/New_York';
                                $timestamp = time();
                                $dt = new DateTime("now", new DateTimeZone($tz));
                                $dt->setTimestamp($timestamp);

                                $date = $dt->format("Y-m-d");
                                $hour = $dt->format("H");
                                if ((strtotime($getUnitElections['dateOfElection']) < strtotime($date)) || ($getUnitElections['dateOfElection'] == $date && $hour >= 21) || $getUnitElections['status'] == "closed") { ?>
                                  <a href="results.php?accessKey=<?php echo $getUnitElections['accessKey']; ?>">view</a>
                                <?php } else { ?>
                                  <span class="text-muted">not completed</span>
                                <?php } ?>
                              </td>
                              <td><a href="edit-unit-election.php?accessKey=<?php echo $getUnitElections['accessKey']; ?>">edit</a></td>
                            </tr>
                          <?php } ?>
                        </tbody>
                      </table>
                    </div>
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
            }
          } else {
            ?>
            <div class="alert alert-danger" role="alert">
              There are no elections in the database.
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
