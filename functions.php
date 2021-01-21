<?php

require_once('config.php');
require_once(DBAPI);

$usuarios = null;
$user = null;
/**
 *  Listagem de usuarios
 */
function index() {
	global $usuarios;
	$usuarios = find_all('usuarios');
}


/*********************************************
Função de validação no AD via protocolo LDAP
*********************************************/
function validaldap($form_user, $form_pass){

    //$adServer = '10.50.20.1';
	$adServer = 'tm-ad001.tecno.local';

    $ldap = ldap_connect($adServer);
    $username = $form_user;
    $password = $form_pass;

    $ldaprdn = 'tecno' . "\\" . $username;

    ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
    ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);

    $bind = @ldap_bind($ldap, $ldaprdn, $password);


    if ($bind) {
        $filter="(sAMAccountName=$username)";
        $result = ldap_search($ldap,"dc=tecno,dc=local",$filter);
        ldap_sort($ldap,$result,"sn");
        $info = ldap_get_entries($ldap, $result);
        for ($i=0; $i<$info["count"]; $i++)
        {
            if($info['count'] > 1)
                break;
            //echo "<p>You are accessing <strong> ". $info[$i]["sn"][0] .", " . $info[$i]["givenname"][0] ."</strong><br /> (" . $info[$i]["samaccountname"][0] .")</p>\n";
            //echo '<pre>';
            //var_dump($info);
            //echo '</pre>';
            //$userDn = $info[$i]["distinguishedname"][0];
			return $info;
        }
        @ldap_close($ldap);
    } else {
        $msg = "Invalid email address /     ";
        //echo $msg;
        //return $msg;
    }
}

?>
