<?php

class Func {

    private $_db;

    public function __construct() {
        $this->_db = new DBPDO();
    }

    function linkExists($url) {
        $r = $this->_db->fetchAll("SELECT * FROM urls WHERE url = '$url'");
        return (isset($r[0]['url']) ? true : false);
    }

    function emailExists($email) {
        $r = $this->_db->fetchAll("SELECT * FROM emails WHERE email = '$email'");
        return (isset($r[0]['email']) ? true : false);
    }

    /**
     * Retorna todas URLS não visitadas
     * @return type
     */
    function getAllUrls() {
        $r = $this->_db->fetchAll("SELECT * FROM urls WHERE visited = 'no'");
        return $r;
    }

    /**
     * Retorna todas URLS não visitadas
     * @return type
     */
    function getCountUrls() {
        return $this->_db->fetchAll("SELECT count(*) as total FROM urls");
    }

    /**
     * Atualiza a url para visitada
     * @return \Func
     */
    function setVisited($url) {
        $this->_db->execute("update urls set visited = 'yes' where url = '$url'");
        return $this;
    }

    /**
     * Insere email no banco de dados
     * @param type $email
     */
    function inserirEmail($email) {
        $this->_db->execute("insert into emails(email) values ('$email')");
    }
    
    
    /**
     * Insere URL no banco de dados [visited = no]
     * @param type $email
     */
    function inserirUrl($url) {
        $this->_db->execute("insert into urls(url) values ('$url')");
    }

}
