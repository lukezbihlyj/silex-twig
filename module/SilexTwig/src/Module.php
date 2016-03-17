<?php

namespace LukeZbihlyj\SilexTwig;

use Silex\Provider\TwigServiceProvider;
use LukeZbihlyj\SilexPlus\Application;
use LukeZbihlyj\SilexPlus\ModuleInterface;

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
        $app->register(new TwigServiceProvider(), [
            'twig.path' => $app['twig.path']
        ]);

        $app->setTwig(
            $app->share(
                $app->extend('twig', function($twig, $app) {
                    foreach ($app['twig.extensions'] as $extension) {
                        $twig->addExtension(new $extension());
                    }

                    return $twig;
                })
            )
        );
    }
}
