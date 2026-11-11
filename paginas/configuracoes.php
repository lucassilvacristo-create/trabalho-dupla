<?php 
if (!defined('nome_loja') && !isset($nome_loja)) { exit; } 
global $nome_loja;
?>
<div class="page-head">
    <div>
        <h1>Configurações do Sistema</h1>
        <p>Gerencie as preferências, horários, taxas e regras da sua hamburgueria.</p>
    </div>
</div>

<div class="grid" style="grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); align-items: start; gap: 24px;">
    
    <!-- COLUNA DA ESQUERDA: DADOS DA LOJA E FUNCIONAMENTO -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Bloco 1: Perfil do Estabelecimento -->
        <div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px;">
            <h2 style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <?= icone('burger', 'muted') ?> Perfil da Loja
            </h2>
            <form style="display: flex; flex-direction: column; gap: 16px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Nome do Estabelecimento</label>
                    <input type="text" value="<?= e($nome_loja) ?>" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);">
                </div>
                
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Telefone / WhatsApp Comercial</label>
                    <input type="text" value="(11) 99999-8888" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Endereço Principal</label>
                    <input type="text" value="Av. das Chapa Quente, 1500 - Centro" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);">
                </div>
            </form>
        </div>

        <!-- Bloco 2: Horário de Funcionamento -->
        <div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px;">
            <h2 style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <?= icone('clock', 'muted') ?> Horários de Expediente
            </h2>
            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: grid; grid-template-columns: 120px 1fr 1fr; align-items: center; gap: 10px; font-size: 0.9rem;">
                    <strong>Terça a Quinta:</strong>
                    <input type="time" value="18:00" style="padding: 6px; border: 1px solid var(--line); border-radius: 6px; background: var(--bg);">
                    <input type="time" value="23:00" style="padding: 6px; border: 1px solid var(--line); border-radius: 6px; background: var(--bg);">
                </div>
                <div style="display: grid; grid-template-columns: 120px 1fr 1fr; align-items: center; gap: 10px; font-size: 0.9rem;">
                    <strong>Sexta e Sábado:</strong>
                    <input type="time" value="18:00" style="padding: 6px; border: 1px solid var(--line); border-radius: 6px; background: var(--bg);">
                    <input type="time" value="00:30" style="padding: 6px; border: 1px solid var(--line); border-radius: 6px; background: var(--bg);">
                </div>
                <div style="display: grid; grid-template-columns: 120px 1fr 1fr; align-items: center; gap: 10px; font-size: 0.9rem;">
                    <strong>Domingo:</strong>
                    <input type="time" value="18:30" style="padding: 6px; border: 1px solid var(--line); border-radius: 6px; background: var(--bg);">
                    <input type="time" value="23:30" style="padding: 6px; border: 1px solid var(--line); border-radius: 6px; background: var(--bg);">
                </div>
            </div>
        </div>

    </div>

    <!-- COLUNA DA DIREITA: ENTREGAS, FINANCEIRO E PAGAMENTOS -->
    <div style="display: flex; flex-direction: column; gap: 24px;">
        
        <!-- Bloco 3: Delivery e Logística -->
        <div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px;">
            <h2 style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <?= icone('box', 'muted') ?> Parâmetros de Delivery
            </h2>
            <form style="display: flex; flex-direction: column; gap: 16px;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Taxa de Entrega (R$)</label>
                        <input type="text" value="7,00" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Tempo Estimado (min)</label>
                        <input type="number" value="45" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);">
                    </div>
                </div>
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Pedido Mínimo (R$)</label>
                    <input type="text" value="30,00" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);">
                </div>
            </form>
        </div>

        <!-- Bloco 4: Métodos de Pagamento e Chave Pix -->
        <div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px;">
            <h2 style="margin-bottom: 16px; display: flex; align-items: center; gap: 8px;">
                <?= icone('dollar', 'muted') ?> Finanças e Recebimento
            </h2>
            <div style="display: flex; flex-direction: column; gap: 14px;">
                <div>
                    <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Chave Pix Principal</label>
                    <input type="text" value="pix@burgerhouse.com.br" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg);">
                </div>
                
                <div>
                    <span style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 0.9rem;">Formas de Pagamento no Checkout</span>
                    <div style="display: flex; flex-direction: column; gap: 8px; font-size: 0.9rem;">
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" checked style="accent-color: var(--red);"> Pix Automático
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" checked style="accent-color: var(--red);"> Cartão de Crédito / Débito (Maquininha)
                        </label>
                        <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                            <input type="checkbox" checked style="accent-color: var(--red);"> Dinheiro (Levar troco)
                        </label>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- BARRA DE AÇÕES FIXA INFERIOR -->
<div style="margin-top: 24px; padding: 16px 24px; background: var(--white); border: 1px solid var(--line); border-radius: var(--radius); display: flex; justify-content: space-between; align-items: center;">
    <span class="muted text-sm">* Lembre-se de revisar os horários em feriados importantes.</span>
    <button type="button" style="background: var(--red); color: var(--white); border: none; padding: 12px 28px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; box-shadow: var(--shadow-sm); transition: background 0.2s;">
        Salvar Todas as Configurações
    </button>
</div>
