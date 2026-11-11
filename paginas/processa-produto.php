<?php
/**
 * processa-produto.php — Salva o novo item no banco de dados.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 1. Traz a conexão com o banco de dados e as variáveis globais
// Ajuste o caminho abaixo para o seu arquivo real de conexão (ex: conexao.php, config.php)
global $pdo; 
if (!isset($pdo)) {
    // Se o seu PDO não estiver global, inclua o seu arquivo de conexão aqui:
    // require_once 'conexao.php';
}

// 2. Verifica se a requisição veio do formulário via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Captura e sanitiza os dados para evitar códigos maliciosos
    $nome        = trim((string)($_POST['nome'] ?? ''));
    $preco_raw   = trim((string)($_POST['preco'] ?? ''));
    $categoria_id= (int)($_POST['categoria_id'] ?? 0);
    $descricao   = trim((string)($_POST['descricao'] ?? ''));
    $ativo       = isset($_POST['ativo']) ? 1 : 0;

    // Validação simples: impede campos obrigatórios em branco
    if (empty($nome) || empty($preco_raw) || empty($categoria_id)) {
        $_SESSION['erro'] = "Por favor, preencha todos os campos obrigatórios.";
        header("Location: index.php?pagina=produtos-cadastrar");
        exit;
    }

    // Tratamento de Moeda: Converte "34,90" ou "34.90" em float válido (34.90)
    $preco_limpo = str_replace(['R$', ' ', '.'], '', $preco_raw);
    $preco_float = (float)str_replace(',', '.', $preco_limpo);

    try {
        // 3. Query SQL utilizando Prepared Statements (Segurança total contra SQL Injection)
        // Certifique-se de que os nomes das colunas e da tabela coincidem com o seu banco
        $sql = "INSERT INTO produtos (nome, preco, categoria_id, descricao, ativo, criado_em) 
                VALUES (:nome, :preco, :categoria_id, :descricao, :ativo, NOW())";
        
        $stmt = $pdo->prepare($sql);
        
        // Vincula os parâmetros com segurança
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':preco', $preco_float);
        $stmt->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
        $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindValue(':ativo', $ativo, PDO::PARAM_INT);
        
        // Executa a gravação no banco
        if ($stmt->execute()) {
            $_SESSION['sucesso'] = "Produto '{$nome}' cadastrado com sucesso!";
            // Redireciona de volta para a listagem principal de produtos
            header("Location: index.php?pagina=produtos");
            exit;
        } else {
            throw new Exception("Falha ao executar a inserção.");
        }

    } catch (Exception $e) {
        // Grava o erro na sessão para debugar na tela de cadastro se algo falhar
        $_SESSION['erro'] = "Erro ao salvar no banco de dados: " . $e->getMessage();
        header("Location: index.php?pagina=produtos-cadastrar");
        exit;
    }
} else {
    // Se tentarem acessar este arquivo direto pelo navegador sem submeter o formulário
    header("Location: index.php?pagina=produtos");
    exit;
}