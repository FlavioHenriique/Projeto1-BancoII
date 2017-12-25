<?php

require_once 'conexao.php';

function autenticar($email, $senha) {

    $con = getConnection();
    $sql = "SELECT * FROM USUARIO WHERE email='$email' AND senha='$senha'";
    $result = pg_query($con, $sql);
    $row = pg_fetch_array($result);
    if ($row > 0) {
        echo "<script>nomeUsuario.innerHTML='".$row["nome"]."';</script>";
    } else {
        echo"<script>autenticacao.innerHTML='Usuário não encontrado';</script>"
        . "<style>#autenticacao{color:red;}</style>";
    }
}

function cadastrarUsuario($cadEmail, $cadNome, $cadSenha) {

    $con = getConnection();
    $sql = "SELECT email FROM Usuario WHERE email='" . $cadEmail . "'";
    $result = pg_query($con, $sql);
    if (pg_num_rows($result) > 0) {
        return false;
    } else {
        $cadastro = "INSERT INTO Usuario (nome,email,senha) VALUES('"
                . $cadNome . "','" . $cadEmail . "','" . $cadSenha . "')";
        pg_exec($con, $cadastro);
        return true;
    }
}

function initMap() {
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
            };
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
