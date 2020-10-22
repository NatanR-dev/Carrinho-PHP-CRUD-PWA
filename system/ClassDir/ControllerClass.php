<?php

/**
 * Author: github.com/NatanR-dev
 */

class ControllerClass
{
    /**
     * Variáveis ​​de classe inicial
     */
    protected $db;
    public $forceIndex; // Forçar método de índice de carregamento se o método selecionado não for encontrado

    /**
     * Construtor de Classe
     */
    public function __construct()
    {
        global $db;

        $this->db = $db;
        $this->forceIndex = false;
    }

    /**
     * Função de visualização de output
     *
     * Parâmetro Args
     * página: (OBRIGATÓRIA) arquivo de página renderizado na view/page/
     * param.title : título da página HTML
     * param.layout : layout de visualização principal a ser usado na view/layout
     * param.data : variáveis ​​mistas a serem visualizadas
     */
    public function view($page, ...$params)
    {
        /**
         * Variáveis ​​de visualização inicial
         */
        $title = $params[0]['title'] ?? config('name');
        $layout = $params[0]['layout'] ?? 'main';
        $data = $params[0]['data'] ?? null;
        if ( ! is_array($data) ) $data = [$data];

        // Setar o diretório de layout de string
        if (strpos($layout, '.php') === false) $layout = $layout.'.php';
        $layout = 'view/layout/'.$layout;

        // Setar um arquivo de página
        if (strpos($page, '.php') === false) $page = $page.'.php';
        $page = 'view/page/'.$page;

        $_VIEW = [
            'title' => $title,
            'layout' => $layout,
            'page' => $page,
            'data' => $data,
        ];

        // Extrair dados para a saída, não definir dados não utilizados
        unset($page, $title, $layout);
        extract($data);
        unset($data);

        include($_VIEW['layout']);
    }

    /**
     * Mostrar erro 403 de acesso não permitido
     */
    public function error403($title = '403 - Forbidden')
    {
        $this->view('../error/403.php', ['title' => $title]);
        exit();
    }

    /**
     * Exibir o erro 404 na página
     */
    public function error404($title = '404 - Não Encontrado')
    {
        $this->view('../error/404.php', ['title' => $title]);
        exit();
    }
}

?>