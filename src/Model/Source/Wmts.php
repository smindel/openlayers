<?php

namespace AdminoPasswordo\OpenLayers\Model\Source;

use AdminoPasswordo\OpenLayers\Model\Ol;

class Wmts extends Tile
{
    private static $db = [
        'Url' => 'Varchar(255)',
        'Layer' => 'Varchar(255)',
        'Style' => 'Varchar(255)',
        'MatrixSet' => 'Varchar(255)',
    ];

    private static $has_one = [
        'TileGrid' => 'AdminoPasswordo\\OpenLayers\\Model\\Tilegrid\\Wmts',
    ];

    private static $defaults = [
    ];
}
