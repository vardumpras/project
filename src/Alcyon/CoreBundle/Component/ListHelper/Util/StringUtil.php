<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Alcyon\CoreBundle\Component\ListHelper\Util;

class StringUtil
{
    /**
     * This class should not be instantiated.
     */
    private function __construct()
    {
    }

    /**
     * Converts a fully-qualified class name to a block prefix.
     *
     * @param string $fqcn The fully-qualified class name
     * @param string $toDelete The suffix to delete	 
     *
     * @return string|null The block prefix or null if not a valid FQCN
     */
    public static function fqcnToBlockPrefix($fqcn, $toDelete = 'element')
    {
        // Non-greedy ("+?") to match "$toDelete" suffix, if present
        if (preg_match('~([^\\\\]+?)('.$toDelete.')?$~i', $fqcn, $matches)) {
            return strtolower(preg_replace(array('/([A-Z]+)([A-Z][a-z])/', '/([a-z\d])([A-Z])/'), array('\\1_\\2', '\\1_\\2'), $matches[1]));
        }
    }
}
