<?php

namespace Alcyon\CoreBundle\Service;

class Slugify
{
    const LOWERCASE_NUMBERS_DASHES = '/([^A-Za-z0-9]|-)+/';
    
    /**
     * @var array<string,string>
     */
    protected $rules = [];
    
    /**
     * @var array<string,mixed>
     */
    protected $options = [
        'regexp'    => self::LOWERCASE_NUMBERS_DASHES,
        'separator' => '-',
        'lowercase' => true,
    ];

    /**
     * @return array
     */
    public function getRules(): array
    {
        return $this->rules;
    }

    /**
     * @return array
     */
    public function getOptions(): array
    {
        return $this->options;
    }


    /**
     * @param array                 $options
     * @param SlugyProviderInterface $provider
     */
    public function __construct(array $options, SlugifyProviderInterface $provider)
    {
        $this->options  = array_merge($this->options, $options);
        $this->addRules($provider->getRules());
    }

    /**
     * Returns the slug-version of the string.
     *
     * @param string            $string  String to slugify
     * @param string|array|null $options Options
     *
     * @return string Slugified version of the string
     */
    public function slugify($string, $options = null)
    {
        // BC: the second argument used to be the separator
        if (is_string($options)) {
            $separator            = $options;
            $options              = [];
            $options['separator'] = $separator;
        }

        $options = array_merge($this->options, (array) $options);

        $string = strtr($string, $this->rules);

        if ($options['lowercase']) {
            $string = mb_strtolower($string);
        }

        $string = preg_replace($options['regexp'], $options['separator'], $string);

        return trim($string, $options['separator']);
    }
    
    /**
     * Adds a custom rule to Slugify.
     *
     * @param string $character   Character
     * @param string $replacement Replacement character
     *
     * @return Slugify
     */
    public function addRule($character, $replacement)
    {
        $this->rules[$character] = $replacement;
        return $this;
    }
    
    /**
     * Adds multiple rules to Slugify.
     *
     * @param array <string,string> $rules
     *
     * @return Slugify
     */
    public function addRules(array $rules)
    {
        foreach ($rules as $character => $replacement) {
            $this->addRule($character, $replacement);
        }
        return $this;
    }
}