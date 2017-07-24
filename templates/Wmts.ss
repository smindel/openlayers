new ol.source.WMTS({
  $JsOptions.RAW,
  'tileGrid': $TileGrid,
  projection: ol.proj.get('EPSG:3857'),
  wrapX: true
})
