<?php if (!defined('nome_loja') && !isset($nome_loja)) { exit; } ?>
<div class="page-head">
    <div>
        <h1>Relatórios Operacionais</h1>
        <p>Análise de métricas consolidadas do fechamento de caixa.</p>
    </div>
</div>

<div class="grid grid-stats" style="margin-bottom: 20px;">
    <div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 20px;">
        <span class="muted text-sm" style="display: block; margin-bottom: 4px;">Ticket Médio</span>
        <strong style="font-size: 1.4rem; font-family: var(--font-display);"><?= moeda(74.31) ?></strong>
    </div>
    <div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 20px;">
        <span class="muted text-sm" style="display: block; margin-bottom: 4px;">Taxa de Cancelamento</span>
        <strong style="font-size: 1.4rem; font-family: var(--font-display); color: var(--red);">1.4%</strong>
    </div>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px;">
    <h2 style="margin-bottom: 16px;">Demonstrativo Mensal</h2>
    <div style="display: flex; align-items: flex-end; gap: 20px; height: 140px; border-bottom: 2px solid var(--line); padding-bottom: 4px;">
        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <div style="width: 100%; height: 80px; background: var(--line); border-radius: 4px 4px 0 0;"></div>
            <span class="muted text-sm">Set</span>
        </div>
        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <div style="width: 100%; height: 105px; background: var(--line); border-radius: 4px 4px 0 0;"></div>
            <span class="muted text-sm">Out</span>
        </div>
        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px;">
            <div style="width: 100%; height: 130px; background: var(--mustard); border-radius: 4px 4px 0 0;"></div>
            <span class="text-sm" style="font-weight: 600;">Nov</span>
        </div>
    </div>
</div>