<?php

if (! function_exists('wrapImagesWithCaptions')) {
    function wrapImagesWithCaptions($html)
    {
        return preg_replace_callback(
            '/<p><img src="(.*?)"[^>]*><\/p>\s*<p><figcaption>(.*?)<\/figcaption><\/p>/i',
            function ($matches) {
                return '<figure><img src="' . $matches[1] . '"><figcaption>' . $matches[2] . '</figcaption></figure>';
            },
            $html
        );
    }
}
