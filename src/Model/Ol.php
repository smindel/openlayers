<?php

namespace AdminoPasswordo\OpenLayers\Model;

use AdminoPasswordo\OpenLayers\EditorField;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LookupField;
use SilverStripe\View\ArrayData;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\ArrayLib;
use SilverStripe\View\SSViewer;

class Ol extends DataObject
{
    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->unshift(count($alternativeClasses = $this->Types) > 1 ? DropdownField::create('ClassName')->setSource($alternativeClasses) : DropdownField::create('ClassName')->setSource($alternativeClasses)->setDisabled(true));
        $fields->unshift(HeaderField::create('Title', $this->singular_name()));

        foreach ($this->hasOne() as $fieldName => $class) {
            if ($field = $fields->dataFieldByName($fieldName . 'ID')) {
                $fields->replaceField(
                    $field->getName(),
                    EditorField::create($field->getName())->setRecord($this->$fieldName())
                );
            }
        }
        return $fields;
    }

    public function getTypes()
    {
        $types = [];
        $current = new \ReflectionClass($this);
        while(
            $current->getName() != __CLASS__ &&
            !Config::inst()->get($current->getName(), 'base_class')
        ) $current = $current->getParentClass();

        $baseClass = $current == __CLASS__ ? get_class($this) : $current->getName();

        $candidates = ClassInfo::subclassesFor($baseClass);

        // if (!($this instanceof Map)) var_dump([get_class($this), $baseClass, $candidates]);

        foreach ($candidates as $className) {
            if (Config::inst()->get($className, 'abstract', true)) continue;
            $types[$className] = singleton($className)->singular_name();
        }

        return $types;
    }

    public function forTemplate()
    {
        $candidates = $this->config()->template_candidates ?: array_map('SilverStripe\\Core\\ClassInfo::shortName', array_reverse(array_values(ClassInfo::ancestry($this))));
        return $this->renderWith($candidates);
    }

    public function getJsOptions($raw = false)
    {
        $config = ArrayLib::is_associative(
            $config = $this->config()->js_options ?: array_keys($this->config()->get('db'))
        ) ? $config : array_combine(array_map('lcfirst', $config), $config);

        $options = ArrayList::create([ArrayData::create(['Index' => '_dbId', 'Value' => $this->ID])]);

        foreach ($config as $name => $spec) {

            switch (true) {
                case $this->hasField($spec): $value = $this->$spec; break;
                case $this->hasMethod($spec): $value = $this->$spec(); break;
                default: throw new \Exception("JS option '$spec' for '$name' of " . get_class($this) . " can not be resolved.");
            }

            if ($value) {
                $item = ArrayData::create([
                    'Index' => $name,
                    'Value' => (string)$value,
                ]);

                $options->push($item);
            }
        }

        if ($raw) return $options;

        return SSViewer::fromString(
            '<% loop $JsOptions %>$Index: $Value.RAW<% if not $Last %>,<% end_if %><% end_loop %>'
        )->process(ArrayData::create(['JsOptions' => $options]));
    }
}
