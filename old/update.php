<?php

define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ADC_CONGES');

define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);

$dbh = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

$req = "Select * from EMPLOYE"; $res = mysqli_query($dbh,$req);

while($row = mysqli_fetch_assoc($res)){

    $datecalcul = $row['DATECALCUL']; 

    $oldconge = date('Y-m-d',strtotime($datecalcul.' -333 day'));

    $req1 = "update EMPLOYE set LASTCONGE = '$oldconge' where MATRICULE = '$row[MATRICULE]'";

    mysqli_query($dbh,$req1);
}

?>