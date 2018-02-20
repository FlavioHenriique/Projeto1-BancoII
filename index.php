<?php
session_start();
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Projeto 1</title>
        <link rel="stylesheet" href="Css/app.css">
        <link rel="icon" href="Imagens/verde.png"  type="image/x-icon">
    </head>
    <body>
        <table width="100%" height="100%" class="tabela"><tr bgcolor="#B22222" class="topo">
                <td width="50%"><h1>Tela Inicial</h1>
                    <b><label id="nomeUsuario"></label></b>
                </td>
                <td>
                    <div id="login"><form method="post" tex-align="right">
                            <table>
                                <tr>
                                    <td><b><label class="topo">Email</label></b></td>     
                                    <td><b><label class="topo">Senha</label></b></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email" maxlength="50"></td>
                                    <td><input type="password" name="senha" maxlength="50"></td>
                                    <td> <input type="submit" value="Entrar"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label id="autenticacao"></label>
                                    </td>
                                </tr>
                            </table>           
                        </form></div>
                </td>
            </tr>
            <tr height="90%" bgcolor="#F5F5F5">
                <td>
                    <table>
                        <tr>
                            <td>
                                <form method="post">
                                    <input type="text" name="buscaNome" 
                                           placeholder="Nome da localidade">
                                    <input type="submit" value="Buscar">
                                </form>
                            </td>
                            <td>
                                <form method="post">
                                    <input type="text" name="buscaEndereco" 
                                           placeholder="Endereço">
                                    <input type="submit" value="Buscar">
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td>    
                                <form method="post" name="avaliacao" id="avaliacao"
                                      action="Avaliacao.php">
                                    <input type="hidden" name="latMarker" id="latMarker">
                                    <input type="hidden" name="lngMarker" id="lngMarker">
                                </form>
                            </td>
                        </tr>
                    </table>
                    <div id="map"></div><br>
            <center>
                <a href="Localidade.php"><input type="submit" id="btCadastrar" 
                                                value="Cadastrar Localidade"></a>
            </center>
        </td>
        <td>
            <form method="post"><center>
                    <h2>Cadastro de Usuário</h2>
                    <input type="text" name="cadNome" class="palavras" 
                           placeholder="Nome" maxlength="50"><br><br>
                    <input type="text" name="cadEmail" class="palavras" 
                           placeholder="Email" maxlength="50"><br><br>
                    <input type="password" name="cadSenha" class="palavras" 
                           placeholder="Senha" maxlength="50"> <br><br>
                    <label id="cadastro"></label><br><br>
                    <input type="submit" value="Cadastrar">
                </center>   
            </form>
        </td>
    </tr>
</table>
</body>
</html>
<?php
require_once 'Controle/controleUsuario.php';
require_once 'Controle/mapa.php';
require_once 'Modelo/Usuario.php';
require_once 'Controle/ControleLocalidade.php';

$controladorUsuario = new controleUsuario();
$mapa = new mapa();
$controladorLocalidade = new ControleLocalidade();

if (isset($_SESSION["usuario"])) {
    $obj = unserialize($_SESSION["usuario"]);
    $controladorUsuario->autenticar($obj->getEmail(), $obj->getSenha());
}

if (isset($_POST["buscaEndereco"])) {

    $controladorLocalidade->buscarEndereco($_POST["buscaEndereco"]);
} else if (isset($_POST["buscaNome"])) {

    $controladorLocalidade->buscarNome($_POST["buscaNome"]);
} else if (isset($_POST["email"]) && isset($_POST["senha"])) {

    $email = $_POST["email"];
    $senha = $_POST["senha"];
    $controladorUsuario->autenticar($email, $senha);
    $mapa->initMap();
} else if (isset($_POST["cadEmail"]) && isset($_POST["cadNome"]) &&
        isset($_POST["cadSenha"])) {

    echo "<script>cadastro.innerHTML='" . $controladorUsuario->cadastrarUsuario
            ($_POST["cadEmail"], $_POST["cadNome"], $_POST["cadSenha"]) . "';</script>";
    $mapa->initMap();
} else {
    $mapa->initMap();
}
