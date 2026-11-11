<?php if (!defined('nome_loja') && !isset($nome_loja)) { exit; } 
global $pedidos_recentes, $status_map; ?>

<div class="page-head">
    <div>
        <h1>Pedidos Ativos</h1>
        <p>Acompanhe o progresso da cozinha e despache os pedidos em andamento.</p>
    </div>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px;">
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(320px, 1fr)); gap: 20px;">
        
        <?php foreach ($pedidos_recentes as $p): 
            [$status_label, $status_class] = $status_map[$p['status']] ?? ['Desconhecido', ''];
        ?>
            <div style="border: 1px solid var(--line); border-radius: var(--radius-sm); padding: 18px; display: flex; flex-direction: column; justify-content: space-between; gap: 14px; background: var(--white); box-shadow: var(--shadow-sm);">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <span style="font-weight: 800; font-family: var(--font-display); color: var(--red);">#<?= e($p['id']) ?></span>
                    <span class="badge-status <?= e($status_class) ?>"><?= e($status_label) ?></span>
                </div>
                <div>
                    <h3 style="margin-bottom: 4px;"><?= e($p['cliente']) ?></h3>
                    <p class="muted text-sm" style="background: var(--bg); padding: 8px; border-radius: 6px; border-left: 3px solid var(--mustard); min-height: 44px;">
                        <?= e($p['itens']) ?>
                    </p>
                </div>
                <div style="display: flex; justify-content: space-between; align-items: center; border-top: 1px dashed var(--line); padding-top: 10px;">
                    <div>
                        <span class="muted text-sm" style="display:block;">Total</span>
                        <strong><?= moeda($p['total']) ?></strong>
                    </div>
                    <span class="muted text-sm" style="display:flex; align-items:center; gap:4px;"><?= icone('clock', 'icon-sm') ?> <?= e($p['hora']) ?></span>
                </div>
            </div>
        <?php endforeach; ?>

    </div>
</div>

<style>
.badge-status { display: inline-flex; align-items: center; padding: 2px 8px; border-radius: 999px; font-size: 0.72rem; font-weight: bold; text-transform: uppercase; letter-spacing: 0.05em; }
.badge-new { background: var(--mustard-soft); color: #A06000; }
.badge-preparing { background: var(--info-soft); color: var(--info); }
.badge-delivery { background: #EEDFF6; color: #803399; }
.badge-done { background: var(--ok-soft); color: var(--ok); }
.badge-cancel { background: var(--red-soft); color: var(--red-dark); }
</style>