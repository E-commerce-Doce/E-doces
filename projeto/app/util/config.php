<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
#Nome do arquivo: config.php
#Objetivo: define constantes para serem utilizadas no projeto

//Banco de dados: conexão MySQL
define('DB_HOST', 'localhost');
define('DB_NAME', 'ameis');
define('DB_USER', 'root');
//define('DB_PASSWORD', 'root');
define('DB_PASSWORD', '20053011');

//Deve ter o nome da pasta do projeto no servidor APACHE
define('BASEURL', '/ProjetoIntegrador/E-doces/projeto/app');

//define("BASE_PATH", __DIR__ . "/../../");


//Nome do sistema
define('APP_NAME', 'AMEIs');

//Página de logout do sistema
define('LOGIN_PAGE', BASEURL . '/controller/LoginController.php?action=login');

//Página de login do sistema
define('LOGOUT_PAGE', BASEURL . '/controller/LoginController.php?action=logout');

//Página home do sistema
define('HOME_PAGE', BASEURL . '/controller/HomeController.php?action=home');


define("DIR_ARQUIVOS", __DIR__ . "/../../arquivos");
define("URL_ARQUIVOS", BASEURL . "/../arquivos");

//Sessão do usuário
define('SESSAO_USUARIO_ID', "usuarioLogadoId");
define('SESSAO_USUARIO_NOME', "usuarioLogadoNome");
define('SESSAO_USUARIO_PAPEL', "usuarioLogadoPapel");
define('SESSAO_USUARIO_CONFEITEIRO_ID', "usuarioLogadoConfeiteiroId");




