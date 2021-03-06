<?php
include '../unitelections-info.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if (isset($_POST['unitNumber'])) {  $unitNumber = $_POST['unitNumber']; } else { $unitNumber = ""; }
if (isset($_POST['unitCommunity'])) {  $unitCommunity = $_POST['unitCommunity']; } else { $unitCommunity = ""; }
if (isset($_POST['numRegisteredYouth'])) {  $numRegisteredYouth = $_POST['numRegisteredYouth']; } else { $numRegisteredYouth = ""; }
if (isset($_POST['dateOfElection'])) {  $dateOfElection = $_POST['dateOfElection']; } else { $dateOfElection = ""; }
if (isset($_POST['chapter'])) {  $chapter = $_POST['chapter']; } else { $chapter = ""; }

if (isset($_POST['sm_name'])) {  $sm_name = $_POST['sm_name']; } else { $sm_name = ""; }
if (isset($_POST['sm_address_line1'])) {  $sm_address_line1 = $_POST['sm_address_line1']; } else { $sm_address_line1 = ""; }
if (isset($_POST['sm_address_line2'])) {  $sm_address_line2 = $_POST['sm_address_line2']; } else { $sm_address_line2 = ""; }
if (isset($_POST['sm_city'])) {  $sm_city = $_POST['sm_city']; } else { $sm_city = ""; }
if (isset($_POST['sm_state'])) {  $sm_state = $_POST['sm_state']; } else { $sm_state = ""; }
if (isset($_POST['sm_zip'])) {  $sm_zip = $_POST['sm_zip']; } else { $sm_zip = ""; }
if (isset($_POST['sm_email'])) {  $sm_email = $_POST['sm_email']; } else { $sm_email = ""; }
if (isset($_POST['sm_phone'])) {  $sm_phone = $_POST['sm_phone']; } else { $sm_phone = ""; }


$createElection = $conn->prepare("INSERT INTO unitElections(unitNumber, unitCommunity, chapter, sm_name, sm_address_line1, sm_address_line2, sm_city, sm_state, sm_zip, sm_email, sm_phone, numRegisteredYouth, dateOfElection) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
$createElection->bind_param("sssssssssssss", $unitNumber, $unitCommunity, ucfirst($chapter), $sm_name, $sm_address_line1, $sm_address_line2, $sm_city, $sm_state, $sm_zip, $sm_email, $sm_phone, $numRegisteredYouth, $dateOfElection);
$createElection->execute();
$createElection->close();


header("Location: index.php?status=1");

?>
