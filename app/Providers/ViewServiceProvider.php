<?php
namespace App\Providers;

use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use App\Constracts\ServiceProvider;

class ViewServiceProvider extends ServiceProvider {

    public function register() {
        $this->container['view'] = function($c) {
            $base_path = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');

            $view = new Twig(RESOURCE_ROOT.'/view', [
                'charset'          => 'utf-8',
                'cache'            => STORAGE_ROOT.'/cache/view',
                'auto_reload'      => true,
                'strict_variables' => false,
                'autoescape'       => true
            ]);

            $view->addExtension(new TwigExtension($c['router'], $base_path));

            return $view;
        };
    }

}