
<html>
    <head>
        <meta charset="UTF-8">
        <title>Projeto 1</title>
        <link rel="stylesheet" href="app.css">
    </head>
    <body>
        <table width="100%" border=1 height="80%"><tr>
                <td width="50%"> <h1>Tela Inicial</h1></td>
                <td>
                    <div id="login"><form method="post" tex-align="right">
                            <table id="login">
                                <tr>
                                    <td> Email</td>     
                                    <td>Senha</td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email"></td>
                                    <td><input type="password" name="senha"></td>
                                    <td> <input type="submit" value="Entrar"></td>
                                </tr>
                                <tr><td><label id="autenticacao"></label></td></tr>
                            </table>           
                        </form></div>
                </td>
            </tr>
            <tr height="90%">
                <td>  <div id="map"></div></td>
                <td>
                    <form method="post"><center>
                            <h2>Cadastro de Usuário</h2>
                            Nome <input type="text" name="cadNome"><br><br>
                            Email <input type="text" name="cadEmail"><br><br>
                            Senha <input type="password" name="cadSenha"><br><br>
                            <label id="cadastro"></label><br><br>
                            <input type="submit" value="Cadastrar">
                        </center>
                    </form>
                </td>
            </tr>
        </table>
        <br>
        <br><br>
    </body>
</html>
<?php
$con = pg_connect("host=localhost port=5432 user=postgres password='flavio22'"
        . "dbname=projetoI-BancoII") or die("erro na conexão com banco!");

if (isset($_POST["email"]) && isset($_POST["senha"])) {
    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $sql = "SELECT * FROM USUARIO WHERE email='$email' AND senha='$senha'";
    $result = pg_query($con, $sql);
    $row = pg_fetch_array($result);
    if ($row > 0) {
        echo "<script>alert('Bem vindo, " . $row["nome"] . "!');</script>";
    } else {
        echo"<script>autenticacao.innerHTML='Usuário não encontrado';</script>"
        . "<style>#autenticacao{color:red;}</style>";
    }
}

if (isset($_POST["cadEmail"]) && isset($_POST["cadNome"]) &&
        isset($_POST["cadSenha"])) {

    $sql = "SELECT email FROM Usuario WHERE email='" . $_POST['cadEmail'] . "'";
    $result = pg_query($con, $sql);
    if (pg_num_rows($result) > 0) {
        echo "<script> cadastro.innerHTML='Este email já está sendo"
        . " utilizado!';</script> <style>#cadastro{color:red;}</style>";
    } else {
        $cadastro = "INSERT INTO Usuario (nome,email,senha) VALUES('"
                .$_POST["cadNome"]."','".$_POST["cadEmail"]."','".$_POST["cadSenha"]."')";
        pg_exec($con, $cadastro);
        echo "<script>cadastro.innerHTML='Usuário cadastrado com sucesso!';</script>"
        . " <style>#cadastro{color:green;}</style>";
    }
}

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
?>  
