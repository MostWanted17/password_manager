<?php
require '../lib/autoload.php';
if (isset($_POST)) {
    $confirmEmail = new ConfirmEmail();
    $confirmEmail->getCode($_POST[0],$_POST[1]);
    echo json_encode($confirmEmail->TotalDados());
}

?>