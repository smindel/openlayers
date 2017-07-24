<?php

namespace AdminoPasswordo\OpenLayers\Model;

use SilverStripe\ORM\DataObject;

class View extends Ol
{
    private static $base_class = true;

    private static $db = [
        'Center' => 'Varchar',
        'Zoom' => 'Int',
        'Projection' => 'Varchar',
    ];

    private static $belongs_to = [
        'Map' => 'AdminoPasswordo\\OpenLayers\\Model\\Map',
    ];

    private static $defaults = [
        'Center' => '[0, 0]',
        'Zoom' => '10',
    ];
}
