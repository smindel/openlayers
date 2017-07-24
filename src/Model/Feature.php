<?php

namespace AdminoPasswordo\OpenLayers\Model;

use SilverStripe\ORM\DataObject;

class Feature extends Ol
{
    private static $db = [
        'Name' => 'Varchar',
    ];

    private static $has_one = [
        'Geometry' => 'AdminoPasswordo\\OpenLayers\\Model\\Geom\\Geometry',
    ];

    private static $belongs_many_meny = [
        'Source' => 'AdminoPasswordo\\OpenLayers\\Source\\Vector',
    ];
}
