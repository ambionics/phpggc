<?php

namespace PHPGGC\Phar;

/**
 * Defines base methods meant to handle different Phar formats.
 */
abstract class Format
{
	protected $data;
	protected $format = '';

	public function __construct($metadata, $parameters)
	{
		$this->metadata = $metadata;
		$this->generate_dummy_metadata();
        $this->generate_phar($parameters);
	}

	public function generate_phar($parameters)
	{
        $path = (
            sys_get_temp_dir() . DIRECTORY_SEPARATOR .
            'phpggc' . $this->format . '.phar'
        );
        @unlink($path);

		$phar = new \Phar($path);
        $phar->startBuffering();
        $phar->addFromString($parameters['filename'], 'test');
        $phar->setStub($parameters['prefix'] . '<?php __HALT_COMPILER(); ?>');
        $phar->setMetadata($this->dummy_metadata);
        
        # Since we might generate a new signature, we need to make sure the
        # algorithm is valid
        $phar->setSignatureAlgorithm(\Phar::SHA1);
        $phar->stopBuffering();

        $this->data = file_get_contents($path);
        unlink($path);
	}

	public function generate_dummy_metadata()
	{
		# We want our fake metadata to have the same size as our serialized
        # payload, so that we can make an in-place replacement in archives
        $dummy_size = strlen($this->metadata) - strlen('s::"";');
        $dummy_size = $dummy_size - strlen($dummy_size);
        $this->dummy_metadata = str_repeat('A', $dummy_size);
	}

	public function get_data()
	{
		return $this->data;
	}

	/**
	 * Updates the PHAR signature of the file.
	 * It is format-dependant and therefore abstract.
	 */
	abstract function update_signature();

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
    public function replace_metadata()
    {
    	$this->data = str_replace(
            serialize($this->dummy_metadata), $this->metadata, $this->data
        );
    }
}