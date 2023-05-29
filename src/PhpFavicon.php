<?php

namespace Beaubus;

class PhpFavicon
{
    private string $public_path;

    public function __construct(string $public_path = '') {
        $this->public_path = trim($public_path);

        // add trailing slash to the end
        if (!empty($this->public_path) && !str_ends_with($this->public_path, '/')) $this->public_path .= '/';
    }

    public function setup()
    {
        $favicon = $this->getFavicon('Light bulb');
        $this->extractFavicon($favicon);
    }

    /**
     * Render favicon tags to the string
     */
    public function faviconTags(): string
    {
        return <<<TAGS
            <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>☘️</text></svg>">
        TAGS;
    }

    private function extractFavicon(array $favicon)
    {
        // make beaubus_favicon/ folder
        $path = $this->public_path . 'beaubus_favicon/';
        mkdir($path);

        // download zip file into tmp folder
        $tmp_file = $path . 'tmp.zip';
        echo "copy from: " . $favicon['zip'] . PHP_EOL;
        echo "copy to: " . $tmp_file . PHP_EOL;
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
        $browserconfig = preg_replace('/src=\"\//', 'src="/beaubus-favicons/', $browserconfig);
        file_put_contents($browserconfig_path, $browserconfig);

        // replace paths in webmanifest
        $webmanifest_path = $path . 'site.webmanifest';
        $webmanifest = file_get_contents($webmanifest_path);
        $webmanifest = preg_replace('/\"src\": \"\//', '"src": "/beaubus-favicons/', $webmanifest);
        file_put_contents($webmanifest_path, $webmanifest);
    }

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