<?php

namespace Beaubus;

class PhpFavicon
{
    private string $public_path;

    public function __construct(string $public_path = '') {
        $this->public_path = trim($public_path);

        if (!is_dir($this->public_path)) mkdir($this->public_path);

        // add trailing slash to the end
        if (!empty($this->public_path) && !str_ends_with($this->public_path, '/')) $this->public_path .= '/';
    }

    public function init($favicon_name = 'pocket watch', bool $check_for_name_updates = true)
    {
        if (!$check_for_name_updates) return;   // favicon is installed
        if (!$this->isFaviconChanged($favicon_name)) return; // favicon is not changed

        $favicon = $this->getFavicon($favicon_name);
        if (!isset($favicon['name'])) return;

        $this->extractFavicon($favicon);
    }

    /**
     * Render favicon tags to the string
     */
    public function tags(): string
    {
        return <<<TAGS
            <link rel="apple-touch-icon" sizes="180x180" href="/beaubus-favicon/apple-touch-icon.png">
            <link rel="icon" type="image/png" sizes="32x32" href="/beaubus-favicon/favicon-32x32.png">
            <link rel="icon" type="image/png" sizes="16x16" href="/beaubus-favicon/favicon-16x16.png">
            <link rel="manifest" href="/beaubus-favicon/site.webmanifest">
            <link rel="mask-icon" href="/beaubus-favicon/safari-pinned-tab.svg" color="#5bbad5">
            <meta name="msapplication-TileColor" content="#2d89ef">
            <meta name="theme-color" content="#ffffff">
        TAGS;
    }

    private function extractFavicon(array $favicon)
    {
        // make beaubus_favicon/ folder
        $path = $this->public_path . 'beaubus_favicon/';
        if (!is_dir($path)) mkdir($path);

        // download zip file into tmp folder
        $tmp_file = $path . 'tmp.zip';
        copy($favicon['zip'], $tmp_file);

        // Unzip into tmp folder
        $zip = new \ZipArchive;
        $zip->open($tmp_file);
        $zip->extractTo($path);
        $zip->close();

        // remove tmp.zip and README.md
        unlink($tmp_file);
        unlink($path . 'README.md');

        // move favicon.ico and favicon.svg to the public path
        rename($path . 'favicon.ico', $this->public_path . 'favicon.ico');
        file_put_contents($this->public_path . 'favicon.svg', $favicon['svg']);

        // replace paths in browserconfig
        $browserconfig_path = $path . 'browserconfig.xml';
        $browserconfig = file_get_contents($browserconfig_path);
        $browserconfig = preg_replace('/src=\"\//', 'src="/beaubus-favicon/', $browserconfig);
        file_put_contents($browserconfig_path, $browserconfig);

        // replace paths in webmanifest
        $webmanifest_path = $path . 'site.webmanifest';
        $webmanifest = file_get_contents($webmanifest_path);
        $webmanifest = preg_replace('/\"src\": \"\//', '"src": "/beaubus-favicon/', $webmanifest);
        file_put_contents($webmanifest_path, $webmanifest);

        // save the favicon name
        $cached_name_file = $path . 'installed.txt';
        file_put_contents($cached_name_file, $favicon['name']);
    }

    /**
     * Open beaubus_favicon/installed.txt and look if name is the same as $favicon_name
     * @param string $favicon_name Favicon name, specified by user. Example: 'pocket watch'.
     * @return bool
     */
    private function isFaviconChanged(string $favicon_name): bool
    {
        $cached_name_file = $this->public_path . 'beaubus_favicon/installed.txt';
        if (!file_exists($cached_name_file)) return true;
        $cached_name = file_get_contents($cached_name_file);

        return !(strtolower($favicon_name) === strtolower($cached_name));
    }

    /**
     * @param $name
     * @return array|null <{name, zip, svg}>
     */
    private function getFavicon($name): array|null
    {
        $json = file_get_contents('https://favicons.beaubus.com/favicons.json');
        $favicons = json_decode($json, true);

        if($favicons === null) return null; // error occurred during decoding JSON

        foreach($favicons as $favicon) {
            // return the first matching favicon
            if (strtolower($favicon['name']) === strtolower($name)) return $favicon;
        }

        return null; // if no matching favicon found
    }
}