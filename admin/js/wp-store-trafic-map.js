jQuery(document).ready(function(){
    var myCustomStyle = {
            stroke: true,
            fill: true,
            fillColor: '#fff',
            fillOpacity: 1
    }
    var myGeoJSONPath = "/wp-content/plugins/wp-store-analytics/admin/res/custom.geo.json"; 
    console.log("chargement carte");
    jQuery.getJSON(myGeoJSONPath,function(data){
        var map = L.map('map_view').setView([52.482780222078226,0.3515625],1);
        L.geoJson(data, {
            clickable: true,
            style: myCustomStyle,
            onEachFeature: function (featureData, featureLayer) {
                featureLayer.on('click', function (ev) {
                    var latlng_click = map.mouseEventToLatLng(ev.originalEvent);
                    var continent_name=featureData.properties.continent;
                    var contry_name=featureData.properties.brk_name;
                    jQuery("#map_path").text(continent_name+"/"+contry_name);
                    console.log(latlng_click);
                    map.setView([latlng_click.lat,latlng_click.lng],4);    
                });
            }
        }).addTo(map);
    })

})
