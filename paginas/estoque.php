<?php if (!defined('nome_loja') && !isset($nome_loja)) { exit; } ?>
<div class="page-head">
    <div>
        <h1>Controle de Estoque</h1>
        <p>Acompanhe os níveis críticos de suprimentos e ingredientes para a chapa.</p>
    </div>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px; max-width: 800px;">
    <div style="display: flex; flex-direction: column; gap: 16px;">
        
        <div>
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 6px; font-weight: 600;">
                <span>Blend Bovino (150g)</span>
                <span style="color: var(--ok);">85% Estável</span>
            </div>
            <div style="width: 100%; height: 8px; background: var(--bg); border-radius: 999px; overflow: hidden;">
                <div style="width: 85%; height: 100%; background: var(--ok); border-radius: 999px;"></div>
            </div>
        </div>

        <div>
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 6px; font-weight: 600;">
                <span>Queijo Cheddar Fatiado</span>
                <span style="color: #A06000;">45% Atenção</span>
            </div>
            <div style="width: 100%; height: 8px; background: var(--bg); border-radius: 999px; overflow: hidden;">
                <div style="width: 45%; height: 100%; background: var(--mustard); border-radius: 999px;"></div>
            </div>
        </div>

        <div>
            <div style="display: flex; justify-content: space-between; font-size: 0.9rem; margin-bottom: 6px; font-weight: 600;">
                <span>Pão de Brioche</span>
                <span style="color: var(--red); font-weight: bold;">15% Crítico</span>
            </div>
            <div style="width: 100%; height: 8px; background: var(--bg); border-radius: 999px; overflow: hidden;">
                <div style="width: 15%; height: 100%; background: var(--red); border-radius: 999px;"></div>
            </div>
        </div>

    </div>
</div>