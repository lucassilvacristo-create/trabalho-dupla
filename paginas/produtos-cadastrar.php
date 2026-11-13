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
        <h1>Adicionar Novo Produto</h1>
        <p>Preencha as informações detalhadas para cadastrar um novo item no cardápio.</p>
    </div>
    <!-- Botão de Voltar para a listagem -->
    <a href="?pagina=produtos" style="height: 40px; padding: 0 16px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--white); color: var(--gray-dark); font-weight: 600; display: inline-flex; align-items: center; justify-content: center; text-decoration: none;">
        ← Voltar
    </a>
</div>

<div class="card" style="background: var(--white); border-radius: var(--radius); border: 1px solid var(--line); padding: 24px; max-width: 750px;">
    <!-- Formulário apontando para o arquivo que salvará no banco de dados -->
    <form action="index.php?pagina=produtos-cadastrar" method="POST" style="display: flex; flex-direction: column; gap: 20px;">
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 16px;">
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Nome do Hambúrguer / Produto</label>
                <input type="text" name="nome" required placeholder="Ex: Smash Salad Bacon" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg); color: var(--black);">
            </div>
            <div>
                <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Preço de Venda (R$)</label>
                <input type="text" name="preco" required placeholder="0,00" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg); color: var(--black);">
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Categoria do Item</label>
            <select name="categoria" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg); color: var(--black); height: 42px;">
                <option value="1">Hambúrgueres Artesanais</option>
                <option value="2">Acompanhamentos / Porções</option>
                <option value="3">Bebidas / Sucos</option>
                <option value="4">Sobremesas</option>
            </select>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Descrição Completa dos Ingredientes</label>
            <textarea name="descricao" rows="4" required placeholder="Descreva de forma apetitosa (Ex: Blend bovino de 150g, queijo prato derretido, alface crespa, tomate fresco e molho especial...)" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-sm); border: 1px solid var(--line); background: var(--bg); color: var(--black); resize: vertical; font-family: inherit;"></textarea>
        </div>

        <div>
            <label style="display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem;">Status Inicial de Visibilidade</label>
            <label style="display: inline-flex; align-items: center; gap: 8px; cursor: pointer; font-size: 0.9rem;">
                <input type="checkbox" name="ativo" value="1" checked style="accent-color: var(--red); width: 16px; height: 16px;">
                Disponibilizar imediatamente para vendas no sistema
            </label>
        </div>

        <div style="padding-top: 16px; border-top: 1px solid var(--line); display: flex; justify-content: flex-end; gap: 12px;">
            <a href="?pagina=produtos" style="padding: 10px 20px; border-radius: var(--radius-sm); color: var(--muted); font-weight: 600; display: inline-flex; align-items: center; text-decoration: none; font-size: 0.9rem;">
                Cancelar
            </a>
            <button type="submit" style="background: var(--red); color: var(--white); border: none; padding: 10px 24px; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer; font-size: 0.9rem; box-shadow: var(--shadow-sm);">
                Salvar Produto
            </button>
        </div>

    </form>
</div>