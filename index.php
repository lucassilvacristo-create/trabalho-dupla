<?php
$usuario_nome = 'Visitante';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once 'conexao.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['pagina']) && $_GET['pagina'] === 'produtos-cadastrar') {
    global $pdo; 
    
    $nome         = trim((string)($_POST['nome'] ?? ''));
    $preco_raw    = trim((string)($_POST['preco'] ?? ''));
    $categoria_id = (int)($_POST['categoria_id'] ?? 0);
    $descricao    = trim((string)($_POST['descricao'] ?? ''));
    $ativo        = isset($_POST['ativo']) ? 1 : 0;

    if (!empty($nome) && !empty($preco_raw) && !empty($categoria_id)) {
        $preco_limpo = str_replace(['R$', ' ', '.'], '', $preco_raw);
        $preco_float = (float)str_replace(',', '.', $preco_limpo);

        try {
            $sql = "INSERT INTO produto (nome, preco, categoria, ativo) 
                    VALUES (:nome, :preco, :categoria_id, :descricao, :ativo, NOW())";
            
            // Linha 23 agora vai funcionar perfeitamente
            $stmt = $pdo->prepare($sql); 
            
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':preco', $preco_float);
            $stmt->bindValue(':categoria_id', $categoria_id, PDO::PARAM_INT);
            $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindValue(':ativo', $ativo, PDO::PARAM_INT);
            
            if ($stmt->execute()) {
                $_SESSION['sucesso'] = "Produto cadastrado com sucesso!";
                header("Location: index.php?pagina=produtos");
                exit;
            }
        } catch (Exception $e) {
            $_SESSION['erro'] = "Erro ao salvar no banco: " . $e->getMessage();
        }
    } else {
        $_SESSION['erro'] = "Por favor, preencha todos os campos obrigatórios.";
    }
}

if (!function_exists('e')) {
    function e($valor): string
    {
        return htmlspecialchars((string) $valor, ENT_QUOTES, 'UTF-8');
    }
}
if (!function_exists('moeda')) {
    function moeda($valor): string
    {
        return 'R$ ' . number_format((float) $valor, 2, ',', '.');
    }
}
if (!function_exists('icone')) {
    /** Renderiza um ícone do sprite SVG definido mais abaixo. */
    function icone(string $nome, string $classe = ''): string
    {
        return '<svg class="icon ' . e($classe) . '" aria-hidden="true"><use href="#i-' . e($nome) . '"/></svg>';
    }
}


$menu = [
    'dashboard'     => ['Dashboard',     'home'],
    'produtos'      => ['Produtos',      'burger'],
    'categorias'    => ['Categorias',    'tag'],
    'pedidos'       => ['Pedidos',       'receipt'],
    'clientes'      => ['Clientes',      'users'],
    'estoque'       => ['Estoque',       'box'],
    'relatorios'    => ['Relatórios',    'chart'],
    'configuracoes' => ['Configurações', 'gear'],
];

$pagina = $_GET['pagina'] ?? 'dashboard';

// Lista de páginas permitidas que NÃO aparecem no menu lateral
$paginas_ocultas = [
    'produtos-cadastrar' => ['Adicionar Produto', 'burger']
];

// Junta as páginas do menu com as páginas de formulários ocultos
$paginas_validas = array_merge($menu, $paginas_ocultas);

// Agora a checagem valida contra todas as telas existentes no sistema
if (!isset($paginas_validas[$pagina])) {
    $pagina = 'dashboard';
}


foreach (['usuario_nome', 'nome', 'usuario'] as $chave) {
    if (!empty($_SESSION[$chave]) && is_string($_SESSION[$chave])) {
        $usuario_nome = $_SESSION[$chave];
        break;
    }
}
$usuario_logado = $usuario_nome !== 'Visitante';
$usuario_cargo  = (!empty($_SESSION['cargo']) && is_string($_SESSION['cargo'])) ? $_SESSION['cargo'] : 'Administrador';
$iniciais       = mb_strtoupper(mb_substr($usuario_nome, 0, 1, 'UTF-8'), 'UTF-8');
$url_logout     = 'logout.php'; 
$nome_loja = 'Burger House';


$status_map = [
    'novo'      => ['Novo',            'badge-new'],
    'preparo'   => ['Em preparo',      'badge-preparing'],
    'entrega'   => ['Saiu p/ entrega', 'badge-delivery'],
    'entregue'  => ['Entregue',        'badge-done'],
    'cancelado' => ['Cancelado',       'badge-cancel'],
];

