<?php

declare(strict_types=1);

namespace App\Shared\Service;

use Symfony\Component\Yaml\Yaml;

class YamlParser
{

    public static function parse(string $filename)
    {
        $array = Yaml::parseFile($filename);
        self::resolve(pathinfo($filename, PATHINFO_DIRNAME) . '/', $array);

        return $array;
    }

    private static function resolve(string $path, array &$array)
    {
        foreach ($array as $key => &$value) {
            if ($key === '$include') {
                $include = [];
                foreach ($value as $filePath) {
                    foreach (self::parse($path . $filePath) as $parsedKey => $parsedValue) {
                        if (! isset($include[$parsedKey])) {
                            $include[$parsedKey] = [];
                        }
                        $include[$parsedKey] = array_merge($include[$parsedKey], $parsedValue);
                    }
                }
                unset($array[$key]);
                $array = array_merge($array, $include);
                self::resolve($path, $array);
                continue;
            }
            if (is_array($value)) {
                self::resolve($path, $value);
            }
        }
    }

}
