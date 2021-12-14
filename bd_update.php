<?php
/**
 * Created by PhpStorm.
 * User: christiansumbang
 * Date: 2019-02-16
 * Time: 15:26
 */

define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'ADC_CONGES');

define('USER_CREATED_SUCCESSFULLY', 0);
define('USER_CREATE_FAILED', 1);
define('USER_ALREADY_EXISTED', 2);

$dbh = mysqli_connect(DB_HOST,DB_USERNAME,DB_PASSWORD,DB_NAME);

$req = "select * from EMPLOYE"; $res = mysqli_query($dbh,$req);

while($row = mysqli_fetch_assoc($res)) {

    $an = date("Y"); $embauche = $row['DATEEMBAUCHE'];

    $tab = explode("-",$embauche);

    $calcul = $an."-".$tab[1]."-".$tab[2];

    mysqli_query($dbh,"update EMPLOYE set DATECALCUL = '$calcul' where MATRICULE = $row[MATRICULE]");

}