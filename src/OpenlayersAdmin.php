<?php

namespace AdminoPasswordo\Openlayers;

use SilverStripe\Admin\ModelAdmin;

class OpenlayersAdmin extends ModelAdmin
{
    private static $menu_title = 'Openlayers';

    private static $url_segment = 'openlayers';

    private static $managed_models = [
        'AdminoPasswordo\\OpenLayers\\Model\\Map',
    ];
}
