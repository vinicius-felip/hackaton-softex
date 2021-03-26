<?php

namespace App\Http;

use Closure;
use Exception;
use ReflectionFunction;

class Router
{

    /**
     * URL do projeto
     *
     * @var string
     */
    private $url = '';

    /**
     * Prefixo de todas as rotas
     *
     * @var string
     */
    private $prefix = '';

    /**
     * Índice de rotas
     *
     * @var array
     */
    private $routes = [];

    /**
     * Instância de Request
     *
     * @var Request
     */
    private $request;

    public function __construct($url)
    {
        $this->request = new Request;
        $this->url     = $url;
        $this->setPrefix();
    }


    /**
     * Método responsável por definir o prefixo das rotas
     *
     * @param  mixed $prefix
     * @return void
     */
    private function setPrefix()
    {
        $this->prefix = parse_url($this->url, PHP_URL_PATH) ??  '';
    }

    /**
     * Método responsável por adicionar uma rota na classe
     *
     * @param  string $method
     * @param  string $route
     * @param  array  $params
     * @return void
     */
    private function addRoute($method, $route, $params = [])
    {
        //VALIDAÇÃO DOS PARAMETROS
        foreach ($params as $key => $value) {
            if ($value instanceof Closure) {
                $params['controller'] = $value;
                unset($params[$key]);
            }
        }

        //VARIAVEIS DA ROTA
        $params['variables'] = [];

        //PADRAO VALIDAÇÃO DAS VARIAVÉIS DA ROTA
        $patternVariable = "/{(.*?)}/";
        if (preg_match_all($patternVariable, $route, $matches)){
            $route = preg_replace($patternVariable, '(.*?)', $route);
            $params['variables'] = $matches[1];
        }   

        //PADRAO DE VALIDAÇÃO DA URL
        $patternRoute = '/^' . str_replace('/', '\/', $route) . '$/';

        //ADICIONA A ROTA DENTRO DA CLASSE
        $this->routes[$patternRoute][$method] = $params;
    }

    /**
     * Método responsável por definir uma rota de GET
     *
     * @param  string $route
     * @param  array $params
     */
    public function get($route, $params = [])
    {
        return $this->addRoute('GET', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de POST
     *
     * @param  string $route
     * @param  array $params
     */
    public function post($route, $params = [])
    {
        return $this->addRoute('POST', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de PUT
     *
     * @param  string $route
     * @param  array $params
     */
    public function put($route, $params = [])
    {
        return $this->addRoute('PUT', $route, $params);
    }

    /**
     * Método responsável por definir uma rota de DELETE
     *
     * @param  string $route
     * @param  array $params
     */
    public function delete($route, $params = [])
    {
        return $this->addRoute('DELETE', $route, $params);
    }

    /**
     * Método responsável por retornar a URI (sem o prefixo)
     *
     * @return string
     */
    private function getUri()
    {
        //URI DA REQUEST
        $uri = $this->request->getUri();

        //FATIA A URI COM PREFIXO
        $xUri = strlen($this->prefix) ? str_replace($this->prefix, '', $uri) : [$uri];

        return $xUri;
    }


    /**
     * Método responsável por retornar os dados da rota atual
     *
     * @return array
     */
    private function getRoute()
    {
        //URI
        $uri =  $this->getUri();

        //METHOD
        $httpMethod = $this->request->getHttpMethod();

        //VALIDA ROTAS
        foreach ($this->routes as $patternRoute => $methods) {
            //VERIFICA SE URI É IGUAL AO PADRÃO
            if (preg_match($patternRoute, $uri, $matches)) {
                //VERIFICA O METODO
                if (isset($methods[$httpMethod])) {
                    //REMOVE PRIMEIRA POSIÇÃO
                    unset($matches[0]);

                    //VARIAVÉIS PROCESSADAS
                    $keys = $methods[$httpMethod]['variables'];
                    $methods[$httpMethod]['variables'] = array_combine($keys, $matches);
                    $methods[$httpMethod]['variables']['request'] = $this->request;

                    //RETORNA O METODO
                    return $methods[$httpMethod];
                }
                throw new Exception('Método não permitido', 405);
            }
        }
        $file = __DIR__ . '/../../resources/view/pages/404.html';
        throw new Exception(file_get_contents($file), 404);
    }

    /**
     * Método responsável por executar a rota atual
     *
     * @return Response
     */
    public function run()
    {
        try {
            //OBTÉM A ROTA ATUAL
            $route = $this->getRoute();

            //VERIIFICA O CONTROLADOR
            if (!isset($route['controller'])) {
                throw new Exception('A URL não pode ser processada', 500);
            }

            //ARGUMENTOS DA FUNÇÃO
            $args = [];

            //REFLECTION
            $reflection = new ReflectionFunction($route['controller']);
            foreach ($reflection->getParameters() as $parameter){
                $name = $parameter->getName();
                $args[$name] = $route['variables'][$name] ?? '';
            }
                
            //EXECUTA
            return call_user_func_array($route['controller'], $args);

        } catch (Exception $e) {
            return new Response($e->getCode(), $e->getMessage());
        }
    }
}
