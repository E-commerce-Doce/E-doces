<?php
session_start();

// Verifica se o carrinho está vazio
if (!isset($_SESSION['carrinho']) || count($_SESSION['carrinho']) === 0) {
    echo "Seu carrinho está vazio. Não é possível finalizar a compra.";
    exit();
}

// Calcular o total da compra
$total = 0;
foreach ($_SESSION['carrinho'] as $produto) {
    $total += $produto['preco'] * $produto['quantidade'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finalizar Compra</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .btn-finalizar {
            background-color: #EA4961;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            cursor: pointer;
        }
        .btn-finalizar:hover {
            background-color: #c53f52;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h2>Compra Finalizada com Sucesso!</h2>
    <p>Obrigado pela sua compra!</p>



    
</body>
</html>

<?php
// Limpar o carrinho após a compra ser finalizada 
unset($_SESSION['carrinho']);
?>
