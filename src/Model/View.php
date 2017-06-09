<?php

namespace AdminoPasswordo\OpenLayers\Model;

use SilverStripe\ORM\DataObject;

class View extends Ol
{
    private static $base_class = true;

    private static $db = [
        'center' => 'Varchar',
        'zoom' => 'Int',
    ];

    private static $has_one = [
        'Map' => 'AdminoPasswordo\\OpenLayers\\Model\\Map',
    ];
}
