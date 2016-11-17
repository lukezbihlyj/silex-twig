<?php

namespace LukeZbihlyj\SilexTwig;

use Silex\Provider\TwigServiceProvider;
use LukeZbihlyj\SilexPlus\Application;
use LukeZbihlyj\SilexPlus\ModuleInterface;
use LukeZbihlyj\SilexTwig\Twig\TwigTemplateLoader;

/**
 * @package LukeZbihlyj\SilexTwig\Module
 */
class Module implements ModuleInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigFile()
    {
        return __DIR__ . '/../config/module.php';
    }

    /**
     * {@inheritDoc}
     */
    public function init(Application $app)
    {
        $app['twig.options']['debug'] = $app->getDebug();

        if ($app['twig.options']['debug']) {
            $app['twig.options']['cache'] = false;
        }

        $app->register(new TwigServiceProvider(), [
            'twig.path' => $app['twig.path'],
            'twig.templates' => $app['twig.templates'],
            'twig.options' => $app['twig.options'],
        ]);

        $app['twig.loader.array'] = function($app) {
            return new TwigTemplateLoader($app['twig.templates']);
        };

        $app['twig'] = $app->share($app->extend('twig', function($twig, $app) {
            foreach ($app['twig.extensions'] as $extension) {
                $twig->addExtension(new $extension($app));
            }

            return $twig;
        }));
    }
}
