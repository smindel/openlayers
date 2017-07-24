new ol.Map({
  view: $View,
  layers: [
    <% loop $Layers %>
      $Me<% if not $Last %>,<% end_if %>
    <% end_loop %>
  ],
  target: '{$Identifier}'
})
