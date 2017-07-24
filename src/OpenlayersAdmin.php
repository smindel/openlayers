<?php

namespace AdminoPasswordo\Openlayers;

use SilverStripe\Admin\ModelAdmin;

class OpenlayersAdmin extends ModelAdmin
{
    private static $menu_title = 'Openlayers';

    private static $url_segment = 'openlayers';

    private static $managed_models = [
        'AdminoPasswordo\\OpenLayers\\Model\\Map',
        'AdminoPasswordo\\OpenLayers\\Model\\View',
        'AdminoPasswordo\\OpenLayers\\Model\\Feature',
        'AdminoPasswordo\\OpenLayers\\Model\\Layer\\Base',
        'AdminoPasswordo\\OpenLayers\\Model\\Source\\Source',
        'AdminoPasswordo\\OpenLayers\\Model\\Geom\\Geometry',
        'AdminoPasswordo\\OpenLayers\\Model\\Format\\Feature',
        'AdminoPasswordo\\OpenLayers\\Model\\Style\\Style',
        'AdminoPasswordo\\OpenLayers\\Model\\Tilegrid\\Wmts',
    ];
}
