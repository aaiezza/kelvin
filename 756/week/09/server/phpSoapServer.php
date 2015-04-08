<?php
// creating and using a WSDL...
require_once '../php-wsdl/class.phpwsdl.php';

// @formatter:off
$soap = PhpWsdl::CreateInstance(
            null,                 // namespace (PhpWsdl will determine one)
            null,                 // SOAP endpoint URI (PhpWsdl)
            '../php-wsdl/cache',   //this folder must have write access!
            array(                // all files with WSDL definitions in the comments
                'AreaService.php'
            ),
            null,                 // class name that serves web service (PhpWsdl)
            null,                 // method defintions (defined in the class file)
            null,                 // complex types (defined in the class file)
            false,                // whether to send WSDL right now
            false                 // whether to start SOAP server right now
        );
// @formatter:on

// disable caching for the demo (for PHP and the WSDL being created)
ini_set( 'soap.wsdl_cache_enabled', 0 ); // for PHP
PhpWsdl::$CacheTime = 0; // for PhpWsdl
                         
// run the SOAP server
if ( $soap->IsWsdlRequested() )
{
    // WSDL requested by the client?
    $soap->Optimize = false;
}
$soap->RunServer();

?>