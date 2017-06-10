<?php

namespace AdminoPasswordo\OpenLayers;

use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class EditorField extends CompositeField
{
    protected $template = 'EditorField';
    protected $component;

    public static function from_dropdown(DropdownField $dropdown, $component, $class)
    {
        $gridfield = GridField::create(rtrim($dropdown->Name, 'ID'), null, $class::get(), GridFieldConfig_RecordEditor::create());
        $field = EditorField::create([$dropdown,$gridfield]);
        $field->component = $component;
        return $field;
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
        $gridfieldconfig = $gridfield->getConfig();

        $fragments = $gridfieldconfig
            ->getComponentByType('SilverStripe\Forms\GridField\GridFieldAddNewButton')
            ->getHTMLFragments($gridfield);
        $html = reset($fragments);

        foreach ($gridfieldconfig->getComponentsByType('SilverStripe\Forms\GridField\GridFieldEditButton') as $action) {
            $html->Value .= $action->getColumnContent($gridfield, $this->component, null);
        }

        foreach ($gridfieldconfig->getComponentsByType('SilverStripe\Forms\GridField\GridFieldDeleteAction') as $action) {
            $html->Value .= $action->getColumnContent($gridfield, $this->component, null);
        }

        return $html;
    }
}
