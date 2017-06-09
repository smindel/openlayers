<?php

namespace AdminoPasswordo\OpenLayers;

use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class EditorField extends CompositeField
{
    protected $template = 'EditorField';

    public static function from_dropdown(DropdownField $dropdown, $class)
    {
        $gridfield = GridField::create(rtrim($dropdown->Name, 'ID'), null, $class::get(), GridFieldConfig_RecordEditor::create());
        return EditorField::create([$dropdown,$gridfield]);
    }

    public function getDropdownField()
    {
        foreach ($this->children->dataFields() as $field) if (!($field instanceof GridField)) {
            return $field;
        }
    }

    public function getGridField()
    {
        foreach ($this->children->dataFields() as $field) if ($field instanceof GridField) {
            return $field;
        }
    }

    public function getGridFieldActions()
    {
        $gridfield = $this->GridField;
        $addnewbutton = $gridfield->getConfig()->getComponentByType('SilverStripe\Forms\GridField\GridFieldAddNewButton');
        $html = $addnewbutton->getHTMLFragments($gridfield);
        return $html;
    }
}
