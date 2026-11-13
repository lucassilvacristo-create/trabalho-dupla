<?php
if (!defined('nome_loja') && !isset($nome_loja)) { exit; }

global $pdo;
$id = (int)($_GET['id'] ?? 0);
$produto = null;

if ($id > 0) {
    try {
        // Descobre automaticamente o nome da primeira coluna (chave primária) da tabela produto
        $colStmt = $pdo->query("SHOW COLUMNS FROM produto");
        $primeiraColuna = $colStmt->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM produto WHERE {$primeiraColuna} = :id LIMIT 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $produto = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        $_SESSION['erro'] = "Erro ao buscar produto: " . $e->getMessage();
    }
}

if (!$produto) {
    $_SESSION['erro'] = "Produto não encontrado.";
    echo "<script>window.location.href = 'index.php?pagina=produtos';</script>";
    exit;
}

$categorias = ['Hambúrgueres Artesanais', 'Lanches', 'Pizzas', 'Porções', 'Bebidas', 'Sobremesas'];
?>

<?php if (!empty($_SESSION['erro'])): ?>
    <div style="background: var(--red-soft); color: var(--red-dark); padding: 12px 16px; border-radius: var(--radius-sm); border: 1px solid var(--red); margin-bottom: 20px; font-weight: 600;">
        <?= htmlspecialchars($_SESSION['erro']) ?>
    </div>
    <?php unset($_SESSION['erro']); ?>
<?php endif; ?>

<div class="page-head">
    <div>
        <h1>Editar Produto</h1>
        <p>Atualize as informações, preço ou disponibilidade do item no cardápio.</p>
    </div>
    <a href="?pagina=produtos" style="height: 40px; padding: 0 16px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--white); color: inherit; font-weight: 600; display: inline-flex; align-items: center; text-decoration: none;">
        ← Voltar
    </a>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px; max-width: 680px;">
    <form method="POST" action="?pagina=produtos-editar&id=<?= (int)$id ?>" style="display: flex; flex-direction: column; gap: 18px;">
        <input type="hidden" name="id" value="<?= (int)$id ?>">

        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Nome do Hambúrguer / Produto</label>
                <input type="text" name="nome" required value="<?= htmlspecialchars($produto['nome']) ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: var(--radius-sm);">
            </div>

            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px;">Preço de Venda (R$)</label>
                <input type="text" name="preco" required value="<?= number_format((float)$produto['preco'], 2, ',', '.') ?>" style="width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: var(--radius-sm);">
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 6px;">Categoria do Item</label>
            <select name="categoria" required style="width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: var(--radius-sm); background: var(--white);">
                <?php if (!in_array($produto['categoria'], $categorias) && !empty($produto['categoria'])): ?>
                    <option value="<?= htmlspecialchars($produto['categoria']) ?>" selected><?= htmlspecialchars($produto['categoria']) ?></option>
                <?php endif; ?>
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= ($produto['categoria'] === $cat) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 6px;">Descrição Completa dos Ingredientes</label>
            <textarea name="descricao" rows="4" style="width: 100%; padding: 10px 12px; border: 1px solid var(--line); border-radius: var(--radius-sm);"><?= htmlspecialchars($produto['descricao'] ?? '') ?></textarea>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 6px;">Status de Visibilidade</label>
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer;">
                <input type="checkbox" name="ativo" value="1" <?= (!empty($produto['ativo']) && $produto['ativo'] == 1) ? 'checked' : '' ?>>
                <span>Disponibilizar imediatamente para vendas no sistema</span>
            </label>
        </div>

        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 8px;">
            <a href="?pagina=produtos" style="padding: 10px 18px; border-radius: var(--radius-sm); border: 1px solid var(--line); text-decoration: none; color: inherit; font-weight: 600;">Cancelar</a>
            <button type="submit" style="padding: 10px 20px; border-radius: var(--radius-sm); border: none; background: var(--red); color: var(--white); font-weight: 600; cursor: pointer;">Salvar Alterações</button>
        </div>
    </form>
</div>
