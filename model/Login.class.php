<?php

class Login extends Conexao
{
    function __construct()
    {
        parent::__construct();
    }
    function getLogin($email, $password)
    {
        $query = "SELECT c.id_credential,c.email,c.confirm,c.id_user,u.name,u.surname from credential c inner join user u on c.id_user=u.id_user where c.email=? and c.password=? and c.deleted<>1 and u.deleted<>1;";
        try {
            $this->ExecuteSQL($query, array($email, $password));
            $this->GetLista();
            if ($this->TotalDados() == 1) {
                session_start();
                $_SESSION['auth_session'] = $this->itens[1];
                return 1;
            } else {
                return 0;
            }
        } catch (PDOException $e) {
            exit('Erro na consulta: ' . $e->getMessage());
        }
    }
    private function GetLista()
    {
        $this->itens = array();
        $i = 1;
        while ($lista = $this->ListarDados()) {
            $this->itens[$i] = array(
                'id_credential' => $lista['id_credential'],
                'email' => $lista['email'],
                'confirm' => $lista['confirm'],
                'id_user' => $lista['id_user'],
                'name' => $lista['name'],
                'surname' => $lista['surname']
            );
            $i++;
        }
    }
}
