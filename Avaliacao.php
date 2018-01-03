
<html>
    <head>
        <meta charset="UTF-8">
        <title>Informações sobre a localidade</title>
        <link rel="stylesheet" href="Css/app.css">
    </head>
    <body>
        <table width="100%">
            <tr>
                <td>
                    <label id="nome"></label><br>
                    <label id="end"></label><br>
                    <label id="horario"></label>
                    <br><br>
                    <label id="media"></label>
                </td>
                <td>
            <center>        
                <form method="post">
                    <input type="text" id="codigo" name="codigo" ><br>
                    <input type="text" name="email" id="email"><br>
                    <label id="titulo">Avaliação</label><br>
                    <input type="number" name="nota" min="0" max="10"  id="nota"><br><br>
                    <textarea name="comentario" id="comentario"></textarea><br><br>
                    <input type="submit" value="Avaliar" id="botao">
                </form>
            </center>
        </td>
    </tr>
    <tr>
        <td>
        </td>
    </tr>
</table>

</body>
</html>
<?php
require_once 'Controle/ControleLocalidade.php';


if (isset($_POST["latMarker"]) && $_POST["lngMarker"]) {
    $result = paginaLocalidade($_POST["latMarker"], $_POST["lngMarker"]);
    $row = pg_fetch_array($result);

    echo "<script> nome.innerHTML='" . $row['nome'] . "'; end.innerHTML='Endereço: "
    . "" . $row['rua'] . ", "
    . "" . $row['bairro'] . ", " . $row['cidade'] . "'; horario.innerHTML='Horário: "
    . $row['inicio'] . "-" . $row['fim'] . "'</script> ";
    echo "<script>email.value='" . $_POST['avaliador'] . "';"
    . "codigo.value='" . $row['codigo'] . "';</script>";

    echo "<style>#nome{color:blue;"
    . "font-size:40px;} #end{font-size:30px;} #horario{font-size:30px;}</style>";

    require_once 'Controle/ControleAvaliacao.php';

    echo "<script>media.innerHTML='Média das avaliações: " . 
            calculaMedia($row['codigo']) . "';</script>";
    getComentarios($row["codigo"]);
}

if (isset($_POST["avaliador"]) and $_POST["avaliador"] != "") {
    require_once 'Controle/ControleAvaliacao.php';
    verificarUsuario($_POST["avaliador"],$_POST["latMarker"],$_POST["lngMarker"]);
}

if (isset($_POST["email"]) && isset($_POST["nota"]) && isset($_POST["comentario"])) {

    require_once 'Controle/ControleAvaliacao.php';
    
    avaliar($_POST["email"], $_POST["nota"], $_POST["comentario"], $_POST["codigo"]);
}