$total_pedidos    = 248;
$faturamento      = 18430.50;
$total_produtos   = 42;
$em_andamento     = 7;

$pedidos_recentes = [
    ['id' => 1048, 'cliente' => 'Marcos Oliveira', 'itens' => '2x Smash Duplo, 1x Batata G', 'total' => 78.90, 'status' => 'preparo',  'hora' => '11:24'],
    ['id' => 1047, 'cliente' => 'Fernanda Lima',   'itens' => '1x Cheddar Bacon, 1x Refri',  'total' => 42.00, 'status' => 'novo',     'hora' => '11:18'],
    ['id' => 1046, 'cliente' => 'Rafael Souza',    'itens' => '3x Clássico Burger',          'total' => 87.00, 'status' => 'entrega',  'hora' => '11:02'],
    ['id' => 1045, 'cliente' => 'Juliana Costa',   'itens' => '1x Veggie, 1x Onion Rings',   'total' => 49.50, 'status' => 'entregue', 'hora' => '10:47'],
    ['id' => 1044, 'cliente' => 'Pedro Almeida',   'itens' => '2x Smash Simples',            'total' => 52.00, 'status' => 'cancelado','hora' => '10:31'],
];

$mais_vendidos = [
    ['nome' => 'Smash Duplo',    'qtd' => 94],
    ['nome' => 'Cheddar Bacon',  'qtd' => 78],
    ['nome' => 'Clássico Burger','qtd' => 61],
    ['nome' => 'Batata Rústica', 'qtd' => 49],
    ['nome' => 'Milkshake',      'qtd' => 33],
];
$max_qtd = max(array_column($mais_vendidos, 'qtd')) ?: 1;

$periodo = $_GET['periodo'] ?? 'hoje';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#B22222">
  <title><?= e($menu[$pagina][0]) ?> · <?= e($nome_loja) ?></title>
  <link rel="stylesheet" href="css.php">
</head>
<body>


<svg width="0" height="0" style="position:absolute" aria-hidden="true">
  <symbol id="i-home" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></symbol>
  <symbol id="i-burger" viewBox="0 0 24 24"><path d="M4 10a8 6 0 0 1 16 0z"/><path d="M3 14h18"/><path d="M4 17h16a0 0 0 0 1 0 0 3 3 0 0 1-3 3H7a3 3 0 0 1-3-3z"/><line x1="9" y1="6" x2="9.01" y2="6"/><line x1="13" y1="5" x2="13.01" y2="5"/><line x1="16" y1="7" x2="16.01" y2="7"/></symbol>
  <symbol id="i-tag" viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></symbol>
  <symbol id="i-receipt" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></symbol>
  <symbol id="i-users" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></symbol>
  <symbol id="i-box" viewBox="0 0 24 24"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></symbol>
  <symbol id="i-chart" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></symbol>
  <symbol id="i-gear" viewBox="0 0 24 24"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></symbol>
  <symbol id="i-bell" viewBox="0 0 24 24"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></symbol>
  <symbol id="i-search" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></symbol>
  <symbol id="i-menu" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></symbol>
  <symbol id="i-logout" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></symbol>
  <symbol id="i-clock" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></symbol>
  <symbol id="i-dollar" viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></symbol>
  <symbol id="i-x" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></symbol>
  <symbol id="i-arrow" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></symbol>
</svg>

<input type="checkbox" id="menu-state" class="sr-only" aria-hidden="true" tabindex="-1">

