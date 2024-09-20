<?php
#Nome do arquivo: view/include/header.php
#Objetivo: header a ser utilizados em todas as páginas do projeto

//require_once(__DIR__ . "/../../util/config.php");
?>
<!DOCTYPE html>
<html lang="pt">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo APP_NAME; ?></title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        :root{
            --cor-verde: #9BB899;
            --cor-rosa-claro: #FCCEAA;
            --cor-rosa-escuro: #EA4961;
            --font-principal: Caveat;
            --font-secundaria: Montserrant;
        }

        body {
            background-color: #FCCEAA;
            font-family: Montserrant;
        }

        .navbar {
            background-color: #9BB899;
            color:#9BB899;
            font-weight: bolder;

        }
        .estilo{
            font-family:(var(--font-principal));
        }
        .estilo2{
            font-family:(var(--font-secundaria));
        }
        .color1{
            color: (var(--cor-verde));
        }
        .color2{
            color: (var(--cor-rosa-claro));
        }  
        .cor3{
            color: (var(--cor-rosa-escuro));
        }
        .navbar-brand{
            font-family: Caveat;
            font-size: 30px;
        }

        a{
            color: #000;
            font-weight: bolder;
        }

        .btn{
            background-color: #EA4961;
            color: #FCCEAA;
        }

        .navbar-item li{
            margin-left: 30%;
        }

        footer {
            background-color: #F5827D;
        }
    </style>
</head>

<body>