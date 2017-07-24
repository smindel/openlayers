<?php

namespace AdminoPasswordo\OpenLayers\Model\Style;

use AdminoPasswordo\OpenLayers\Model\Ol;

class Style extends Ol
{
    private static $has_one = [
        'Fill' => 'AdminoPasswordo\OpenLayers\Model\Style\Fill',
        'Image' => 'AdminoPasswordo\OpenLayers\Model\Style\Image',
        'Stroke' => 'AdminoPasswordo\OpenLayers\Model\Style\Stroke',
    ];

    private static $belongs_many_many = [
        'Layer' => 'AdminoPasswordo\\OpenLayers\\Model\\Layer\\Vector',
    ];
}
