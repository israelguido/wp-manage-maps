<?php
/*
Plugin Name: Manage Maps
Plugin URI: http://israelguido.com.br/manage-maps
Description: Gerenciador de MAps do Google
Version: 1.0
Author: Israel Guido
Author URI: http://israelguido.com.br
License: GPLv2
*/
define( 'WP_DEBUG', true );

include( plugin_dir_path( __FILE__ ) . 'PDO.php' );

$pdo = new PDO2;
$conn = $pdo->conn();
$object = $pdo->showlist($conn);

add_action('admin_menu', 'manageMaps');

function manageMaps() {
    $icon = "http://itsmorefuninthephilippines.com/wp-content/themes/fun/images/topdestinations/icon_top.png";
    //add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
    add_menu_page('Manage Maps', 'Manage Maps', 'administrator', 'manage-maps', 'main_manage_maps',$icon);

}
function main_manage_maps()
{
    $pdo = new PDO2;
    $conn = $pdo->conn();

    if(isset($_POST['endereco']) && isset($_POST['action'])=='add')
    {
        $get = $_POST;
        $message = $pdo->insert($conn, $get);
        if($message!=''){ echo $message = "<h1>Inserido com sucesso</h1>"; } else { echo $message; }
    }
    else if($_GET['action']=='delete')
    {
        $pdo->delete($_GET['id'], $conn);
        echo "<h1>Deletado com sucesso</h1>";
    }


    echo "
    <h1>Cadastro de Endereços</h1>
    <form action='admin.php?page=manage-maps' method='post'>
    <div class='admin_manage_maps'>
       <table>
        <tr>
            <th>Cep</th>
            <th>Endereço</th>
            <th>Numero</th>
        </tr>
        <tr>
            <td><input type='text' value='' name='cep'/></td>
            <td><input type='text' value='' name='endereco'/></td>
            <td><input type='text' value='' name='numero' /></td>
        </tr>
        <tr>
            <th>Bairro</th>
            <th>Cidade</th>
            <th>Estado</th>
        </tr>
        <tr>
            <td><input type='text' value='' name='bairro' /></td>
            <td><input type='text' value='' name='cidade' /></td>
            <td><input type='text' value='' name='estado'/></td>
        </tr>
        <tr>
            <td><input type='submit' value='Cadastrar'/></td>
            <input type='hidden' name='action' value='add' />
            <input type='hidden' name='page' value='manage-maps' />
        </tr>
       </table>
    </div>
    </form>
    ";

    //show list data in base
    $object = $pdo->showlist($conn);

    ?>

    <table width='100%'>
    <tr>
        <th>Cep</th>
        <th>Endereço</th>
        <th>Número</th>
        <th>Bairro</th>
        <th>Cidade</th>
        <th>Estado</th>
        <th>Deletar</th>
    </tr>

    <?php

    while($data = mysql_fetch_array($object)){
    ?>
        <tr>
            <td class="row-title"><?php echo utf8_decode($data['cep'])?></td>
            <td class="row-title"><?php echo utf8_decode($data['endereco'])?></td>
            <td class="row-title"><?php echo utf8_decode($data['numero'])?></td>
            <td class="row-title"><?php echo utf8_decode($data['bairro'])?></td>
            <td class="row-title"><?php echo utf8_decode($data['cidade'])?></td>
            <td class="row-title"><?php echo utf8_decode($data['estado'])?></td>
            <td class="row-title"><a href='admin.php?page=manage-maps&action=delete&id=<?php echo utf8_decode($data['id'])?>'>[X]</a></td>
        </tr>

    <?php } //endwhile
    echo "</table>";

}
