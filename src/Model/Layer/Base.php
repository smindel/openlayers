<?php

namespace AdminoPasswordo\OpenLayers\Model\Layer;

use AdminoPasswordo\OpenLayers\Model\Ol;

class Base extends Ol
{
    private static $base_class = true;

    private static $abstract = true;

    private static $db = [
        'visible' => 'Boolean',
    ];

    private static $has_one = [
        'Map' => 'AdminoPasswordo\\OpenLayers\\Model\\Map',
    ];
}
