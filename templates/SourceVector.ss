new ol.source.Vector({
  $JsOptions.RAW,
  format: $Format,
  features: [<% loop $Features %>
    $Me<% if not $Last %>,<% end_if %>
  <% end_loop %>]
})
