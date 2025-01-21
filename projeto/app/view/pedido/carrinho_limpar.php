<?php
session_start();

if (isset($_SESSION['carrinho']))
    $_SESSION['carrinho'] = [];