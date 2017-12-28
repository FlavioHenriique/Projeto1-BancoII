
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
                <h1>Avaliação</h1><br>
                
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
}