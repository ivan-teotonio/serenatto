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

    public function deletar(int $id)
    {
        $sql = "DELETE FROM produtos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(1, $id);
        $stmt->execute(); 

        //return $stmt->rowCount() > 0;
    }

    public function salvar(Produto $produto)
    {
        $sql = "INSERT INTO produtos (tipo, nome, descricao, preco, imagem) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1, $produto->getTipo());
        $stmt->bindValue(2, $produto->getNome());
        $stmt->bindValue(3, $produto->getDescricao());
        $stmt->bindValue(4, $produto->getPreco());
        $stmt->bindValue(5, $produto->getImagem());
        $stmt->execute();
    }

    public function buscar(int $id)
    {
        $sql = "SELECT * FROM produtos WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1,$id);
        $stmt->execute();
        $dados = $stmt->fetch(PDO::FETCH_ASSOC);

     return $this->formarObjeto($dados);
    }

    public function atualizar(Produto $produto)
    {
        $sql = "UPDATE produtos SET tipo = ?, nome = ?, descricao = ?, preco = ?, imagem = ? WHERE id = ?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(1,$produto->getTipo());
        $stmt->bindValue(2,$produto->getNome());
        $stmt->bindValue(3,$produto->getDescricao());
        $stmt->bindValue(4,$produto->getPreco());
        $stmt->bindValue(5,$produto->getImagem());
        $stmt->bindValue(6,$produto->getId());
        $stmt->execute();
    }

}

