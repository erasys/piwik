<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html GPL v3 or later
 *
 * @category Piwik
 * @package Piwik
 */
namespace Piwik;

use Piwik\Plugins\CoreConsole\GenerateApi;
use Piwik\Plugins\CoreConsole\GenerateController;
use Piwik\Plugins\CoreConsole\GeneratePlugin;
use Piwik\Plugins\CoreConsole\GitCommit;
use Piwik\Plugins\CoreConsole\GitPull;
use Piwik\Plugins\CoreConsole\GitPush;
use Piwik\Plugins\CoreConsole\RunTests;
use Piwik\Plugins\CoreConsole\WatchLog;
use Symfony\Component\Console\Application;

class Console
{
    public function run()
    {
        $console = new Application();

        $console->add(new RunTests());
        $console->add(new GeneratePlugin());
        $console->add(new GenerateApi());
        $console->add(new GenerateController());
        $console->add(new WatchLog());
        $console->add(new GitPull());
        $console->add(new GitCommit());
        $console->add(new GitPush());

        $console->run();
    }
}
