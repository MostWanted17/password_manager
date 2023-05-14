<?php
require '../lib/autoload.php';
if (isset($_POST)) {
    $reenviar = new Email();
    $code = $reenviar->code();
    $confirm = new ConfirmEmail();
    $confirm->reenviarConfirmacao($_POST[0],$code);
    echo json_encode($reenviar->gerarHtml($_POST[0],$code));
}

?>