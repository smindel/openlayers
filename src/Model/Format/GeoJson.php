<?php

namespace AdminoPasswordo\OpenLayers\Model\Format;

class GeoJson extends JsonFeature
{
    private static $db = [
        'defaultDataProjection' => 'Varchar(255)',
        'featureProjection' => 'Varchar(255)',
    ];
}
