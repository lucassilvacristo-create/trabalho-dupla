<?php if (!defined('nome_loja') && !isset($nome_loja)) { exit; } ?>
<div class="page-head">
    <div>
        <h1>Categorias</h1>
        <p>Organize seu cardápio em grupos para facilitar a navegação do cliente.</p>
    </div>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px; max-width: 800px;">
    <div style="display: flex; flex-direction: column; gap: 12px;">
        
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: var(--bg); border-radius: var(--radius-sm); border: 1px solid var(--line);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <?= icone('burger', 'muted') ?>
                <strong>Hambúrgueres</strong>
            </div>
            <span class="muted text-sm">24 itens vinculados</span>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: var(--bg); border-radius: var(--radius-sm); border: 1px solid var(--line);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <?= icone('box', 'muted') ?>
                <strong>Acompanhamentos</strong>
            </div>
            <span class="muted text-sm">8 itens vinculados</span>
        </div>

        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 20px; background: var(--bg); border-radius: var(--radius-sm); border: 1px solid var(--line);">
            <div style="display: flex; align-items: center; gap: 12px;">
                <?= icone('tag', 'muted') ?>
                <strong>Bebidas</strong>
            </div>
            <span class="muted text-sm">10 itens vinculados</span>
        </div>

    </div>
</div>