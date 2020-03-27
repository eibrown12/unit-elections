<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

# Is the OS Windows or Mac or Linux
if (strtoupper(substr(PHP_OS,0,3)=='WIN')) {
  $eol="\r\n";
} elseif (strtoupper(substr(PHP_OS,0,3)=='MAC')) {
  $eol="\r";
} else {
  $eol="\n";
}
//var_dump(get_defined_vars());
if (isset($_POST['contact_submit'])) {

  $name = $_POST['contact_name'];
  $email = $_POST['contact_email'];
  $unit = $_POST['contact_unit'];
  $description = $_POST['contact_description'];

  $emailaddress="eibrown12@gmail.com";
  # Message Subject
  $emailsubject="Issue on Tulpe Lodge Unit Elections Tool";
  # Message Body

  # Common Headers
  //$headers .= 'From: Tulpe Lodge <noreply@tulpelodge.org>'.$eol;
  $headers .= "From: Tulpe Lodge <noreply@tulpelodge.org>".$eol;
  $headers .= 'Reply-To: '. $name .' <'.$email.'>'.$eol;
  $headers .= 'Return-Path: '.$name.' <'.$email.'>'.$eol;     // these two to set reply address
  $headers .= "Message-ID:<".$now." TheSystem@".$_SERVER['SERVER_NAME'].">".$eol;
  $headers .= "X-Mailer: PHP v".phpversion().$eol;           // These two to help avoid spam-filters
  # Boundry for marking the split & Multitype Headers
  $mime_boundary=md5(time());
  $headers .= 'MIME-Version: 1.0'.$eol;
  $headers .= "Content-Type: multipart/related; boundary=\"".$mime_boundary."\"".$eol;
  $msg = "";

  # HTML Version
  //$msg .= "--".$mime_boundary.$eol;
  //$msg .= "Content-Type: text/html; charset=iso-8859-1".$eol;
  //$msg .= "Content-Transfer-Encoding: 8bit".$eol;
  $msg .= "New contact form submission on Tulpe Lodge Unit Elections Tool\r\n" . $eol;
  $msg .= "Name: ". $name .$eol;
  $msg .= "Email: " .$email . $eol;
  $msg .= "Unit: ". $unit . $eol;
  $msg .= "Description of Issue: $description" .$eol.$eol;

  # Finished
  //$msg .= "--".$mime_boundary."--".$eol.$eol;   // finish with two eol's for better security. see Injection.

  # SEND THE EMAIL
  ini_set(sendmail_from,'noreply@tulpelodge.org');  // the INI lines are to force the From Address to be used !
    if (mail($emailaddress, $emailsubject, $msg, $headers, "-f webmaster@tulpelodge.org")) {
      ini_restore(sendmail_from);
      header("Location: index.php?contact=1");
    } else {
      ini_restore(sendmail_from);
      header("Location: index.php?error=1");
    }

} else {
    header("Location: index.php");
}

?>
