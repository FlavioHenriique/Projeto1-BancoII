<?php
session_start();
?>
<html>

    <head>
        <meta charset="UTF-8">
        <title>Cadastrar localidade</title>
        <link rel="stylesheet" href="Css/bootstrap.css">
        <link rel="stylesheet" href="Css/clockface.css">
        <link rel="stylesheet" href="Css/app.css">


    </head>
    <body><br>
        <table width="100%" height="80%">
            <tr width="100%">
                <td width="70%">     
                    <div id="mapa"></div>
                </td>
                <td width="10%"></td>
                <td>
            
               
                <form method="post" align="left">
                    <input type="hidden" name="latitude" id="latitude"/>
                    <input type="hidden" name="longitude" id="longitude"/><br>
                    <h2>Cadastro de localidade</h2>
                    <br>
                    <input type="text" name="nome" placeholder="Nome" maxlength="50" >
                    <br><br>
                    <div class="input-append">
                        <input id="entrada" class="input-small" readonly="true" 
                               type="text" placeholder="Horário de entrada" name="entrada">
                        <button class="btn" type="button" id="toggle-btn">
                            <i class="icon-time"></i>
                        </button>
                    </div>
                    <br>
                    <div class="input-append">
                        <input id="saida" class="input-small" readonly="true" 
                               type="text" placeholder="Horário de saída" name="saida">
                        <button class="btn" type="button" id="toggle-btn2">
                            <i class="icon-time"></i>
                        </button>
                    </div> 
                    <br>
                    <input type="submit" value="Cadastrar">
                </form>

                <a href="index.php">Voltar</a>
           
        </td>
    </tr>
</table>
</body>
<script src="JS/bootstrap.js"></script>
<script src="JS/jquery.js"></script>
<script src="JS/clockface.js"></script>
<script>
    $(function () {
        $('#entrada').clockface({
            format: 'HH:mm',
            trigger: 'manual'
        });

        $('#toggle-btn').click(function (e) {
            e.stopPropagation();
            $('#entrada').clockface('toggle');
        });
    });
     $(function () {
        $('#saida').clockface({
            format: 'HH:mm',
            trigger: 'manual'
        });

        $('#toggle-btn2').click(function (e) {
            e.stopPropagation();
            $('#saida').clockface('toggle');
        });
    });
</script>
</html>
<?php
require_once 'Controle/mapa.php';
require_once 'Controle/ControleLocalidade.php';
require_once 'Modelo/Localidade.php';
require_once 'Modelo/Usuario.php';

$controladorLocalidade = new ControleLocalidade();
$mapa = new mapa();


if (isset($_POST["latitude"]) && isset($_POST["longitude"]) &&
        isset($_POST["nome"]) && isset($_POST["entrada"]) && isset($_POST["saida"])) {


    $endereco = $controladorLocalidade->geocodificar($_POST["latitude"], $_POST["longitude"]);

    $mapa->addLocalidade();

    $localidade = new Localidade($_POST["latitude"], $_POST["longitude"], $_POST["nome"], $_POST["entrada"], $_POST["saida"], unserialize($_SESSION["usuario"])->getEmail(), $endereco["route"], $endereco["sublocality_level_1"], $endereco["administrative_area_level_2"]);

    $controladorLocalidade->salvarLocalidade($localidade);
}
$mapa->addLocalidade();
