<?php

namespace AdminoPasswordo\OpenLayers;

use SilverStripe\Core\Object;
use SilverStripe\Forms\FormField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\NumericField;
use SilverStripe\View\Requirements;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Control\RequestHandler;
use SilverStripe\ORM\DataModel;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Admin\LeftAndMain;

class EditorField extends FormField
{
    private static $url_handlers = [
        'ITEM/$ID/$Action' => '$Action',
    ];

    protected $components = [];

    protected $record;

    public function __construct($name, $title = null, $value = null)
    {
        parent::__construct($name, $title, $value);

        $this->addComponents([
            'form-field' => EditorFormFieldComponent::create(),
            'edit-button' => EditorEditButtonComponent::create(),
            'detail-form' => EditorDetailFormComponent::create($this),
        ]);
    }

    public function setRecord($record)
    {
        $this->record = $record;
        return $this;
    }

    public function getRecord()
    {
        return $this->record;
    }

    public function hasAction($action)
    {
        return in_array($action, ['EDIT', 'getEditForm', 'field']) || parent::hasAction($action);
    }

    public function checkAccessAction($action)
    {
        return in_array($action, ['EDIT', 'getEditForm', 'field']) || parent::checkAccessAction($action);
    }

    public function handleAction($request, $action)
    {
        if (in_array($action, ['EDIT', 'getEditForm', 'field'])) return $this->getComponent('detail-form');
        return parent::handleAction($request, $action);
    }

    public function removeComponent($name)
    {
        if (isset($this->components[$name])) unset($this->components[$name]);
        return $this;
    }

    public function addComponents($components)
    {
        foreach ($components as $name => $component) $this->components[$name] = $component;
        return $this;
    }

    public function getComponent($name)
    {
        return $this->components[$name];
    }

    public function Field($properties = [])
    {
        Requirements::css('openlayers/client/dist/styles/EditorField.css');
        foreach ($this->components as $component) {
            if (!$component->hasMethod('render')) continue;
            $priority = $component->priority();
            $elements[$priority][] = $component;
        }

        ksort($elements);
        $html = '';

        foreach ($elements as $elems) foreach ($elems as $element) {
            $html .= $element->render($this);
        }

        return $html;
    }
}

class EditorComponent extends Object
{
    protected $priority = 50;

    public function priority()
    {
        return $this->priority;
    }
}

class EditorFormFieldComponent extends EditorComponent
{
    public function render($field)
    {
        return NumericField::create($field->getName(), $field->Title(), $field->Value())->Field();
    }
}

class EditorEditButtonComponent extends EditorComponent
{
    public function render($field)
    {
        return sprintf('<a href="%s/ITEM/%s/EDIT">edit</a>', $field->Link(), $field->Value() ?: 'new');
    }

    public function getURLHandlers()
    {
        return ['EDIT' => 'getDetailForm'];
    }

    public function getDetailForm($editorField, $request)
    {
        $editorField->getComponent('detail-form')->getEditForm($editorField);
    }
}

class EditorDetailFormComponent extends RequestHandler
{
    private static $url_handlers = array(
        '$Action!' => '$Action',
        'getEditForm' => 'getEditForm',
        'doSave' => 'doSave',
        '' => 'edit',
    );

    private static $allowed_actions = [
        'edit',
        'doSave',
        'getEditForm',
        'field',
    ];

    protected $editorField;

    public function __construct($editorField)
    {
        parent::__construct();
        $this->editorField = $editorField;
    }

    public function Link($action = null)
    {
        return Controller::join_links(
            $this->editorField->Link('ITEM'),
            $this->editorField->getRecord()->ID ?: 'new',
            $action
        );
    }

    public function getEditForm()
    {
        $dataObject = $this->editorField->getRecord();
        $fields = $dataObject->getCMSFields();
        $actions = FieldList::create(
            FormAction::create('doSave', 'save')->setUseButtonTag(true)
            ->addExtraClass('btn-primary font-icon-save'),
            FormAction::create('delete', 'delete'),
            FormAction::create('cancel', 'cancel')
        );
        $form = Form::create($this, __FUNCTION__, $fields, $actions);
        $form->loadDataFrom($dataObject);

        if (Controller::curr() instanceof LeftAndMain) {
            // Always show with base template (full width, no other panels),
            // regardless of overloaded CMS controller templates.
            // TODO Allow customization, e.g. to display an edit form alongside a search form from the CMS controller
            $form->setTemplate([
                'type' => 'Includes',
                'SilverStripe\\Admin\\LeftAndMain_EditForm',
            ]);
            $form->addExtraClass('cms-content cms-edit-form center fill-height flexbox-area-grow');
            $form->setAttribute('data-pjax-fragment', 'CurrentForm Content');
            if ($form->Fields()->hasTabSet()) {
                $form->Fields()->findOrMakeTab('Root')->setTemplate('SilverStripe\\Forms\\CMSTabSet');
                $form->addExtraClass('cms-tabset');
            }

            $form->Backlink = $this->getBackLink();
        }
        return $form;
    }

    public function field($request)
    {
        return $this->getEditForm()->Fields()->dataFieldByName($request->shift());
    }

    public function edit($request)
    {
        $controller = Controller::curr();
        $form = $this->getEditForm();

        $return = $this->customise(array(
            'Backlink' => $controller->hasMethod('Backlink') ? $controller->Backlink() : $controller->Link(),
            'ItemEditForm' => $form,
        ))->renderWith('EditorDetailFormComponent');

        if ($request->isAjax()) {
            return $return;
        } else {
            // If not requested by ajax, we need to render it within the controller context+template
            return $controller->customise(array(
                // TODO CMS coupling
                'Content' => $return,
            ));
        }
    }

    public function doSave()
    {
        var_dump(func_get_args());die;
    }

    public function getBackLink()
    {
        return $this->editorField->getForm()->getController()->Link();
    }
}
