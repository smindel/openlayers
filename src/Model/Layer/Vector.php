<?php

namespace AdminoPasswordo\OpenLayers\Model\Layer;

class Vector extends Layer
{
    private static $has_one = [
        'Source' => 'AdminoPasswordo\\OpenLayers\\Model\\Source\\Vector',
    ];

    private static $many_many = [
        'Style' => 'AdminoPasswordo\\OpenLayers\\Model\\Style\\Style',
    ];

    private static $template_candidates = ['LayerVector'];
}
