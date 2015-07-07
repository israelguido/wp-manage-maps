<?php
/**
 * Created by PhpStorm.
 * User: Israel Guido
 * Date: 17/06/14
 * Time: 15:03
 */

class PDO2 {

    protected $_plugin_slug = 'manage-maps';
    private $conn;
    private $server       = '127.0.0.1';
    private $user         = 'root';
    private $passwd       = '';
    private $database     = 'wordpress';

    public function conn(){

        $this->conn = mysql_connect($this->server, $this->user, $this->passwd) or die( mysql_error() );
        mysql_select_db($this->database, $this->conn) or die( mysql_error() );
        return $this->conn;
    }

    public function insert($conn, $data)
    {
        $sql = "INSERT INTO `wp_manage_maps`
                (`endereco`, `cep`, `bairro`, `cidade`, `estado`, `numero`, `complemento`)
                 VALUES
                ('".utf8_encode($data['endereco'])."','".$data['cep']."','".utf8_encode($data['bairro'])."','".utf8_encode($data['cidade'])."','".utf8_encode($data['estado'])."','".$data['numero']."','')
";
        return mysql_query($sql, $conn) or die(mysql_error());
    }

    public function delete($id, $conn)
    {
        $sql = "DELETE FROM `wordpress`.`wp_manage_maps` WHERE `id`='".$id."'";
        return mysql_query($sql, $conn) or die(mysql_error());
    }

    public function showlist($conn)
    {
        $sql = "SELECT * FROM wp_manage_maps";
        $resource  = mysql_query( $sql, $conn );
        return $resource;
    }
}
