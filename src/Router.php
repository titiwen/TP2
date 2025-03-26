<?php
namespace App;

use App\Security\ForbiddenException;
use Exception;

class Router{

    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var AltoRouter
     */
    private $router;

    public $layout = 'layouts/default';

    public function __construct(string $viewPath){
        $this->viewPath = $viewPath;
        $this->router = new \AltoRouter();
    }

    public function get(string $url, string $view, ?string $name = null): self{
        $this->router->map('GET', $url, $view, $name);

        return $this;
    }

    public function post(string $url, string $view, ?string $name = null): self{
        $this->router->map('POST', $url, $view, $name);

        return $this;
    }

    public function url(string $name, array $params = []): string{
        return $this->router->generate($name, $params);
    }

    public function run(): self
    {
        $match = $this->router->match();
        if ($match === false) {
            $view = 'e404';
            $params = [];
        } else {
            $view = $match['target'];
            $params = $match['params'];
        }

        $router = $this;
        $isAdmin = strpos($view, 'admin/') !== false;
        $layout = $isAdmin ? 'admin/layouts/default' : $this->layout;
        try{
        ob_start();
        require $this->viewPath . DIRECTORY_SEPARATOR . $view . '.php';
        $content = ob_get_clean();
        require $this->viewPath . DIRECTORY_SEPARATOR . $layout . '.php';
        }catch(ForbiddenException $e){
            header('Location: ' . $this->url('login') . '?forbidden=1');
            exit();
        }

        return $this;
    }

    public function match(string $url, string $view, ?string $name = null): self{
        $this->router->map('POST|GET', $url, $view, $name);

        return $this;
    }
}