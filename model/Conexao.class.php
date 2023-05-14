<?php
class Conexao extends Config
{
    private $host, $user, $senha, $banco;
    private $obj;
    private $itens = array();
    private $prefix;

    public function __construct()
    {
        $this->host = self::BD_HOST;
        $this->user = self::BD_USER;
        $this->senha = self::BD_SENHA;
        $this->banco = self::BD_BANCO;
        $this->prefix = self::BD_PREFIX;

        $this->estabelecerConexao();
    }

    private function estabelecerConexao()
    {
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
        );
        $link = new PDO(
            "mysql:host={$this->host};dbname={$this->banco}",
            $this->user,
            $this->senha,
            $options
        );
        return $link;
    }

    public function ExecuteSQL($query, array $params = NULL)
    {
        try {
            $this->obj = $this->estabelecerConexao()->prepare($query);
            if ($params !== null) {
                foreach ($params as $key => $value) {
                    $this->obj->bindValue($key + 1, $value);
                }
            }
            return $this->obj->execute();
        } catch (PDOException $e) {
            exit('Erro na consulta: ' . $e->getMessage());
        }
    }

    public function ListarDados()
    {
        return $this->obj->fetch(PDO::FETCH_ASSOC);
    }

    public function TotalDados()
    {
        return $this->obj->rowCount();
    }

    public function GetItens()
    {
        return $this->itens;
    }
}
