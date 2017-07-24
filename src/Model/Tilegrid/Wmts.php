<?php

namespace AdminoPasswordo\OpenLayers\Model\Tilegrid;

use AdminoPasswordo\OpenLayers\Model\Ol;

class Wmts extends Ol
{
    private static $db = [
        'MatrixIds' => 'Varchar(255)',
        'Resolutions' => 'Text',
        'Origin' => 'Varchar(255)',
    ];

    private static $template_candidates = ['TilegridWmts'];
}
