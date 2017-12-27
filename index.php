<html>
    <head>
        <meta charset="UTF-8">
        <title>Projeto 1</title>
        <link rel="stylesheet" href="Css/app.css">
    </head>
    <body>
        <table width="100%" height="80%" class="tabela"><tr bgcolor="#B0E0E6">
                <td width="50%"> <h1>Tela Inicial</h1>
                    <b> <label id="nomeUsuario"></label></b>
                </td>
                <td>
                    <div id="login"><form method="post" tex-align="right">
                            <table>
                                <tr>
                                    <td><b>Email</b></td>     
                                    <td><b>Senha</b></td>
                                </tr>
                                <tr>
                                    <td><input type="text" name="email"></td>
                                    <td><input type="password" name="senha"></td>
                                    <td> <input type="submit" value="Entrar"></td>
                                </tr>
                                <tr><td><label id="autenticacao"></label></td></tr>
                            </table>           
                        </form></div>
                </td>
            </tr>
            <tr height="90%">
                <td>
                    <form method="post">
                        <input type="text" name="buscaNome" placeholder="Nome da localidade">
                        <input type="submit" value="Buscar">
                    </form>
                    <form method="post">
                        <input type="text" name="buscaEndereco" placeholder="Endereço">
                        <input type="submit" value="Buscar">
                    </form>
                    <label id="resultadoBusca"></label>
                    <div id="map"></div><br><br>
            <center>
                <form method="post" action="Localidade.php">
                    <input type="hidden" name="user" id="user">
                    <input type="hidden" name="userPass" id="userPass"><br>
                    <button id="btCadastrar">CADASTRAR LOCALIDADE</button>
                </form>
            </center>
        </td>
        <td>
            <form method="post"><center>
                    <h2>Cadastro de Usuário</h2>
                    Nome <input type="text" name="cadNome"><br><br>
                    Email <input type="text" name="cadEmail"><br><br>
                    Senha <input type="password" name="cadSenha"><br><br>
                    <label id="cadastro"></label><br><br>
                    <input type="submit" value="Cadastrar">
                </center>
            </form>
        </td>
    </tr>
</table>
<br>
<br><br>
</body>
</html>
<?php
require_once 'Controle/controleUsuario.php';
require_once 'Controle/mapa.php';

if (isset($_POST["buscaNome"])) {

    require_once 'Controle/ControleLocalidade.php';
    buscarNome($_POST["buscaNome"]);
    
} else if (isset($_POST["email"]) && isset($_POST["senha"])) {

    $email = $_POST["email"];
    $senha = $_POST["senha"];
    autenticar($email, $senha);
    initMap();
    
} else if (isset($_POST["cadEmail"]) && isset($_POST["cadNome"]) &&
        isset($_POST["cadSenha"])) {

    $cadEmail = $_POST["cadEmail"];
    $cadNome = $_POST["cadNome"];
    $cadSenha = $_POST["cadSenha"];

    echo "<script>cadastro.innerHTML='" . 
            cadastrarUsuario($cadEmail, $cadNome, $cadSenha) . "';</script>";
    
            initMap();
} else {
    initMap();
}
?>  
