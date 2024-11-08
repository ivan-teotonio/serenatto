<?php 

require_once 'src/conexao.php';
require_once 'src/Repositorio/ProdutoRepositorio.php';

$produtoRepositorio = new ProdutoRepositorio($pdo);

?>