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
                    
                    var path_html=
                    "<li class='breadcrumb-item'><a href='#'><i class='fa fa-globe'></i></a></li>"+
                    "<li class='breadcrumb-item'>"+continent_name+"</li>"+
                    "<li class='breadcrumb-item active'>"+contry_name+"</li>";

                    jQuery("#map_path").html(path_html);
                    
                    console.log(latlng_click);
                    map.setView([latlng_click.lat,latlng_click.lng],4);    
                });
            }
        }).addTo(map);
    })

})
