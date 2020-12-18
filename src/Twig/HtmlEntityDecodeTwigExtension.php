<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class HtmlEntityDecodeTwigExtension
 * @package App
 */
class HtmlEntityDecodeTwigExtension extends AbstractExtension
{
    /**
     * @return array|TwigFilter[]
     */
    public function getFilters()
    {
        return [
            new TwigFilter('html_entity_decode', [$this, 'htmlEntityDecode'] )
        ];
    }

    /**
     * @param $input
     * @return string
     */
    public function htmlEntityDecode($input)
    {
        return html_entity_decode($input);
    }
}