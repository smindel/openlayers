<?php

namespace AdminoPasswordo\OpenLayers\Model;

use AdminoPasswordo\OpenLayers\EditorField;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\LookupField;

class Ol extends DataObject
{
    public function getCMSFields()
    {

        $fields = parent::getCMSFields();
        $fields->unshift(count($alternativeClasses = $this->Types) > 1 ? DropdownField::create('ClassName')->setSource($alternativeClasses) : DropdownField::create('ClassName')->setSource($alternativeClasses)->setDisabled(true));
        $fields->unshift(HeaderField::create('Title', $this->singular_name()));

        foreach ($this->hasOne() as $fieldName => $class) {
            if ($field = $fields->dataFieldByName($fieldName . 'ID')) $fields->replaceField($fieldName . 'ID', EditorField::from_dropdown($field, $this->$fieldName(), $class));
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
}
