<?php

/**
 * Classe para gerenciar as rotas do site.
 */
class Rotas
{
    // Constantes para os nomes das pastas.
    const PASTA_CONTROLLER = 'controller';
    const PASTA_VIEW = 'view';

    /**
     * Página atual que está sendo exibida.
     * @var array
     */
    public static $pag;

    /**
     * Retorna a URL do site com a pasta do site.
     * @return string
     */
    public static function get_SiteHOME()
    {
        return Config::SITE_URL . '/' . Config::SITE_PASTA;
    }

    /**
     * Retorna a URL do site sem a pasta do site.
     * @return string
     */
    public static function get_Home()
    {
        return Config::SITE_URL;
    }

    /**
     * Retorna o caminho físico até a pasta raiz do site.
     * @return string
     */
    public static function get_SiteRAIZ()
    {
        return $_SERVER['DOCUMENT_ROOT'] . '/' . Config::SITE_PASTA;
    }

    /**
     * Retorna o caminho até a pasta de CSS.
     * @return string
     */
    public static function get_CSS()
    {
        return self::PASTA_VIEW . "/css";
    }

    /**
     * Retorna o caminho até a pasta de JavaScript.
     * @return string
     */
    public static function get_JS()
    {
        return self::PASTA_VIEW . "/js";
    }

    /**
     * Retorna o caminho até a pasta de bibliotecas de terceiros.
     * @return string
     */
    public static function get_VENDOR()
    {
        return self::PASTA_VIEW . "/vendor";
    }

    /**
     * Retorna o caminho até a pasta de imagens.
     * @return string
     */
    public static function get_IMAGES()
    {
        return self::PASTA_VIEW . "/images";
    }

    /**
     * Carrega a página solicitada.
     */
    public static function get_Pagina()
    {
        try {
            if (isset($_GET['pag'])) {
                $pagina = $_GET['pag'];
                self::$pag = explode('/', $pagina);
                $pagina = self::PASTA_CONTROLLER . '/' . self::$pag[0] . '.php';
                if (file_exists($pagina)) {
                    include $pagina;
                } else {
                    throw new Exception('Página não encontrada.');
                }
            } else {
                include self::PASTA_CONTROLLER . '/home.php';
            }
        } catch (Exception $e) {
            include self::PASTA_CONTROLLER . '/erro.php';
        }
    }
}

?>
