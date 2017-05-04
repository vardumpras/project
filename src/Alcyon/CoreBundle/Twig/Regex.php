<?php

namespace Alcyon\CoreBundle\Twig;

class Regex extends \Twig_Extension
{

    public function getFilters()
    {
        return [new \Twig_SimpleFilter('regex', [$this, 'regex'])];
    }

    public function getFunctions()
    {
        return [new \Twig_SimpleFunction('regex', [$this, 'regex'])];
    }

    public function regex($var, $find = '', $replace = '')
    {
        if (is_string($var) && strlen($var)
            && is_string($find) && strlen($find)
        ) {
            $var = preg_replace($find, $replace, $var);
        }

        return $var;
    }

    public function getName()
    {
        return 'alcyon_core.regex';
    }
}