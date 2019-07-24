var map;
var myGeoJSONPath = "/wp-content/plugins/wp-store-analytics/admin/res/custom.geo.json"; 
var mada_json_map = "/wp-content/plugins/wp-store-analytics/admin/res/mada.geojson"; 

jQuery(document).ready(function(){
    var myCustomStyle = {
            stroke: true,
            fill: true,
            fillColor: '#fff',
            fillOpacity: 1
    }
    
    map = L.map('map_view',{minZoom: 0,maxZoom: 6}).setView([52.482780222078226,0.3515625],2);

    jQuery.getJSON(myGeoJSONPath,function(data){
        L.geoJson(data, {
            clickable: true,
            style: myCustomStyle,
            onEachFeature: function (featureData, featureLayer) {
                featureLayer.on('click', function (ev) {
                    
                    var latlng_click = map.mouseEventToLatLng(ev.originalEvent);
                    var continent_name=featureData.properties.continent;
                    var contry_name=featureData.properties.brk_name;
                    var path_html=
                    "<li class='breadcrumb-item'><a href='#' id='init_map_position'><i class='fa fa-globe'></i></a></li>"+
                    "<li class='breadcrumb-item'>"+continent_name+"</li>"+
                    "<li class='breadcrumb-item active'>"+contry_name+"</li>";
                    jQuery("#map_path").html(path_html);
                    map.setView([latlng_click.lat,latlng_click.lng],6);
                    add_contry_layer(mada_json_map); 
                    map.flyTo([latlng_click.lat, latlng_click.lng], 6, {
                        animate: true,
                        duration: 1.5
                    }); 
                });
            }
        }).addTo(map);
    })

    function add_contry_layer($layer){
        jQuery.getJSON($layer,function(data){
            L.geoJson(data, {
                clickable: true,
                style: polystyle,
                onEachFeature: function (featureData, featureLayer) {
                    featureLayer.on('click', function (ev) {
                        
                    });
                }
            }).addTo(map);
        })
    }

    // Clustering
    var markers = [
        {
          "name":"Goroka",
          "city":"Goroka, Papua New Guinea",
          "iata_faa":"GKA",
          "icao":"AYGA",
          "lat":-18.822396,
          "lng":47.458386,
          "alt":5282,
          "tz":"Pacific/Port_Moresby"
        },{
          "name":"Madang",
          "city":"Madang, Papua New Guinea",
          "iata_faa":"MAG",
          "icao":"AYMD",
          "lat":-18.821396,
          "lng":47.448386,
          "alt":20,
          "tz":"Pacific/Port_Moresby"
        },{
          "name":"San Diego Old Town Transit Center",
          "city":"San Diego, United States",
          "iata_faa":"OLT",
          "lat":-18.822396,
          "lng":47.448386,
          "alt":0,
          "tz":"America/Los_Angeles"
        }
      ];
    var markerClusters = L.markerClusterGroup();
    for ( var i = 0; i < markers.length; ++i ){
    var popup = markers[i].name +
                '<br/>' + markers[i].city +
                '<br/><b>IATA/FAA:</b> ' + markers[i].iata_faa +
                '<br/><b>ICAO:</b> ' + markers[i].icao +
                '<br/><b>Altitude:</b> ' + Math.round( markers[i].alt * 0.3048 ) + ' m' +
                '<br/><b>Timezone:</b> ' + markers[i].tz;

    var m = L.marker( [markers[i].lat, markers[i].lng], {}).bindPopup( popup );
    markerClusters.addLayer( m );
    }
    map.addLayer( markerClusters );

      /*
      var rodents =   L.geoJson(markers,{
            pointToLayer: function(feature,latlng){
            var marker = L.marker([lat,lng],{});
            marker.bindPopup(feature.properties.Location + '<br/>' + feature.properties.OPEN_DT);
            return marker;
        }
    });
    var clusters = L.markerClusterGroup();
    clusters.addLayer(rodents);
    map.addLayer(clusters); 
    */
    
    

jQuery("#map_path").on('click',function(){
    //map.removeLayer(mada_json_map);
    console.log("#map_path");
    map.flyTo([52.482780222078226, 0.3515625], 2, {
        animate: true,
        duration: 1.5
    }); 
})

})

function polystyle(feature) {
    return {
        fillColor: 'blue',
        weight: 2,
        opacity: 1,
        color: 'white',  //Outline color
        fillOpacity: 0.7
    };
}



 