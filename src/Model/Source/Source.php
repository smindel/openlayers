<?php

namespace AdminoPasswordo\OpenLayers\Model\Source;

use AdminoPasswordo\OpenLayers\Model\Ol;

class Source extends Ol
{
    private static $belongs_to = [
        'Layer' => 'AdminoPasswordo\\OpenLayers\\Model\\Layer\\Layer',
    ];
}
