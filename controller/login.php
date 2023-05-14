<?php
require '../lib/autoload.php';
if (isset($_POST)) {
    $login = new Login();
    $cripto = new Criptografia();
    echo json_encode($login->getLogin($_POST[0],$cripto->cripto($_POST[1])));
}