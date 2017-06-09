<?php

namespace AdminoPasswordo\OpenLayers\Model;

use SilverStripe\ORM\DataObject;

class Map extends Ol
{
    private static $base_class = true;

    private static $has_one = [
        'View' => 'AdminoPasswordo\\OpenLayers\\Model\\View',
    ];

    private static $has_many = [
        'Layers' => 'AdminoPasswordo\\OpenLayers\\Model\\Layer\\Base',
    ];
}
