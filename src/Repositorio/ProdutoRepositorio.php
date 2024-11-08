<?php

class ProdutoRepositorio
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function buscarProdutosPorTipo(string $tipo): array
    {
        $sql = "SELECT * FROM produtos WHERE tipo = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$tipo]);
        $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $dados = array_map(function($produto) {
            return $this->formarObjeto($produto);
        }, $produtos);

        return $dados;
    }

    public function formarObjeto($dados)
    {
        return new Produto($dados['id'], $dados['tipo'], $dados['nome'], $dados['descricao'], $dados['preco'], $dados['imagem']);
    }

    public function buscarTodosProdutos(): array
    {
        $sql = "SELECT * FROM produtos order by preco";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $todosDados = array_map(function($produto) {
            return $this->formarObjeto($produto);
        }, $dados);

        return $todosDados;
    }

}

