# Silverstripe Openlayers Module

## Getting started

1. Install the module.

2. Create a MapPage class in mysite:

    <?php

    use SilverStripe\Forms\DropdownField;
    use SilverStripe\Versioned\Versioned;

    class MapPage extends Page
    {
        private static $has_one = [
            'Map' => 'AdminoPasswordo\\OpenLayers\\Model\\Map'
        ];

        public function getCMSFields()
        {
            $fields = parent::getCMSFields();
            $fields->addFieldToTab('Root.Main', DropdownField::create('MapID', 'Map', AdminoPasswordo\OpenLayers\Model\Map::get()->map()), 'Content');
            return $fields;
        }

        public function requireDefaultRecords()
        {
            if (!MapPage::get()->count()) {

                $layer = AdminoPasswordo\OpenLayers\Model\Layer\Tile::create([
                    'SourceID' => AdminoPasswordo\OpenLayers\Model\Source\Osm::create()->write(),
                ]);
                $layer->write();

                $map = AdminoPasswordo\OpenLayers\Model\Map::create([
                    'ViewID' => AdminoPasswordo\OpenLayers\Model\View::create([
                        'Center' => '[9.9566064,53.5524565]',
                        'Zoom' => 14,
                        'Projection' => 'EPSG:3857',
                    ])->write(),
                ]);
                $map->write();
                $map->Layers()->add($layer);

                $page = MapPage::create([
                    'Title' => 'Map',
                    'MapID' => $map->ID,
                ]);
                $page->write();
                $page->copyVersionToStage(Versioned::DRAFT, Versioned::LIVE)();
            }
        }
    }

3. Add a template in themes/simple/templates/Layout/MapPage.ss

    [...]
    $Map
    [...]

4. Run dev/build

5. Navigate to http://localhost/map

## Challenges

- Create a CMS panel to manage ol objects
    * Create a HasOne relationship editor field
    * create an ol schema to express
