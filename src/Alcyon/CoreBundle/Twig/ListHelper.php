<?php

/*
 * This file is part of the AlcyonCoreBundle package.
 *
 * (c) David DE SOUSA <d.desousa@alcyon.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


namespace Alcyon\CoreBundle\Twig;

use Alcyon\CoreBundle\Component\ListHelper\ListView;

class ListHelper extends \Twig_Extension
{
    const FUNCTION_LIST = ['listview',
        'listview_start',
        'listview_end',
        'listview_stript',
        'listview_widget',
        'listview_header',
        'listview_body',
        'listview_tablehead',
        'listview_tablebody',
        'listview_action',
        'listview_footer',
        'listview_grouped_action',
        'listview_pagination'];

    /**
     * @var string The template
     */
    private $template;

    /**
     * @return string
     */
    public function getTemplate(): string
    {
        return $this->template;
    }

    /**
     * Constructor.
     *
     * @param string $template The template to render listview
     */
    public function __construct($template)
    {
        $this->template = $template;
    }

    public function createFunction($function)
    {
        return new \Twig_SimpleFunction($function,
            [$this, $function],
            ['is_safe' => ['html'], 'needs_environment' => true]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array_map([$this, 'createFunction'], self::FUNCTION_LIST);
    }

    public function __call($method, array $arguments)
    {
        if (!in_array($method, self::FUNCTION_LIST))
            throw new \InvalidArgumentException('Fatal error: Call to undefined function "' . $method . '", allowed functions are : ' . implode( ', ', self::FUNCTION_LIST));

        if (!isset($arguments[0]) || !$arguments[0] instanceof \Twig_Environment)
            throw new\InvalidArgumentException('Fatal error: Argument n°1 must be an instance of ' . \Twig_Environment::class);

        if (!isset($arguments[1]) || !($arguments[1] instanceof ListView))
            throw new\InvalidArgumentException('Fatal error: Argument n°2 must be an instance of ' . ListView::class);

        return $this->listview($arguments[0], $arguments[1], $method);
    }

    public function listview(\Twig_Environment $environment, ListView $list, $block = 'listview')
    {
        return $environment->loadTemplate($this->template)
            ->renderBlock($block, ['list' => $list]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'alcyon_core.listhelper';
    }
}