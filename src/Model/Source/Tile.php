<?php

namespace AdminoPasswordo\OpenLayers\Model\Source;

use AdminoPasswordo\OpenLayers\Model\Ol;

class Tile extends Source
{
    private static $belongs_to = [
        'Layer' => 'AdminoPasswordo\\OpenLayers\\Model\\Layer\\Tile',
    ];
}
