<?php

/**
 * Specify application-specific configuration. These settings can be over-ridden
 * by the local environmental settings, so it's safe to specify default values
 * here.
 */
return [
    /**
     * Define where our view directory is in relation to this file.
     */
    'twig.path' => __DIR__ . '/../view',

    /**
     * Configure some Twig extensions that should be available to every template.
     */
    'twig.extensions' => [
        'LukeZbihlyj\SilexTwig\Twig\TwigExtension',
    ],

    /**
     * Configure some Twig options to get passed to the constructor for the
     * Twig_Environment.
     */
    'twig.options' => [],

    /**
     * Define a collection of Twig templates with predefined names to make management
     * easier.
     */
    'twig.templates' => [],
];
