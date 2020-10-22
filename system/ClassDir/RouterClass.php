<?php

/**
 * Author: github.com/NatanR-dev
 */

class RouterClass
{
    /**
     * Variáveis ​​de classe inicial
     */
    protected $classDefault;
    protected $methodDefault;
    protected $controller;

    /**
     * Construtor de Classe
     * URI Router para diretório de classe de aplicativo
     */
    public function __construct()
    {
        global $_CONFIG;

        $this->classDefault = toPascalCase($_CONFIG['index']);
        $this->methodDefault = 'index';
        $this->controller = new ControllerClass();

        /**
         * Verifica o nome do host acessado e o url básico na configuração
         * Redirecionar 'se for' diferente
         */
        if ( substr(getUrl(), 0, strlen(baseurl())) != baseurl() ) {
            redirect($_SERVER['REQUEST_URI']);
        }
    }

    public function run()
    {
        /**
         * Dados iniciais
         */
        $classDefault = $this->classDefault;
        $methodDefault = $this->methodDefault;
        $selectedClass = $selectedMethod = null;
        $uriSegments = explodeUri();

        /**
         * Verifica se o URI do pedido é ClassName
         * Ex : http://base-url.test/uri-class/uri-method/...
         */
        if ( ! empty($uriSegments) && ! $selectedClass ) {

            $className = toPascalCase($uriSegments[0]);

            if ( file_exists('app/'.$className.'.php') ) {

                array_shift($uriSegments);
                include('app/'.$className.'.php');

                $class = new $className();
                $method = $methodDefault;

                if ( ! empty($uriSegments) ) $method = toCamelCase($uriSegments[0]);

                /**
                 * Verifica o método por URI Request
                 * Se não existir, verifica o método padrão se existir
                 */
                if ( method_exists($class, $method) ) {

                    $selectedClass = $class;
                    $selectedMethod = $method;
                    array_shift($uriSegments);

                } else if ( method_exists($class, $methodDefault) ) {

                    $selectedClass = $class;
                    $selectedMethod = $methodDefault;
                    array_shift($uriSegments);

                }

            }

        }

        /**
         * Verifica se o URI do pedido é uma classe dentro do diretório
         * Ex : http://base-url.test/...directory/uri-class/uri-method/...
         */
        if ( ! empty($uriSegments) && ! $selectedClass ) {

            $appDirectory = 'app/';

            foreach ($uriSegments as $key => $uri) {

                if ( ! $selectedClass ) {

                    $appDirectory .= $uri.'/';

                    array_shift($uriSegments);

                    if ( ! empty($uriSegments) ) {

                        $className = toPascalCase($uriSegments[0]);

                        if ( file_exists($appDirectory.$className.'.php') ) {

                            array_shift($uriSegments);
                            include($appDirectory.$className.'.php');

                            $class = new $className();
                            $method = $methodDefault;

                            if ( ! empty($uriSegments) ) $method = toCamelCase($uriSegments[0]);

                            /**
                             * Check method by URI Request
                             * If Method Exist, reduce URI Segment array for method parameter
                             */
                            if ( method_exists($class, $method) ) {

                                $selectedClass = $class;
                                $selectedMethod = $method;
                                array_shift($uriSegments);

                            } else if ( method_exists($class, $methodDefault) ) {

                                $selectedClass = $class;
                                $selectedMethod = $methodDefault;

                            }

                        }

                    }

                }

            }

        }

        /**
         * Carregar classe e método padrão
         * Se não houver solicitação de URI
         * Ou nenhuma classe foi selecionada
         * O segmento URI de dados  será redefinido
         * Ex : http://base-url.test/
         */
        if ( ! $selectedClass ) {

            $uriSegments = explodeUri(); // Reseta o segmento de Uri 
            $className =  toPascalCase($classDefault);

            if ( file_exists('app/'.$className.'.php') ) {

                include('app/'.$className.'.php');

                $class = new $className();
                $method = toCamelCase($methodDefault);
                if ( ! empty($uriSegments) ) $method = toCamelCase($uriSegments[0]);

                if ( method_exists($class, $method) ) {

                    $selectedClass = $class;
                    $selectedMethod = $method;

                } else if ( method_exists($class, $methodDefault) ) {

                    // $selectedClass = $class;
                    // $selectedMethod = $methodDefault;

                }

            }

        }

        /**
         * Carrega o App Class e seu método
         * Retorna o erro 404 se nenhuma classe ou método for selecionado
         */
        if ( $selectedClass && $selectedMethod ) {

            call_user_func_array([$selectedClass, $selectedMethod], $uriSegments);

        } else {

            $this->controller->error404();

        }

    }

}

?>