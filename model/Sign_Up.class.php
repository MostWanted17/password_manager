<?php
class Sign_Up extends Conexao
{
    function __construct()
    {
        parent::__construct();
    }
    function setSign_Up($name, $surname, $email, $password)
    {
        $mail = new Email();
        $code = $mail->code();
        $expiryTime = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $query = "Insert into user (name,surname) values (?,?);";
        $query .= "SET @last_id_in_user = LAST_INSERT_ID();";
        $query .= "Insert into credential (email,password,id_user) values (?,?,@last_id_in_user);";
        $query .= "SET @last_id_in_credential = LAST_INSERT_ID();";
        $query .= "Insert into confirm (`code`,`limit`,id_credential) values (?,?,@last_id_in_credential);";
        $stmt = $this->ExecuteSQL($query, array($name, $surname, $email, $password, $code, $expiryTime));
        $mail->gerarHtml($email, $code);
        if ($stmt !== false) {
            return 1;
        } else {
            return 0;
        }
    }
    
}
