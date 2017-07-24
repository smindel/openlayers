<?php

namespace AdminoPasswordo\OpenLayers\Model\Style;

class Stroke extends Style
{
    private static $db = [
        'Color' => 'Varchar',
        'Width' => 'Int',
    ];

    private static $has_many = [
        'Styles' => 'AdminoPasswordo\\OpenLayers\\Model\\Style\\Style',
    ];

    private static $defaults = [
        'Color' => "'red'",
        'Width' => '1',
    ];
}
