<?php

namespace Core\Validation;

use Illuminate\Validation;
use Illuminate\Translation;
use Illuminate\Filesystem\Filesystem;

class Validator
{
    /*
     * IMPORTANT NOTE:
     * Since this class is not bounded to the
     * database, avoid any validation rule
     * that may involve accessing the
     * database. E.g
     * 'unique', 'exists' etc;
     */

    private $factory;

    public function __construct()
    {
        $this->factory = new Validation\Factory(
            $this->loadTranslator()
        );
    }
    
    protected function loadTranslator()
    {
        $filesystem = new Filesystem();
        $loader = new Translation\FileLoader(
            $filesystem,
           dirname(dirname(dirname(__FILE__))) . '/core/Validation/lang'
        );
        $loader->addNamespace(
            'lang',
           dirname(dirname(dirname(__FILE__))) . '/core/Validation/lang'
        );
        $loader->load('en', 'validation', 'lang');
        return new Translation\Translator($loader, 'en');
    }

    public function __call($method, $args)
    {
        return call_user_func_array(
            [$this->factory, $method],
            $args
        );
    }
}
