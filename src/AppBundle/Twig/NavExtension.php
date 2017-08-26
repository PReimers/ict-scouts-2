<?php

namespace AppBundle\Twig;

use Twig_Extension;
use Twig_SimpleFunction;

class NavExtension extends Twig_Extension
{
    public function getFunctions()
    {
        return [
            new Twig_SimpleFunction('nav_is_current', [ $this, 'isCurrentFunction' ] ),
        ];
    }

    public function isCurrentFunction($currentRoute, $routeName)
    {
        if ($currentRoute === $routeName) {
            return ' active';
        }

        return '';
    }
}