<?php

//** --------------------------------------------- */
//** Conexao com banco de dados PORTAL
//** --------------------------------------------- */

/** O nome do banco de dados*/
define('DB_NAME', 'mova');

/** Usuário do banco de dados SQL */
define('DB_USER', 'portal');

/** Senha do banco de dados SQL */
define('DB_PASSWORD', 'fkj#5htmsa2018');

/** nome do host do SQL */
define('DB_HOST', 'sql003.tecno.local');
//** ############################################# */

//** --------------------------------------------- */
//** Conexao com banco de dados SENIOR
//** --------------------------------------------- */

/** O nome do banco de dados*/
define('DB_NAME_SENIOR', 'SENIOR_PROD');

/** Usuário do banco de dados SQL */
define('DB_USER_SENIOR', 'portal');

/** Senha do banco de dados SQL */
define('DB_PASSWORD_SENIOR', 'fkj#5htmsa2018');

/** nome do host do SQL */
define('DB_HOST_SENIOR', 'TM-SENIORDB01');
//** ############################################# */

/** caminho absoluto para a pasta do sistema **/
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** caminho no server para o sistema **/
if ( !defined('BASEURL') )
	define('BASEURL', '/mova/');

/** caminho do arquivo de banco de dados **/
if ( !defined('DBAPI') )
	define('DBAPI', ABSPATH . 'includes/database.php');

/** caminhos dos templates de header e footer **/
define('HEADER_TEMPLATE', ABSPATH . 'includes/header.php');
define('MENU_TEMPLATE', ABSPATH . 'includes/menu.php');
define('FOOTER_TEMPLATE', ABSPATH . 'includes/footer.php');
define('ESTILO_TEMPLATE', ABSPATH . 'includes/estilo.php');
define('MENU_CONFIG', ABSPATH . 'sgq/configuracoes/menu_config.php');
define('__DIR__','mova',true);
