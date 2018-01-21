<?php

require_once 'Modelo/Localidade.php';
require_once 'mapa.php';
require_once 'conexao.php';

class ControleLocalidade {



    function geocodificar($lat, $long) {
        $url = "http://maps.googleapis.com/maps/api/geocode/json?latlng={$lat},{$long}&sensor=false";
        $content = @file_get_contents($url);
        $localizacao = array();
        
        if ($content) {
            $result = json_decode(file_get_contents($url), true);

            if ($result['status'] === 'OK') {
                foreach ($result['results'][0]['address_components'] as $component) {
                    switch ($component['types']) {
                        case in_array('administrative_area_level_2', $component['types']):
                            $localizacao['administrative_area_level_2'] = $component['long_name'];
                            break;
                        case in_array('sublocality_level_1', $component['types']):
                            $localizacao['sublocality_level_1'] = $component['long_name'];
                            break;
                        case in_array('route', $component['types']):
                            $localizacao['route'] = $component['long_name'];
                            break;
                    }
                }
            }
        }

        return $localizacao;
    }

    function salvarLocalidade( $localidade) {
        require_once 'conexao.php';
        $con = getConnection();
        var_dump($localidade);
        $sql = "INSERT INTO localidade(nome,rua,bairro,cidade,inicio,fim,latitude,"
                . "longitude,usuario)"
                . " VALUES('".$localidade->getNome()."','".$localidade->getRua()."','"
                .$localidade->getBairro()."','".$localidade->getCidade()."','"
                . "'".$localidade->getEntrada()."','".$localidade->getSaida()."','".$localidade->getLatitude()."','"
                 .$localidade->getLongitude()."','".$localidade->getUser()."')";
        pg_exec($con, $sql);
        echo "<script>alert('Localidade Cadastrada com sucesso!');"
        . "</script>";
    }

    function buscarNome($nome) {
        
        $mapa= new mapa();
        $con = getConnection();
        $sql = "SELECT latitude,longitude FROM localidade WHERE nome ilike '$nome'";
        $result = pg_query($con, $sql);

        $row = pg_fetch_array($result);
        $lat = $row["latitude"];
        $lng = $row["longitude"];
        
        
        $mapa->localizar($lat, $lng);
    }

    function buscarEndereco($endereco) {

        require_once 'conexao.php';
        require_once 'mapa.php';
        
        $mapa = new mapa();
        
        $con = getConnection();
        $sql = "SELECT latitude,longitude FROM localidade WHERE "
                . "rua ilike '$endereco' OR rua ilike '%$endereco' OR "
                . "rua ilike '$endereco%' OR rua ilike '%$endereco%'";
        $result = pg_query($con, $sql);
        $row = pg_fetch_array($result);
        $lat = $row["latitude"];
        $lng = $row["longitude"];

        $mapa->localizar($lat, $lng);
    }

    function paginaLocalidade($lat, $lng) {

        require_once 'conexao.php';
        $con = getConnection();
        $sql = "SELECT * FROM LOCALIDADE WHERE latitude='$lat' AND longitude='$lng'";
        $result = pg_query($con, $sql);
        return $result;
    }

}
