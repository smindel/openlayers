new ol.layer.Vector({
  source: $Source,
  style: [<% loop $Style %>
    $Me<% if not $Last %>,<% end_if %>
  <% end_loop %>],
  $JsOptions.RAW
})
