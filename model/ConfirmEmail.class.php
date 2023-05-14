<?php

class ConfirmEmail extends Conexao
{
    function __construct()
    {
        parent::__construct();
    }
    function getCode($email,$code){
        $query = "SELECT c.id_credential FROM credential c INNER JOIN confirm co ON c.id_credential = co.id_credential WHERE c.email = ? and co.`code`=?;";
        $this->ExecuteSQL($query, array($email,$code));
        $this->GetLista();
    }
    function getTimeCode($email,$code){
        $query = "SELECT c.id_credential FROM credential c INNER JOIN confirm co ON c.id_credential = co.id_credential WHERE c.email = ? and co.`code`=? and co.limit >= NOW();";
        $this->ExecuteSQL($query, array($email,$code));
        $this->GetLista();
    }
    function setConfirm($email){
        $query = "UPDATE `credential` SET `confirm` = '1' WHERE email = ? ;";
        $stmt = $this->ExecuteSQL($query, array($email));
        if ($stmt !== false) {
            return 1;
        } else {
            return 0;
        }
    }
    function reenviarConfirmacao($email,$code)
    {
        $mail = new Email();
        $code = $mail->code();
        $expiryTime = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $query = "SELECT c.id_credential into @id_credential FROM credential c WHERE c.email = ?;";
        $query .= "Insert into confirm (`code`,`limit`,id_credential) values (?,?,@id_credential);";
        $stmt = $this->ExecuteSQL($query, array($email,$code,$expiryTime));
        $mail->gerarHtml($email, $code);
        if ($stmt !== false) {
            return 1;
        } else {
            return 0;
        }
    }
    private function GetLista()
    {
        $this->itens = array();
        $i = 1;
        while ($lista = $this->ListarDados()) {
            $this->itens[$i] = array(
                'id_credential' => $lista['id_credential']
            );
            $i++;
        }
    }
}