<div class="app">

  
  <aside class="sidebar" aria-label="Menu principal">
    <a href="index.php" class="brand">
      <span class="brand-mark"><?= icone('burger') ?></span>
      <span>
        <div class="brand-name"><?= e(strtoupper(explode(' ', $nome_loja)[0])) ?><span>.</span></div>
        <div class="brand-sub">Hamburgueria Artesanal</div>
      </span>
    </a>

    <div class="nav-label">Gestão</div>
    <nav class="nav">
      <?php foreach ($menu as $slug => [$titulo, $ico]): ?>
        <a href="index.php?pagina=<?= e($slug) ?>"
           class="<?= $slug === $pagina ? 'active' : '' ?>"
           <?= $slug === $pagina ? 'aria-current="page"' : '' ?>>
          <?= icone($ico) ?>
          <span><?= e($titulo) ?></span>
          <?php if ($slug === 'pedidos' && $em_andamento > 0): ?>
            <span class="badge-count"><?= (int) $em_andamento ?></span>
          <?php endif; ?>
        </a>
      <?php endforeach; ?>
    </nav>

    <div class="sidebar-foot">
      <div class="promo">
        <strong>Hora do pico</strong>
        Acompanhe os pedidos em andamento para manter a chapa quente.
      </div>
      <a href="#sair" class="btn btn-ghost btn-block logout"><?= icone('logout') ?> Sair</a>
    </div>
  </aside>

 
  <div class="main">

    <header class="header">
      <label for="menu-state" class="icon-btn menu-toggle" aria-label="Abrir menu"><?= icone('menu') ?></label>

      <form class="search" role="search" action="index.php" method="get">
        <?= icone('search') ?>
        <input type="hidden" name="pagina" value="pedidos">
        <input class="input" type="search" name="busca" placeholder="Buscar pedido ou cliente..." aria-label="Buscar">
      </form>

      <div class="header-actions">
        <a href="index.php?pagina=pedidos" class="icon-btn" aria-label="Pedidos em andamento" title="Pedidos em andamento">
          <?= icone('bell') ?>
          <?php if ($em_andamento > 0): ?><span class="dot"></span><?php endif; ?>
        </a>
        <a href="index.php?pagina=configuracoes" class="icon-btn" aria-label="Configurações" title="Configurações"><?= icone('gear') ?></a>

        <?php if ($usuario_logado): ?>
          <div class="user">
            <span class="avatar"><?= e($iniciais) ?></span>
            <span class="user-info"><strong><?= e($usuario_nome) ?></strong><span><?= e($usuario_cargo) ?></span></span>
          </div>
        <?php endif; ?>
      </div>
    </header>

    <main class="content">
<?php

$arquivo_pagina = __DIR__ . '/paginas/' . $pagina . '.php';

if ($pagina !== 'dashboard'):
    if (is_file($arquivo_pagina)) {
        include $arquivo_pagina;
    } else { ?>
      <div class="page-head">
        <div>
          <h1><?= e($menu[$pagina][0]) ?></h1>
          <p>Esta área ainda não foi conectada a uma tela.</p>
        </div>
      </div>
      <div class="card fade-in">
        <div class="empty">
          <div class="empty-art"><?= icone($menu[$pagina][1]) ?></div>
          <h2><?= e($menu[$pagina][0]) ?></h2>
          <p>Coloque sua tela atual em <code>paginas/<?= e($pagina) ?>.php</code> e ela aparecerá aqui, já com o novo visual.</p>
        </div>
      </div>
    <?php }
