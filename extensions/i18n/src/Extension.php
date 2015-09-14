<?php namespace Internationalization;

use Flarum\Support\Extension as BaseExtension;
use Illuminate\Events\Dispatcher;
use Flarum\Events\RegisterLocales;
use Symfony\Component\Yaml\Yaml;

class Extension extends BaseExtension
{
    public function listen(Dispatcher $events)
    {
        $events->listen(RegisterLocales::class, function (RegisterLocales $event) {

            function getDir($dir)
            {
                $dirArray[] = NULL;
                if (false != ($handle = opendir($dir))) {
                    $i = 0;
                    while (false !== ($file = readdir($handle))) {
                        if ($file != "." && $file != ".." && !strpos($file, ".")) {
                            $dirArray[$i] = $file;
                            $i++;
                        }
                    }
                    closedir($handle);
                }
                return $dirArray;
            }

            $extensions_enabled = app('Flarum\Core\Settings\SettingsRepository')->get('extensions_enabled');
            $localePath = __DIR__ . '/../locale/';
            $arr = json_decode($extensions_enabled, true);
            if (($key = array_search('i18n', $arr))) {
                unset($arr[$key]);
            }

            foreach (getDir($localePath) as $v) {
                $coreYml = $localePath . $v . '/core.yml';
                $array = Yaml::parse(file_get_contents(__DIR__ . '/languagecodes.yml'));
                if (file_exists($coreYml)) {
                    preg_match('/\/locale\/(.*?)\//i', $coreYml, $languagecodes);
                    $languagecodes = $languagecodes[1];
                    $languagename = $array[$languagecodes];
                    $event->manager->addLocale($languagecodes, $languagename);
                    $event->manager->addJsFile($languagecodes, $localePath . $languagecodes . '/core.js');
                    $event->manager->addConfig($languagecodes, $localePath . $languagecodes . '/core.php');
                    $event->addTranslations($languagecodes, $localePath . $languagecodes . '/core.yml');
                    foreach ($arr as $extensions) {
                        $localeYml = $localePath . $languagecodes . '/' . $extensions . '.yml';
                        $enYml = getcwd() . '/extensions/' . $extensions . '/locale/en.yml';
                        if (file_exists($localeYml)) {
                            $event->addTranslations($languagecodes, $localeYml);
                        } else {
                            if(file_exists($enYml)){
                                $event->addTranslations($languagecodes, $enYml);
                            }
                        }
                    }
                }
            }
        });
    }
}
