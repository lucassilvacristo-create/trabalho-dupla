<?php if (!defined('nome_loja') && !isset($nome_loja)) { exit; }
global $pedidos_recentes, $status_map; 
 ?>
<div class="page-head">
    <div>
        <h1>Clientes</h1>
        <p>Consulte a base de contatos cadastrados no sistema.</p>
    </div>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px; overflow-x: auto;">
    <table style="width: 100%; border-collapse: collapse; text-align: left;">
        <thead>
            <tr style="border-bottom: 2px solid var(--line); color: var(--muted); font-size: 0.85rem;">
                <th style="padding: 12px 8px;">Nome Completo</th>
                <th style="padding: 12px 8px;">Últimos Pedidos</th>
                <th style="padding: 12px 8px; text-align: right;">Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pedidos_recentes as $p): ?>
                <tr style="border-bottom: 1px solid var(--line); font-size: 0.9rem;">
                    <td style="padding: 14px 8px; font-weight: 600;"><?= e($p['cliente']) ?></td>
                    <td style="padding: 14px 8px;" class="muted">Pedido #<?= e($p['id']) ?> (<?= e($p['hora']) ?>)</td>
                    <td style="padding: 14px 8px; text-align: right;">
                        <button style="border: 1px solid var(--line); background: var(--white); padding: 4px 10px; border-radius: 6px; cursor: pointer; font-size: 0.85rem;">Histórico</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>