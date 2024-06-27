<?php
require_once __DIR__.'/../vendor/autoload.php';

use Scurriio\Utils\DataAttribute;
use Scurriio\Utils\RandomString;
use Scurriio\Utils\Singleton;


class TestAttribute{
    use DataAttribute;
    use Singleton;

    protected function initialize()
    {
        RandomString::make(5);        
    }
}

