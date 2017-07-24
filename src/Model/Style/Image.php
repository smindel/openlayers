<?php

namespace AdminoPasswordo\OpenLayers\Model\Style;

class Image extends Style
{
    private static $has_many = [
        'Styles' => 'AdminoPasswordo\\OpenLayers\\Model\\Style\\Style',
    ];
}
