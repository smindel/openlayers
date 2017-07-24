<?php

namespace AdminoPasswordo\OpenLayers\Model\Source;

use AdminoPasswordo\OpenLayers\Model\Ol;

class TileWMS extends Tile
{
    private static $db = [
        'Url' => 'Varchar(255)',
        'Params' => 'Varchar(255)',
        'Projection' => 'Varchar(255)',
    ];

    private static $defaults = [
        'Params' => "{LAYERS:''}",
    ];
}
