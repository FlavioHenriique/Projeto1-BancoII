
<html>
    <head>
        <meta charset="UTF-8">
        <title>Informações sobre a localidade</title>
    </head>
    <body>

        <table width="100%">
            <tr>
                <td>
                    <label id="nome"></label><br>
                    Endereço: <label id="end"></label><br>
                    Horário: <label id="horario"></label>
                </td>
                <td>
            <center>
                
                <form method="post">
                    <input type="text" id="codigo" name="codigo"><br>
                    <input type="text" name="email" id="email"><br>
                    <h1>Avaliação</h1><br>
                    <input type="number" name="nota" min="0" max="10"><br><br>
                    <textarea name="comentario"></textarea><br><br>
                    <input type="submit" value="Avaliar">
                </form>
            </center>
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
    
    echo "<script> nome.innerHTML='" . $row['nome'] . "'; end.innerHTML='" . $row['rua'] . ", "
    . "" . $row['bairro'] . ", " . $row['cidade'] . "'; horario.innerHTML='"
    . $row['inicio'] . "-" . $row['fim'] . "'</script> ";
    echo "<script>email.value='".$_POST['avaliador']."';"
            . "codigo.value='".$row['codigo']."';</script>";
}

if (isset($_POST["email"]) && isset($_POST["nota"]) && isset($_POST["comentario"])){
    
    require_once 'Controle/ControleAvaliacao.php';
    
    avaliar($_POST["email"], $_POST["nota"], $_POST["comentario"], $_POST["codigo"],$_POST["email"]);
}