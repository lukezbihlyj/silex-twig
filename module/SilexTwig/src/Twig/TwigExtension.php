<?php

namespace LukeZbihlyj\SilexTwig\Twig;

use DateTime;
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
        return [];
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

            new Twig_SimpleFilter('ago', function ($time) {
                $periods = ['second', 'minute', 'hour', 'day', 'week', 'month', 'year', 'decade'];
                $lengths = ['60', '60', '24', '7', '4.35', '12', '10'];

                $now = time();

                if ($time instanceof DateTime) {
                    $time = $time->getTimestamp();
                } elseif (is_string($time)) {
                    $time = strtotime($time);
                }

                $difference = $now - $time;

                for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
                    $difference /= $lengths[$j];
                }

                $difference = round($difference);

                if ($difference != 1) {
                    $periods[$j] .= 's';
                }

                return $difference . ' ' . $periods[$j] . ' ago';
            }),
        ];
    }
}
