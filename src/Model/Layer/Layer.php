<?php

namespace AdminoPasswordo\OpenLayers\Model\Layer;

class Layer extends Base
{
    private static $abstract = true;

    private static $has_one = [
        'Source' => 'AdminoPasswordo\\OpenLayers\\Model\\Source\\Source',
    ];
}
