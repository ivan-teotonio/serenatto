<?php 

require_once 'src/conexao.php';
require_once 'src/Modelo/Produto.php';
require_once 'src/Repositorio/ProdutoRepositorio.php';


$produtoRepositorio = new ProdutoRepositorio($pdo);


$produtoRepositorio->deletar($_GET['id']);

header('Location: admin.php');  
?>