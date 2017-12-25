
<html>
    <head>
        <meta charset="UTF-8">
        <title>Cadastrar localidade</title>
        <link rel="stylesheet" href="Css/app.css">
    </head>
    <body>
        <table width="100%" height="80%">
            <tr width="100%">
                <td width="70%">
                    <div id="map"></div>
                </td>
                <td>
                    <form method="post" action="CadastroLocalidade.php" name="formulario">
                        <input type="text" id="latitude">
                        <input type="text" id="longitude">
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php
require_once 'Controle/mapa.php';

addLocalidade();
