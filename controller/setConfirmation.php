<?php
require '../lib/autoload.php';
if (isset($_POST)) {
    $confirmEmail = new ConfirmEmail();
    echo json_encode($confirmEmail->setConfirm($_POST[0]));
}

?>