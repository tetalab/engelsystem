<?php
  include "../includes/db.php";
  include "../includes/config.php";
  include "../includes/funktion_modem.php";

  $SQL = "SELECT DECT FROM `User`;";
  $Erg = mysql_query($SQL, $con);

  echo mysql_error($con);

  for($i=0; $i < mysql_num_rows($Erg); $i++) {
    $Number = "#10" . mysql_result($Erg, $i, "DECT");

    if(strlen($Number) == 7)
      DialNumber($Number);
  }

  return 0;
?>
