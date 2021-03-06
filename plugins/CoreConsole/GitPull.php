<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @category Piwik_Plugins
 * @package CoreConsole
 */

namespace Piwik\Plugins\CoreConsole;

use Piwik\Console\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @package CoreConsole
 */
class GitPull extends Command
{
    protected function configure()
    {
        $this->setName('git:pull');
        $this->setDescription('Pull Piwik repo and all submodules');
    }

    protected function getBranchName()
    {
        $cmd    = sprintf('cd %s && git rev-parse --abbrev-ref HEAD', PIWIK_DOCUMENT_ROOT);
        $branch = shell_exec($cmd);

        return trim($branch);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ('master' != $this->getBranchName()) {
            $output->writeln('<info>Doing nothing because you are not on the master branch in super repo.</info>');
            return;
        }

        $cmd = sprintf('cd %s && git checkout master && git pull && git submodule update --init --recursive --remote', PIWIK_DOCUMENT_ROOT);
        $this->passthru($cmd, $output);

        $cmd = 'git submodule foreach "(git checkout master; git pull)&"';
        $this->passthru($cmd, $output);
    }

    private function passthru($cmd, OutputInterface $output)
    {
        $output->writeln('Executing command: ' . $cmd);
        passthru($cmd);
    }
}