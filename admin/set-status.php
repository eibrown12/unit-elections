<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include '../unitelections-info.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['unitElectionId'])) { $unitElectionId = $_POST['unitElectionId']; } else { die("No unit election id."); }
if (isset($_POST['unitElectionStatus'])) { $unitElectionStatus = $_POST['unitElectionStatus']; } else { die("No unit election status."); }

$updateElectionStatus = $conn->prepare("UPDATE unitElections SET status=? WHERE id = ?");
$updateElectionStatus->bind_param("ss", $unitElectionStatus, $unitElectionId);
$updateElectionStatus->execute();
$updateElectionStatus->close();

header("Location: index.php");

?>
