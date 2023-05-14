<?php
require './lib/autoload.php';
define('AUTH_SESSION_KEY', 'auth_session');

session_start();

function is_authenticated(): bool {
    return isset($_SESSION[AUTH_SESSION_KEY]);
}

$smarty = new Template();
$smarty->assign('css', Rotas::get_CSS());
$smarty->assign('js', Rotas::get_JS());
$smarty->assign('vendor', Rotas::get_VENDOR());
$smarty->assign('images', Rotas::get_IMAGES());

if(isset($_GET['sign_up'])){
    $smarty->display('sign_up.tpl');
}else if(isset($_GET['confirm'])){
    if(isset($_GET['email'])){
        $smarty->display('confirm.tpl');
    }else{
        header('Location: /');
        exit();
    }
}else{
    if (session_status() === PHP_SESSION_ACTIVE) {
        if (is_authenticated()) {
            $smarty->display('index.tpl');
        } else {
            $smarty->display('login.tpl');
        }
    } else {
        echo 'Erro: Sessão não foi iniciada.';
    }
}
?>