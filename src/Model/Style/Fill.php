<?php

namespace AdminoPasswordo\OpenLayers\Model\Style;

class Fill extends Style
{
    private static $db = [
        'Color' => 'Varchar',
    ];

    private static $has_many = [
        'Styles' => 'AdminoPasswordo\\OpenLayers\\Model\\Style\\Style',
    ];

    private static $defaults = [
        'Color' => "'rgba(255,128,0,.5)'",
    ];
}
