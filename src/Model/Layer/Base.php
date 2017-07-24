<?php

namespace AdminoPasswordo\OpenLayers\Model\Layer;

use AdminoPasswordo\OpenLayers\Model\Ol;

class Base extends Ol
{
    private static $base_class = true;

    private static $abstract = true;

    private static $db = [
        'Opacity' => 'Varchar(255)',
        'Visible' => 'Varchar(255)',
    ];

    private static $defaults = [
        'Opacity' => '1.00',
        'Visible' => 'true',
    ];

    private static $has_one = [
        'Map' => 'AdminoPasswordo\\OpenLayers\\Model\\Map',
    ];
}
