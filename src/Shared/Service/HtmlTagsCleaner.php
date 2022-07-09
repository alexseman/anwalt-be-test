<?php

declare(strict_types=1);

namespace App\Shared\Service;

class HtmlTagsCleaner
{

    public static function clean($content)
    {
        mb_internal_encoding('UTF-8');
        mb_regex_encoding('UTF-8');

        $value = html_entity_decode($content, ENT_NOQUOTES, 'utf-8');

        if (! empty($content)) {
            $replace_pattern = [
                '<br/>'     => '',
                '<br>'      => '',
            ];

            foreach ($replace_pattern as $pattern => $replace) {
                $value = mb_ereg_replace($pattern, $replace, $value);
            }

            $value = trim(html_entity_decode(strip_tags($content), ENT_NOQUOTES, 'utf-8'));
        }

        return $value;
    }

}
