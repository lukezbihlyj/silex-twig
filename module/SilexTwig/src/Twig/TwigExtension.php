<?php

namespace LukeZbihlyj\SilexTwig\Twig;

use Twig_Extension;
use Twig_SimpleFunction;
use Twig_SimpleFilter;

/**
 * @package LukeZbihlyj\SilexTwig\Twig\TwigExtension
 */
class TwigExtension extends Twig_Extension
{
    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'util';
    }

    /**
     * {@inheritDoc}
     */
    public function getFunctions()
    {
        return [
            'asset' => new Twig_SimpleFunction('asset', function($asset) {
                return '/' . ltrim($asset, '/') . '?' . filemtime($asset);
            }),
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('slug', function($text) {
                $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
                $text = trim($text, '-');
                $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
                $text = strtolower($text);
                $text = preg_replace('~[^-\w]+~', '', $text);

                if (empty($text)) {
                    return null;
                }

                return $text;
            }),
        ];
    }
}
