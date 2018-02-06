<?php

class Localidade {

    private $latitude;
    private $longitude;
    private $nome;
    private $entrada;
    private $saida;
    private $user;
    private $rua;
    private $bairro;
    private $cidade;
    private $codigo;

    function __construct($latitude, $longitude, $nome, $entrada, $saida, $user, $rua, $bairro, $cidade) {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->nome = $nome;
        $this->entrada = $entrada;
        $this->saida = $saida;
        $this->user = $user;
        $this->rua = $rua;
        $this->bairro = $bairro;
        $this->cidade = $cidade;
    }

    function getLatitude() {
        return $this->latitude;
    }

    function getLongitude() {
        return $this->longitude;
    }

    function getNome() {
        return $this->nome;
    }

    function getEntrada() {
        return $this->entrada;
    }

    function getSaida() {
        return $this->saida;
    }

    function getUser() {
        return $this->user;
    }

    function getRua() {
        return $this->rua;
    }

    function getBairro() {
        return $this->bairro;
    }

    function getCidade() {
        return $this->cidade;
    }

    function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEntrada($entrada) {
        $this->entrada = $entrada;
    }

    function setSaida($saida) {
        $this->saida = $saida;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setUser($user) {
        $this->user = $user;
    }

    function setRua($rua) {
        $this->rua = $rua;
    }

    function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    function setCidade($cidade) {
        $this->cidade = $cidade;
    }

}
