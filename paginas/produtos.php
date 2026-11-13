<?php 
if (!defined('nome_loja') && !isset($nome_loja)) { exit; } 

// Busca todos os produtos cadastrados no banco de dados
global $pdo;
$produtos = [];

try {
    $stmt = $pdo->query("SELECT * FROM produto ORDER BY id_produto DESC");
    $produtos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $_SESSION['erro'] = "Erro ao carregar produtos: " . $e->getMessage();
}
?>

<?php if (!empty($_SESSION['sucesso'])): ?>
    <div style="background: var(--ok-soft); color: var(--ok); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--ok); margin-bottom: 20px; font-weight: 600;">
        <?= htmlspecialchars($_SESSION['sucesso']) ?>
    </div>
    <?php unset($_SESSION['sucesso']); ?>
<?php endif; ?>

<?php if (!empty($_SESSION['erro'])): ?>
    <div style="background: var(--red-soft); color: var(--red-dark); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--red); margin-bottom: 20px; font-weight: 600;">
        <?= htmlspecialchars($_SESSION['erro']) ?>
    </div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<div class="page-head">
    <div>
        <h1>Produtos</h1>
        <p>Gerencie o cardápio, preços e disponibilidade dos itens.</p>
    </div>
    <a href="?pagina=produtos-cadastrar" style="height: 40px; padding: 0 20px; border-radius: var(--radius-sm); background: var(--red); color: var(--white); font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: var(--shadow-sm); transition: transform .2s var(--ease);">
        Adicionar Produto
    </a>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px;">
    <?php if (empty($produtos)): ?>
        <p class="muted" style="text-align: center; padding: 20px 0;">Nenhum produto cadastrado no cardápio ainda.</p>
    <?php else: ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
            
            <?php foreach ($produtos as $produto): ?>
                <div style="border: 1px solid var(--line); border-radius: var(--radius-sm); padding: 20px; background: var(--bg); display: flex; flex-direction: column; gap: 10px;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 10px;">
                        <div>
                            <h3 style="margin: 0;"><?= htmlspecialchars($produto['nome']) ?></h3>
                            <?php if (!empty($produto['categoria'])): ?>
                                <small class="muted"><?= htmlspecialchars($produto['categoria']) ?></small>
                            <?php endif; ?>
                        </div>
                        <strong style="color: var(--ok); white-space: nowrap;"><?= moeda((float)$produto['preco']) ?></strong>
                    </div>

                    <p class="muted text-sm">
                        <?= !empty($produto['descricao']) ? htmlspecialchars($produto['descricao']) : 'Sem descrição cadastrada.' ?>
                    </p>

                    <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; padding-top: 10px;">
                        <?php if (!empty($produto['ativo']) && $produto['ativo'] == 1): ?>
                            <span style="background: var(--ok-soft); color: var(--ok); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">Disponível</span>
                        <?php else: ?>
                            <span style="background: var(--red-soft); color: var(--red-dark); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">Indisponível</span>
                        <?php endif; ?>
                        <?php $idItem = reset($produto); ?>
                        <a href="?pagina=produtos-editar&id=<?= (int)$idItem ?>" style="border: 1px solid var(--line); background: var(--white); padding: 4px 10px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; text-decoration: none; color: inherit;">
                       Editar
                    </a>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    <?php endif; ?>
</div>
