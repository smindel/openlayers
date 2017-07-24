<?php

namespace AdminoPasswordo\OpenLayers\Model;

use SilverStripe\ORM\DataObject;
use SilverStripe\View\Requirements;

class Map extends Ol
{
    private static $base_class = true;

    private static $has_one = [
        'View' => 'AdminoPasswordo\\OpenLayers\\Model\\View',
    ];

    private static $has_many = [
        'Layers' => 'AdminoPasswordo\\OpenLayers\\Model\\Layer\\Base',
    ];

    public function getIdentifier()
    {
        return str_replace('\\', '_', self::CLASS) . '_' . $this->ID;
    }

    public function Javascript()
    {
        return parent::forTemplate();
    }

    public function forTemplate()
    {
        $html = $this->Javascript();

        Requirements::javascript('https://openlayers.org/en/v4.1.1/build/ol-debug.js');
        Requirements::css('https://openlayers.org/en/v4.1.1/css/ol.css');
        Requirements::customScript("

            var deb = function(type) {
                console.log(
                    type,
                    document.getElementById('Root_Editor').scrollWidth,
                    document.getElementById('Root_Editor').scrollHeight,
                    document.getElementById('{$this->Identifier}').scrollWidth,
                    document.getElementById('{$this->Identifier}').scrollHeight
                );
            }

            window.addEventListener(
                'load',
                function(event) {
                    this._maps = this._maps || {};
                    this._maps['{$this->Identifier}'] = {$html};

                    // var target = document.getElementById('Root_Editor'),
                    //     config = { attributes: true, childList: true, characterData: true },
                    //     observer = new MutationObserver(function(mutations) {
                    //         mutations.forEach(function(mutation) {
                    //             console.log(mutation.type);
                    //         });
                    //     });
                    // observer.observe(target, config);
                    deb('init');
                }
            );
            deb('load');
            document.getElementById('{$this->Identifier}').addEventListener('resize', function(){
                deb('resize');
            });
            window.setInterval(function(){ deb('timeout'); },2500);

            var target = document.getElementById('Root_Editor'),
                config = { attributes: true, childList: true, characterData: true },
                observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        console.log(mutation.type);
                        deb('mutate');
                        for(var i in window._maps) {
                            console.log(window._maps[i]);
                            window._maps[i].updateSize();
                        }
                        // observer.disconnect();
                    });
                });
            console.log(target, config, observer);
            observer.observe(target, config);
        ", $this->Identifier);

        return '<div id="' . $this->Identifier . '" class="' . str_replace('\\', '-', self::CLASS) . '" style="width:100%; min-height:500px;"></div>';
    }

    /**
     * http://openlayers.org/ol-cesium/
     */
    public function renderGlobe()
    {
        // call this first so the JS is imported in the correct order
        $output = $this->forTemplate();

        Requirements::javascript('openlayers/thirdparty/ol-cesium-v1.28/Cesium/Cesium.js');
        Requirements::javascript('openlayers/thirdparty/ol-cesium-v1.28/olcesium.js');
        Requirements::customScript("
            window.addEventListener(
                'load',
                function(event) {
                    var ol3d = new olcs.OLCesium({
                        map: this._maps['{$this->Identifier}']
                    });
                    var scene = ol3d.getCesiumScene();
                    scene.terrainProvider = new Cesium.CesiumTerrainProvider({
                        url: 'https://assets.agi.com/stk-terrain/world',
                        requestVertexNormals: true
                    });
                    scene.globe.enableLighting = true;
                    ol3d.setEnabled(true);
                }
            );
        ", $this->Identifier . '_globe');

        return $output;
    }
}
