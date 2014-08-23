<?php
/**
 * Plugin Name: WP CDN Url Replace
 * Plugin URI: https://github.com/kfuchs/wp-cdn-url-replace
 * Description: Easily replace existing urls to point to your CDN using regex. Instead of using the database to store
 * rewrite rules like other plugins it utilizes the $_ENV global to provide the developer control over multiple envs settings.
 * Version: 1.0
 * Author: Kirill Fuchs
 * Author URI: https://github.com/kfuchs
 * License: MIT
 */

/**
 * Class CdnUrlReplace
 */
class CdnUrlReplace
{
    /**
     * @var string
     */
    public $envSearchKey = 'CDN_URL_SEARCH_FOR';

    /**
     * @var string
     */
    public $envReplaceWithKey = 'CDN_URL_REPLACE_WITH';

    /**
     * @param $content
     *
     * @return mixed
     */
    public function replace($content)
    {
        $search = $_ENV[$this->envSearchKey];
        $replace = $_ENV[$this->envReplaceWithKey];
        return str_replace($search, $replace, $content);
    }
}

/**
 *
 */
function bufferHandler()
{
    $CdnUrlReplace = new CdnUrlReplace();
    ob_start(array(&$CdnUrlReplace, 'replace'));
}

if ($_ENV['CDN_URL_SEARCH_FOR'] && $_ENV['CDN_URL_REPLACE_WITH']) {
    add_action('template_redirect', 'bufferHandler');
}
