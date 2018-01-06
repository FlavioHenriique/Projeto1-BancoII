<?php

function initMap() {
    require_once 'conexao.php';
    $con = getConnection();
    $sql = "SELECT latitude,longitude,nome,codigo FROM localidade";
    $result = pg_query($con, $sql);
    $sqlmedias = "select cast(avg(a.nota) as numeric(10,1)),a.codigolocalidade
        from avaliacao a, localidade l
    where a.codigolocalidade=l.codigo group by codigolocalidade, l.nome";

    echo " <script>        
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 14
        });     
        var infoWindow = new google.maps.InfoWindow({map: map});
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };";
    while ($row = pg_fetch_array($result)) {
        echo "var marker = new google.maps.Marker({
      position: {lat: " . $row['latitude'] . ",lng: " . $row['longitude'] . "},
      map: map, ";

        $resultado = pg_query($con, $sqlmedias);
        while ($linha = pg_fetch_array($resultado)) {
            if ($row["codigo"] === $linha["codigolocalidade"]) {

                if ($linha["avg"] >= 7) {
                    echo "icon: 'Images/verde.png',";
                } else if ($linha["avg"] >= 4 && $linha["avg"] < 7) {
                    echo "icon: 'Images/amarelo.png',";
                }
            }
        }

        echo "animation: google.maps.Animation.DROP,
     title: '" . $row["nome"] . "'
});
            
           marker.addListener('click', function(event){
            latMarker.value=  event.latLng.lat().toFixed(6);
           lngMarker.value =  event.latLng.lng().toFixed(6);          
           document.avaliacao.submit();
});
";
    }
    echo " 
            infoWindow.setPosition(pos);
            infoWindow.setContent('Você está aqui.');
            map.setCenter(pos); 
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
         handleLocationError(false, infoWindow, map.getCenter());
        }
      }
      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }
    
    </script>
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCHoafMtF7Sv5XiUhhTpnqv82PaGuFM3u4&callback=initMap'
    async defer></script>";
}

function addLocalidade() {

    require_once 'conexao.php';
    $con = getConnection();
    $sql = "SELECT latitude,longitude,nome FROM localidade";
    $result = pg_query($con, $sql);

    echo " <script>   
        function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 14
        });
        var infoWindow = new google.maps.InfoWindow({map: map});
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };";
    while ($row = pg_fetch_array($result)) {
        echo "var marker = new google.maps.Marker({
      position: {lat: " . $row['latitude'] . ",lng: " . $row['longitude'] . "},
      map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
     title: '" . $row["nome"] . "'});";
    }
    echo"
            infoWindow.setPosition(pos);
            infoWindow.setContent('Você está aqui!');
            map.setCenter(pos);
            
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
         handleLocationError(false, infoWindow, map.getCenter());
        }
       
   google.maps.event.addListener(map, 'click', function(event) {
   
      var lat = event.latLng.lat().toFixed(6);
      var lng = event.latLng.lng().toFixed(6);
      
      var marker = new google.maps.Marker({
      position:  new google.maps.LatLng(lat, lng),
      map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
     title: 'marcador 1'
  });
    
    latitude.value=lat;
    longitude.value=lng;
   });

      }
      function handleLocationError(browserHasGeolocation, infoWindow, pos) {
        infoWindow.setPosition(pos);
        infoWindow.setContent(browserHasGeolocation ?
                              'Error: The Geolocation service failed.' :
                              'Error: Your browser doesn\'t support geolocation.');
      }
    </script>
    <script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCHoafMtF7Sv5XiUhhTpnqv82PaGuFM3u4&callback=initMap'
    async defer></script>
";
}

function localizarNome($lat, $lng) {

    require_once 'conexao.php';
    $con = getConnection();
    $sql = "SELECT latitude,longitude,nome,codigo FROM localidade";
    $result = pg_query($con, $sql);
    $sqlmedias = "select cast(avg(a.nota) as numeric(10,1)),a.codigolocalidade
        from avaliacao a, localidade l
    where a.codigolocalidade=l.codigo group by codigolocalidade, l.nome";


    echo "<script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: $lat, lng: $lng},
          zoom: 15
        });";
    while ($row = pg_fetch_array($result)) {
        echo"var marker = new google.maps.Marker({
      position: {lat: " . $row['latitude'] . ",lng: " . $row['longitude'] . "},
      map: map,";

        $resultado = pg_query($con, $sqlmedias);
        while ($linha = pg_fetch_array($resultado)) {
            if ($row["codigo"] === $linha["codigolocalidade"]) {

                if ($linha["avg"] >= 7) {
                    echo "icon: 'Images/verde.png',";
                } else if ($linha["avg"] >= 4 && $linha["avg"] < 7) {
                    echo "icon: 'Images/amarelo.png',";
                }
            }
        }

        if ($row["latitude"] === $lat && $row["longitude"] === $lng) {
            echo "animation: google.maps.Animation.BOUNCE, "
            . " title: '" . $row['nome'] . "'
});
";
        } else {
            echo"
animation: google.maps.Animation.DROP,
 title: '" . $row["nome"] . "'
});
";
        }
        echo "marker.addListener('click', function(event){
latMarker.value = event.latLng.lat().toFixed(6);
lngMarker.value = event.latLng.lng().toFixed(6);

document.avaliacao.submit();
});
";
    }
    echo "
}
</script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyCHoafMtF7Sv5XiUhhTpnqv82PaGuFM3u4&callback=initMap'
async defer></script>";
}
