<?php

namespace AdminoPasswordo\OpenLayers\Model\Source;

use SilverStripe\Forms\LiteralField;

class Vector extends Source
{
    private static $db = [
        'Url' => 'Varchar(255)',
        'Format' => 'Varchar(255)',
    ];

    private static $has_one = [
        'Format' => 'AdminoPasswordo\\OpenLayers\\Model\\Format\\Feature',
    ];

    private static $many_many = [
        'Features' => 'AdminoPasswordo\\OpenLayers\\Model\\Feature',
    ];

    private static $belongs_to = [
        'Layer' => 'AdminoPasswordo\\OpenLayers\\Model\\Layer\\Vector',
    ];

    private static $template_candidates = ['SourceVector'];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $fields->addFieldToTab('Root.Editor', LiteralField::create('Editor', $this->Layer()->Map()->forTemplate()));
        return $fields;
    }
}
