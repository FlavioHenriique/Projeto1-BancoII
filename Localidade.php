
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar localidade</title>
        <link rel="stylesheet" href="Css/app.css">
    </head>
    <body><br>
        <table width="100%" height="80%">
            <tr width="100%">
                <td width="70%">     
                    <div id="mapa"></div>
                </td>
                <td>
            <center>
                <form method="post" align="left">
                    <input type="hidden" name="user" id="user">
                    <input type="hidden" name="latitude" id="latitude"/>
                    <input type="hidden" name="longitude" id="longitude"/><br>
                    <h2>Cadastro de localidade</h2>

                    <input type="text" name="nome"  placeholder="Nome">
                    <br><br>
                    <input type="text" name="entrada" placeholder="Horário de entrada"> 
                    <br><br>
                    <input type="text" name="saida" placeholder="Horário de saída">
                    <br><br>
                    <br>
                    <input type="submit" value="Cadastrar">
                </form>

                <a href="index.php">Voltar</a>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
<?php
require_once 'Controle/mapa.php';



if (isset($_POST['user']) && isset($_POST['userPass'])) {

    echo "<script>user.value='" . $_POST['user'] . "';"
    . "senhaUser.value='" . $_POST['userPass'] . "';"
    . "emailUser.value='" . $_POST['user'] . "';</script>";

    addLocalidade();
}

if (isset($_POST["latitude"]) && isset($_POST["longitude"]) &&
        isset($_POST["nome"]) && isset($_POST["entrada"]) && isset($_POST["saida"])) {

    require_once 'Controle/ControleLocalidade.php';

    $endereco = geocodificar($_POST["latitude"], $_POST["longitude"]);
    header("Location: Localidade.php?usuario=" . $_POST["user"]);
    addLocalidade();

    salvarLocalidade($_POST['latitude'], $_POST['longitude'], $_POST['nome'], $_POST['entrada'], $_POST['saida'], $_POST['user'], $endereco["route"], $endereco["sublocality_level_1"], $endereco["administrative_area_level_2"]);
}
addLocalidade();
