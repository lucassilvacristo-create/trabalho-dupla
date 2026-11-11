<?php if (!defined('nome_loja') && !isset($nome_loja)) { exit; } ?>
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
    <!-- ALTERADO: Agora é um link real apontando para a rota de cadastro -->
    <a href="?pagina=produtos-cadastrar" style="height: 40px; padding: 0 20px; border-radius: var(--radius-sm); background: var(--red); color: var(--white); font-weight: 600; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; box-shadow: var(--shadow-sm); transition: transform .2s var(--ease);">
        Adicionar Produto
    </a>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 20px;">
        
        <div style="border: 1px solid var(--line); border-radius: var(--radius-sm); padding: 20px; background: var(--bg); display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <h3>Smash Duplo</h3>
                <strong style="color: var(--ok);"><?= moeda(34.90) ?></strong>
            </div>
            <p class="muted text-sm">Dois blends artesanais de 100g, queijo cheddar derretido e maionese artesanal da casa.</p>
            <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; padding-top: 10px;">
                <span style="background: var(--ok-soft); color: var(--ok); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">Disponível</span>
                <button style="border: 1px solid var(--line); background: var(--white); padding: 4px 10px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Editar</button>
            </div>
        </div>

        <div style="border: 1px solid var(--line); border-radius: var(--radius-sm); padding: 20px; background: var(--bg); display: flex; flex-direction: column; gap: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <h3>Cheddar Bacon</h3>
                <strong style="color: var(--ok);"><?= moeda(38.00) ?></strong>
            </div>
            <p class="muted text-sm">Blend 150g, muito cheddar cremoso e fatias crocantes de bacon premium crocante.</p>
            <div style="margin-top: auto; display: flex; justify-content: space-between; align-items: center; padding-top: 10px;">
                <span style="background: var(--ok-soft); color: var(--ok); padding: 2px 8px; border-radius: 999px; font-size: 0.75rem; font-weight: bold; text-transform: uppercase;">Disponível</span>
                <button style="border: 1px solid var(--line); background: var(--white); padding: 4px 10px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Editar</button>
            </div>
        </div>

    </div>
</div>
