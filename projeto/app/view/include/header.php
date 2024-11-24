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
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Caveat:wght@400..700&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap');

        :root {
            --cor-verde: #9BB899;
            --cor-rosa-claro: #FCCEAA;
            --cor-rosa-escuro: #EA4961;
            --font-principal: Caveat;
            --font-secundaria: Montserrat;
        }

        body {
            background-color: #FCCEAA;
            font-family: Montserrant;
        }

        .navbar {
            background-color: #9BB899;
            color: #9BB899;
            font-weight: bolder;

        }

        .nav-link {
            color: #fff;
            font-weight: 500;
        }

        .form-control {
            font-size: 15px;
        }

        .imgCadastro {


            position: absolute;
            width: 220px;
            height: 230px;
            left: 599px;
            top: 260px;

            /* transform: matrix(0.97, 0.25, -0.24, 0.97, 0, 0);*/

        }

        .imgLogin {

            position: absolute;
            width: 450px;
            height: 450px;
            left: 750px;
            top: 0px;

        }

        .input-group {
            position: relative;
        }

        .input-group .form-control {
            padding-right: 40px;
        }


        .input-group-append {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }


        .btn {
            width: auto;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-group-append {
            cursor: pointer;
        }

        #togglePassword {
            background-color: transparent;
            border: none;
        }

        #togglePassword:hover {
            color: #007BFF;
        }

        .navbar-nav .nav-item i {
            font-size: 1.5rem;
            /* Ajusta o tamanho do ícone */
            color: #EA4961;
            /* Ajusta a cor do ícone */
        }

        .estilo {
            font-family: var(--font-secundaria);
            color: #fff;
        }

        .estilo2 {
            font-family: var(--font-principal);
        }

        .color1 {
            color: var(--cor-verde);
        }

        .color2 {
            color: var(--cor-rosa-claro);
        }

        .cor3 {
            color: var(--cor-rosa-escuro);
        }

        .navbar-brand {
            font-family: var(--font-principal);
            font-size: 30px;
        }

        a {
            color: #000;
            font-weight: bolder;
        }

        .btn {
            background-color: #EA4961;
            color: #FCCEAA;
            font-family: var(--font-secundaria);
        }

        .navbar-item li {
            margin-left: 30%;
        }


        footer {
            background-color: #EA4961;
        }
    </style>
</head>

<body>