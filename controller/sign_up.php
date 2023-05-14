<?php
require '../lib/autoload.php';
if (isset($_POST)) {
    $sign_up = new Sign_Up();
    $cripto = new Criptografia();
    echo json_encode($sign_up->setSign_Up($_POST[0],$_POST[1],$_POST[2],$cripto->cripto($_POST[3])));
}

?>