else: ?>

     
      <div class="page-head">
        <div>
          <h1>Olá<?= $usuario_logado ? ', ' . e(explode(' ', $usuario_nome)[0]) : '' ?>! 🍔</h1>
          <p>Veja como está a operação da <?= e($nome_loja) ?> hoje.</p>
        </div>
        <form method="get" action="index.php">
          <label class="sr-only" for="periodo">Período</label>
          <select class="select select-inline" id="periodo" name="periodo" onchange="this.form.submit()">
            <?php foreach (['hoje' => 'Hoje', 'semana' => 'Esta semana', 'mes' => 'Este mês'] as $v => $r): ?>
              <option value="<?= e($v) ?>" <?= $periodo === $v ? 'selected' : '' ?>><?= e($r) ?></option>
            <?php endforeach; ?>
          </select>
        </form>
      </div>

      <?php if ($em_andamento > 0): ?>
      <section class="banner">
        <div class="banner-icon"><?= icone('clock', 'icon-lg') ?></div>
        <div>
          <h2><?= (int) $em_andamento ?> pedido<?= $em_andamento > 1 ? 's' : '' ?> em andamento</h2>
          <p>Fique de olho na cozinha e na entrega.</p>
        </div>
        <a href="index.php?pagina=pedidos" class="btn btn-accent">Ver pedidos <?= icone('arrow', 'icon-sm') ?></a>
      </section>
      <?php endif; ?>

      <section class="grid grid-stats" aria-label="Indicadores">
        <article class="card card-hover stat stat--red">
          <div class="stat-icon"><?= icone('receipt') ?></div>
          <div class="stat-label">Total de pedidos</div>
          <div class="stat-value"><?= (int) $total_pedidos ?></div>
          <div class="stat-note"><b>+12%</b> vs. período anterior</div>
        </article>
        <article class="card card-hover stat stat--mustard">
          <div class="stat-icon"><?= icone('dollar') ?></div>
          <div class="stat-label">Faturamento</div>
          <div class="stat-value"><?= e(moeda($faturamento)) ?></div>
          <div class="stat-note"><b>+8%</b> vs. período anterior</div>
        </article>
        <article class="card card-hover stat stat--dark">
          <div class="stat-icon"><?= icone('burger') ?></div>
          <div class="stat-label">Produtos cadastrados</div>
          <div class="stat-value"><?= (int) $total_produtos ?></div>
          <div class="stat-note">No cardápio</div>
        </article>
        <article class="card card-hover stat stat--green">
          <div class="stat-icon"><?= icone('clock') ?></div>
          <div class="stat-label">Pedidos em andamento</div>
          <div class="stat-value"><?= (int) $em_andamento ?></div>
          <div class="stat-note">Preparo e entrega</div>
        </article>
      </section>

      <div class="grid grid-main">

       
        <section class="card fade-in delay-1">
          <div class="card-head">
            <h2>Pedidos recentes</h2>
            <a href="index.php?pagina=pedidos" class="btn btn-outline btn-sm">Ver todos</a>
          </div>
          <div class="card-body flush">
            <?php if (empty($pedidos_recentes)): ?>
              <div class="empty">
                <div class="empty-art"><?= icone('receipt') ?></div>
                <h3>Nenhum pedido ainda</h3>
                <p>Quando os pedidos chegarem, eles aparecem aqui.</p>
              </div>
            <?php else: ?>
              <div class="table-wrap">
                <table class="table table-stack">
                  <thead>
                    <tr><th>Pedido</th><th>Cliente</th><th>Total</th><th>Status</th><th>Hora</th></tr>
                  </thead>
                  <tbody>
                  <?php foreach ($pedidos_recentes as $p):
                      [$rotulo, $classe] = $status_map[$p['status']] ?? [ucfirst((string) $p['status']), '']; ?>
                    <tr>
                      <td data-label="Pedido"><strong>#<?= (int) $p['id'] ?></strong></td>
                      <td data-label="Cliente" class="cell-main">
                        <strong><?= e($p['cliente']) ?></strong>
                        <span><?= e($p['itens']) ?></span>
                      </td>
                      <td data-label="Total" class="num"><strong><?= e(moeda($p['total'])) ?></strong></td>
                      <td data-label="Status"><span class="badge <?= e($classe) ?>"><?= e($rotulo) ?></span></td>
                      <td data-label="Hora" class="muted num"><?= e($p['hora']) ?></td>
                    </tr>
                  <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            <?php endif; ?>
          </div>
        </section>

       
        <section class="card fade-in delay-2">
          <div class="card-head">
            <h2>Mais vendidos</h2>
            <span class="badge badge-preparing">Top <?= count($mais_vendidos) ?></span>
          </div>
          <div class="card-body flush">
            <?php if (empty($mais_vendidos)): ?>
              <div class="empty">
                <div class="empty-art"><?= icone('burger') ?></div>
                <p>Ainda não há vendas para montar o ranking.</p>
              </div>
            <?php else: ?>
              <ol class="rank">
                <?php foreach ($mais_vendidos as $i => $m): ?>
                  <li class="rank-item">
                    <span class="rank-pos"><?= $i + 1 ?></span>
                    <div>
                      <div class="rank-name"><?= e($m['nome']) ?></div>
                      <div class="bar"><i style="--w: <?= round(($m['qtd'] / $max_qtd) * 100) ?>%"></i></div>
                    </div>
                    <div class="rank-qty"><?= (int) $m['qtd'] ?><small>vendidos</small></div>
                  </li>
                <?php endforeach; ?>
              </ol>
            <?php endif; ?>
          </div>
        </section>

      </div>
<?php endif; ?>
    </main>

    <footer class="footer">© <?= date('Y') ?> <?= e($nome_loja) ?> · Sistema de gestão</footer>
  </div>
</div>

<label class="backdrop" for="menu-state" aria-hidden="true"></label>


<div class="modal" id="sair" role="dialog" aria-modal="true" aria-labelledby="sair-titulo">
  <div class="modal-dialog">
    <div class="modal-head">
      <h2 id="sair-titulo">Sair do sistema?</h2>
      <a href="#" class="modal-close" aria-label="Fechar"><?= icone('x') ?></a>
    </div>
    <div class="modal-body">
      <p>Você precisará entrar novamente para acessar o painel.</p>
    </div>
    <div class="modal-foot">
      <a href="#" class="btn btn-outline">Cancelar</a>
      <a href="<?= e($url_logout) ?>" class="btn btn-primary">Sair</a>
    </div>
  </div>
</div>

</body>
</html>