
<html>
    <head>
        <meta charset="UTF-8">
        <title>Projeto 1</title>
        <link rel="stylesheet" href="mapa.css">
    </head>
    <body>

        <br>
        <h1>Tela Inicial</h1>
        <form method="post" >
            <table id="login">
                <tr>
                    <td>
                        Email
                    </td>
                    <td>
                        Senha
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type="text" name="email">
                    </td>
                    <td>
                        <input type="password" name="senha">
                    </td>
                    <td>
                        <input type="submit">
                    </td>
                </tr>
            </table>
           
        </form>
        <br><br>
        <div id="map"></div>


    </body>
</html>
<?php
$con = pg_connect("host=localhost port=5432 user=postgres password='flavio22'"
        . "dbname=projetoI-BancoII") or die("erro na conexão com banco!");

if (isset($_POST["email"]) && isset($_POST["senha"])){
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $sql = "SELECT * FROM USUARIO WHERE email=$email AND senha=$senha";
    $result = pg_query($con,$sql);
    if($row = pg_fetch_all($result)>0){
        $nome = $row[]
        echo "<script>alert('Bem vindo,');</script>";
    }
    
}

echo " <script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -34.397, lng: 150.644},
          zoom: 14
        });
        var infoWindow = new google.maps.InfoWindow({map: map});

        // Try HTML5 geolocation.
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(function(position) {
            var pos = {
              lat: position.coords.latitude,
              lng: position.coords.longitude
            };

            infoWindow.setPosition(pos);
            infoWindow.setContent('Você está aqui.');
            map.setCenter(pos);
          }, function() {
            handleLocationError(true, infoWindow, map.getCenter());
          });
        } else {
          // Browser doesn't support Geolocation
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
?>
