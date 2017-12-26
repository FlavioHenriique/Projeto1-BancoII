
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
                    <form method="post" >
                        <input type="hidden" name="user" id="user">
                        <input type="hidden" name="latitude" id="latitude"/>
                        <input type="hidden" name="longitude" id="longitude"/><br>
                        <h2>Cadastro de localidade</h2>
                        Nome:<input type="text" name="nome"><br><br>      
                        Horário de Entrada:<input type="text" name="entrada"><br><br>
                        Horário de Saída:<input type="text" name="saida"><br><br>
                        <input type="submit">
                    </form>
                </td>
            </tr>
        </table>
    </body>
</html>
<?php
require_once 'Controle/mapa.php';

addLocalidade();

if(isset($_POST['user'])){
    
    echo "<script>user.value='".$_POST['user']."'</script>";
}   

if (isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['nome'])
        && isset($_POST['entrada']) && isset($_POST['saida'])){
    
    require_once 'Controle/ControleLocalidade.php';
    
    $endereco = geocodificar($_POST['latitude'],$_POST['longitude']);
    
    salvarLocalidade($_POST['latitude'], $_POST['longitude'], $_POST['nome'],
            $_POST['entrada'], $_POST['saida'], $_POST['user'],$endereco['route'],
            $endereco['sublocality_level_1'],$endereco['administrative_area_level_2']);
}

        