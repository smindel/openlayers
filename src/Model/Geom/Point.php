<?php

namespace AdminoPasswordo\OpenLayers\Model\Geom;

class Point extends SimpleGeometry
{
    private static $db = [
        'Coordinates' => 'Varchar(255)',
    ];
}
