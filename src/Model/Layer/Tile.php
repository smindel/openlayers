<?php

namespace AdminoPasswordo\OpenLayers\Model\Layer;

class Tile extends Layer
{
    private static $has_one = [
        'Source' => 'AdminoPasswordo\\OpenLayers\\Model\\Source\\Tile',
    ];
}
