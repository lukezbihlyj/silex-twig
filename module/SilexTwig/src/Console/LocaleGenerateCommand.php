<?php

namespace LukeZbihlyj\SilexTwig\Console;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use LukeZbihlyj\SilexPlus\Console\ConsoleCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @package LukeZbihlyj\SilexTwig\Console\LocaleGenerateCommand
 */
class LocaleGenerateCommand extends ConsoleCommand
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->setName('twig:locale-generate')
            ->setDescription('Generate a fresh translation base from the current templates.');
    }

    /**
     * {@inheritDoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $app = $this->getSilexApp();

        $app['twig.options'] = [
            'cache' => '/tmp/twigcache',
            'auto_reload' => true
        ];

        $twig = $app->getTwig();

        $directoryIterator = new RecursiveDirectoryIterator($app['twig.path']);
        $iterator = new RecursiveIteratorIterator($directoryIterator);
        $templates = new RegexIterator($iterator, '/^.+\.twig$/i', RegexIterator::GET_MATCH);

        foreach ($templates as $file) {
            $file = str_replace(rtrim($app['twig.path'], '/') . '/', null, $file[0]);
            $twig->loadTemplate($file);
        }

        $result = exec('find /tmp/twigcache -iname "*.php" | xargs xgettext --default-domain=app -o ' . $app['i18n.locale_path'] . '/app.pot --from-code=UTF-8 -n --omit-header -L PHP');

        $output->writeln('<info>Completed generating locale template. Check your locale directory for the .pot file.</info>');
    }
}
