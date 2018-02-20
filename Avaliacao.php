<?php
session_start();
require_once 'Controle/ControleLocalidade.php';
$controladorLocalidade = new ControleLocalidade();

if (isset($_POST["latMarker"]) && $_POST["lngMarker"]) {
    $controladorLocalidade->getLocalidade($_POST["latMarker"], $_POST["lngMarker"]);
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Css/app.css">
        <link rel="icon" href="Imagens/verde.png"  type="image/x-icon">
    </head>
    <body>
        <table width="100%" >
            <tr bgcolor="#B22222" class="topo">
                <td>
                    <br>
                    <h1>Avaliação de Localidade</h1>
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr  bgcolor="#F5F5F5">
                <td>
                    <label id="nome"></label><br>
                    <label id="end"></label><br>
                    <label id="horario"></label>
                    <br><br>
                    <label id="media"></label>
                    <br><br>

                </td>
                <td>
            <center>        
                <form method="post" >
                    <input type="hidden" name="codigo" id="codigo">
                    <b><h2 class="avaliacao" id="titulo">Avaliação</h2></b>
                    <input type="number" name="nota" min="0" max="10"  id="nota" class="avaliacao"><br><br>
                    <textarea type="text" rows=7 id="comentario" name="comentario" 
                              maxlength=140 class="avaliacao"> </textarea><br><br>
                    <div>
                        <input type="submit" value="Avaliar" id="botao">
                        <input type="submit" value="Remover avaliação" id="btRemover">
                    </div>         
                </form>

            </center>
        </td>
    </tr>
</table>

<?php
require_once 'Controle/ControleAvaliacao.php';
require_once 'Modelo/Usuario.php';

$controladorAvaliacao = new ControleAvaliacao();

if (isset($_SESSION["localidade"])) {
    $localidade = unserialize($_SESSION["localidade"]);
    $controladorLocalidade->paginaLocalidade($localidade);
}

if (isset($_SESSION["usuario"])) {

    $obj = unserialize($_SESSION["usuario"]);
    $controladorAvaliacao->verificarUsuario($obj->getEmail(), $localidade->getLatitude(), $localidade->getLongitude());
}

if (isset($_POST["nota"]) && isset($_POST["comentario"])) {

    $controladorAvaliacao->avaliar(unserialize($_SESSION["usuario"])->getEmail(), $_POST["nota"], $_POST["comentario"], $_POST["codigo"]);
}
?>
<center> 
    <br>
    <a href="index.php"><input type="submit" value="Voltar a página inicial"></a><br>
</center>
</body>
</html>