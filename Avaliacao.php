<?php 
    session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="Css/app.css">
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
                </td>
                <td>
            <center>        
                <form method="post" >
                        <input type="hidden" id="codigo" name="codigo" ><br>
                    <input type="hidden" name="email" id="email"><br>
                    <b><h2 class="avaliacao" id="titulo">Avaliação</h2></b>
                    <input type="number" name="nota" min="0" max="10"  id="nota" class="avaliacao"><br><br>
                    <textarea type="text" rows=7 id="comentario" name="comentario" 
                              maxlength=140 class="avaliacao"> </textarea><br><br>
                    <input type="submit" value="Avaliar" id="botao">         
                </form>
                <a href="index.php"> Voltar</a>
            </center>
        </td>
    </tr>
</table>
</body>
</html>
<?php
require_once 'Controle/ControleLocalidade.php';
require_once 'Controle/ControleAvaliacao.php';
require_once 'Modelo/Usuario.php';

$controladorLocalidade = new ControleLocalidade();
$controladorAvaliacao = new ControleAvaliacao();

if (isset($_POST["latMarker"]) && $_POST["lngMarker"]) {
    $result = $controladorLocalidade->paginaLocalidade($_POST["latMarker"], 
            $_POST["lngMarker"]);
    $row = pg_fetch_array($result);
    
    echo "<script> nome.innerHTML='" . $row['nome'] . "'; end.innerHTML='Endereço: "
    . "" . $row['rua'] . " <br>"
    . "" . $row['bairro'] . "- " . $row['cidade'] . "'; horario.innerHTML='Horário: "
    . $row['inicio'] . " - " . $row['fim'] . "'</script> ";
    echo "<script> codigo.value='" . $row['codigo'] . "';</script>";

    echo "<style>#nome{color:#B22222;"
    . "font-size:40px;} #end{font-size:30px;} #horario{font-size:30px;}</style>";


    echo "<script>media.innerHTML='Média das avaliações: " . 
            $controladorAvaliacao->calculaMedia($row['codigo']) . "';</script>"
            . "<style>#media{font-size:30px; }</style>";
    $controladorAvaliacao->getComentarios($row["codigo"]);
    echo "<head><title>".$row["nome"]."</title></head>";
}

if (isset($_SESSION["usuario"])) {
    
    $obj = unserialize($_SESSION["usuario"]);
    $controladorAvaliacao->verificarUsuario($obj->getEmail(),
            $_POST["latMarker"],$_POST["lngMarker"]);
}

if (isset($_POST["email"]) && isset($_POST["nota"]) && isset($_POST["comentario"])) {
    
    $controladorAvaliacao->avaliar(unserialize($_SESSION["usuario"])->getEmail(), 
            $_POST["nota"], $_POST["comentario"], 
            $_POST["codigo"]);
}