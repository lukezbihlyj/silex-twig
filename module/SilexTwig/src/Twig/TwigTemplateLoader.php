<?php

namespace LukeZbihlyj\SilexTwig\Twig;

use Twig_LoaderInterface;
use Twig_ExistsLoaderInterface;
use Twig_Error_Loader;

/**
 * @package LukeZbihlyj\SilexTwig\Twig\TwigTemplateLoader
 */
class TwigTemplateLoader implements Twig_LoaderInterface, Twig_ExistsLoaderInterface
{
    /**
     * @var array
     */
    protected $templates = [];

    /**
     * @param array $templates
     * @return self
     */
    public function __construct(array $templates)
    {
        $this->templates = $templates;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getSource($name)
    {
        $name = (string) $name;

        if (!isset($this->templates[$name])) {
            throw new Twig_Error_Loader('Template "' . $name . '" is not defined.');
        }

        if (!file_exists($this->templates[$name])) {
            throw new Twig_Error_Loader('Unable to find template "' . $name . '".');
        }

        return file_get_contents($this->templates[$name]);
    }

    /**
     * {@inheritdoc}
     */
    public function exists($name)
    {
        return isset($this->templates[(string) $name]);
    }

    /**
     * {@inheritdoc}
     */
    public function getCacheKey($name)
    {
        $name = (string) $name;

        if (!isset($this->templates[$name])) {
            throw new Twig_Error_Loader('Template "' . $name . '" is not defined.');
        }

        return $this->templates[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function isFresh($name, $time)
    {
        $name = (string) $name;

        if (!isset($this->templates[$name])) {
            throw new Twig_Error_Loader('Template "' . $name . '" is not defined.');
        }

        return true;
    }
}
