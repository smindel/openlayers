<?php

namespace AdminoPasswordo\OpenLayers\Model\Style;

class Icon extends Image
{
    private static $db = [
        'Anchor' => 'Varchar(255)',
        'Scale' => 'Varchar(255)',
    ];

    private static $has_one = [
        'Icon' => 'SilverStripe\\Assets\\Image',
    ];

    private static $defaults = [
        'Anchor' => '[.5, 1]',
    ];

    private static $js_options = [
        'anchor' => 'Anchor',
        'scale' => 'Scale',
        'src' => 'Src',
    ];

    private static $default_icon = "'https://upload.wikimedia.org/wikipedia/commons/thumb/e/ed/Map_pin_icon.svg/200px-Map_pin_icon.svg.png'";

    public function getSrc()
    {
        return $this->Icon()->exists() ? $this->Icon()->Filename : $this->config()->default_icon;
    }
}
