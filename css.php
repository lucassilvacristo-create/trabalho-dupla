
<?php
/**
 * css.php — Folha de estilos central do sistema da hamburgueria.
 * Uso: <link rel="stylesheet" href="css.php">
 * Servido como CSS, com cache do navegador (invalida quando este arquivo muda).
 */
$versao = filemtime(__FILE__);
$etag   = '"' . md5((string) $versao) . '"';

header('Content-Type: text/css; charset=utf-8');
header('Cache-Control: public, max-age=3600');
header('ETag: ' . $etag);

if (isset($_SERVER['HTTP_IF_NONE_MATCH']) && trim($_SERVER['HTTP_IF_NONE_MATCH']) === $etag) {
    http_response_code(304);
    exit;
}
?>
/* ==========================================================================
   1. VARIÁVEIS GLOBAIS
   ========================================================================== */
:root {
  --red-dark:   #B22222;
  --red:        #D62828;
  --mustard:    #F4B942;
  --black:      #171717;
  --gray-dark:  #252525;
  --bg:         #F5F2EC;
  --white:      #FFFFFF;

  /* derivadas */
  --mustard-soft: #FDF0D2;
  --red-soft:     #FBE3E3;
  --line:         #E7E1D6;
  --muted:        #7A7468;
  --ok:           #2E8B57;
  --ok-soft:      #DDF1E6;
  --info:         #2B6CB0;
  --info-soft:    #DFEBF8;

  --radius-sm: 10px;
  --radius:    16px;
  --radius-lg: 24px;
  --shadow-sm: 0 2px 6px rgba(23,23,23,.06);
  --shadow:    0 8px 24px rgba(23,23,23,.09);
  --shadow-lg: 0 20px 50px rgba(23,23,23,.22);

  --font-display: "Trebuchet MS", "Segoe UI", "Helvetica Neue", Arial, sans-serif;
  --font-body:    "Segoe UI", system-ui, -apple-system, "Helvetica Neue", Arial, sans-serif;

  --sidebar-w: 260px;
  --header-h:  72px;
  --ease: cubic-bezier(.22,.8,.3,1);
}

/* ==========================================================================
   2. RESET + BODY + TIPOGRAFIA
   ========================================================================== */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; -webkit-text-size-adjust: 100%; }

body {
  font-family: var(--font-body);
  font-size: 15px;
  line-height: 1.5;
  color: var(--black);
  background-color: var(--bg);
  /* textura sutil de "papel de embalagem" */
  background-image: radial-gradient(rgba(23,23,23,.045) 1px, transparent 1px);
  background-size: 18px 18px;
  min-height: 100vh;
}

h1, h2, h3, h4 { font-family: var(--font-display); line-height: 1.2; letter-spacing: -.01em; }
h1 { font-size: 1.75rem; font-weight: 800; }
h2 { font-size: 1.2rem;  font-weight: 800; }
h3 { font-size: 1rem;    font-weight: 700; }
a  { color: inherit; text-decoration: none; }
ul { list-style: none; }
img, svg { display: block; max-width: 100%; }
button, input, select, textarea { font: inherit; color: inherit; }
:focus-visible { outline: 3px solid var(--mustard); outline-offset: 2px; }

.muted   { color: var(--muted); }
.text-sm { font-size: .85rem; }
.text-right { text-align: right; }
.sr-only {
  position: absolute; width: 1px; height: 1px; overflow: hidden;
  clip: rect(0 0 0 0); white-space: nowrap;
}

/* ==========================================================================
   3. ÍCONES (sprite SVG inline — sem dependências externas)
   ========================================================================== */
.icon {
  width: 20px; height: 20px; flex: none;
  fill: none; stroke: currentColor;
  stroke-width: 2; stroke-linecap: round; stroke-linejoin: round;
}
.icon-sm { width: 16px; height: 16px; }
.icon-lg { width: 26px; height: 26px; }

/* ==========================================================================
   4. LAYOUT BASE
   ========================================================================== */
.app { display: grid; grid-template-columns: var(--sidebar-w) 1fr; min-height: 100vh; }
.main { min-width: 0; display: flex; flex-direction: column; }
.content { padding: 28px clamp(16px, 3vw, 40px) 48px; max-width: 1400px; width: 100%; margin: 0 auto; flex: 1; }

.page-head {
  display: flex; align-items: flex-end; justify-content: space-between;
  gap: 16px; flex-wrap: wrap; margin-bottom: 24px;
}
.page-head p { color: var(--muted); margin-top: 4px; }

.grid { display: grid; gap: 20px; }
.grid-stats { grid-template-columns: repeat(4, 1fr); }
.grid-main  { grid-template-columns: minmax(0, 1.7fr) minmax(0, 1fr); margin-top: 20px; align-items: start; }

.footer { text-align: center; color: var(--muted); font-size: .8rem; padding: 18px; }

/* ==========================================================================
   5. CABEÇALHO
   ========================================================================== */
.header {
  position: sticky; top: 0; z-index: 30;
  height: var(--header-h);
  display: flex; align-items: center; gap: 16px;
  padding: 0 clamp(16px, 3vw, 40px);
  background: rgba(245,242,236,.88);
  backdrop-filter: blur(10px);
  border-bottom: 1px solid var(--line);
}
.menu-toggle { display: none; }

.search {
  position: relative; flex: 1; max-width: 420px;
}
.search .icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); }
.search .input { padding-left: 44px; border-radius: 999px; background: var(--white); }

.header-actions { margin-left: auto; display: flex; align-items: center; gap: 10px; }

.icon-btn {
  position: relative; width: 44px; height: 44px; display: grid; place-items: center;
  background: var(--white); border: 1px solid var(--line); border-radius: 50%;
  cursor: pointer; color: var(--gray-dark);
  transition: transform .2s var(--ease), background .2s, color .2s, box-shadow .2s;
}
.icon-btn:hover { background: var(--mustard); color: var(--black); transform: translateY(-2px); box-shadow: var(--shadow-sm); }
.icon-btn .dot {
  position: absolute; top: 9px; right: 10px; width: 10px; height: 10px;
  background: var(--red); border: 2px solid var(--white); border-radius: 50%;
  animation: pulse 2s infinite;
}

.user {
  display: flex; align-items: center; gap: 10px;
  padding: 5px 14px 5px 5px; background: var(--white);
  border: 1px solid var(--line); border-radius: 999px;
}
.avatar {
  width: 36px; height: 36px; border-radius: 50%; display: grid; place-items: center;
  font-family: var(--font-display); font-weight: 800; color: var(--white);
  background: linear-gradient(135deg, var(--red), var(--red-dark));
}
.user-info { line-height: 1.15; }
.user-info strong { display: block; font-size: .88rem; }
.user-info span   { font-size: .75rem; color: var(--muted); }

/* ==========================================================================
   6. MENU LATERAL
   ========================================================================== */
.sidebar {
  position: sticky; top: 0; height: 100vh; overflow-y: auto;
  display: flex; flex-direction: column; gap: 8px;
  padding: 22px 16px;
  color: #E9E4DA;
  background:
    radial-gradient(circle at 0% 0%, rgba(214,40,40,.28), transparent 45%),
    linear-gradient(180deg, var(--black), var(--gray-dark));
}

.brand { display: flex; align-items: center; gap: 12px; padding: 4px 8px 20px; }
.brand-mark {
  width: 46px; height: 46px; border-radius: 14px; display: grid; place-items: center;
  background: var(--mustard); color: var(--black);
  box-shadow: 0 6px 16px rgba(244,185,66,.35);
  transform: rotate(-6deg); transition: transform .35s var(--ease);
}
.brand:hover .brand-mark { transform: rotate(6deg) scale(1.06); }
.brand-mark .icon { width: 28px; height: 28px; }
.brand-name { font-family: var(--font-display); font-weight: 900; font-size: 1.25rem; line-height: 1; color: var(--white); }
.brand-name span { color: var(--mustard); }
.brand-sub { font-size: .68rem; letter-spacing: .2em; text-transform: uppercase; color: #A59F93; margin-top: 4px; }

.nav-label { font-size: .68rem; letter-spacing: .16em; text-transform: uppercase; color: #8E887C; padding: 14px 12px 6px; }

.nav a {
  position: relative; display: flex; align-items: center; gap: 12px;
  padding: 11px 14px; margin-bottom: 4px; border-radius: 12px;
  color: #D8D2C6; font-weight: 600; font-size: .94rem;
  transition: background .2s, color .2s, transform .2s var(--ease);
}
.nav a:hover { background: rgba(255,255,255,.08); color: var(--white); transform: translateX(4px); }
.nav a.active {
  color: var(--white);
  background: linear-gradient(90deg, var(--red), var(--red-dark));
  box-shadow: 0 8px 18px rgba(214,40,40,.35);
}
.nav a.active::after {
  content: ""; position: absolute; right: -16px; top: 20%; bottom: 20%; width: 5px;
  background: var(--mustard); border-radius: 5px 0 0 5px;
}
.nav .badge-count {
  margin-left: auto; min-width: 22px; padding: 1px 7px; text-align: center;
  font-size: .72rem; font-weight: 800; border-radius: 999px;
  background: var(--mustard); color: var(--black);
}

.sidebar-foot { margin-top: auto; padding-top: 16px; }
.promo {
  padding: 16px; border-radius: var(--radius);
  background: rgba(244,185,66,.12); border: 1px dashed rgba(244,185,66,.5);
  font-size: .82rem; color: #E9DFC6;
}
.promo strong { display: block; color: var(--mustard); font-family: var(--font-display); margin-bottom: 2px; }
.sidebar .logout { margin-top: 12px; }

.backdrop { display: none; }

/* ==========================================================================
   7. BOTÕES
   ========================================================================== */
.btn {
  display: inline-flex; align-items: center; justify-content: center; gap: 8px;
  padding: 11px 20px; border: 2px solid transparent; border-radius: 999px;
  font-weight: 700; font-size: .92rem; cursor: pointer; white-space: nowrap;
  transition: transform .2s var(--ease), box-shadow .2s, background .2s, color .2s, border-color .2s;
}
.btn:hover  { transform: translateY(-2px); }
.btn:active { transform: translateY(0) scale(.97); }

.btn-primary { background: var(--red); color: var(--white); box-shadow: 0 6px 16px rgba(214,40,40,.32); }
.btn-primary:hover { background: var(--red-dark); box-shadow: 0 10px 22px rgba(178,34,34,.4); }

.btn-accent { background: var(--mustard); color: var(--black); box-shadow: 0 6px 16px rgba(244,185,66,.38); }
.btn-accent:hover { background: #ffc95a; }

.btn-outline { background: transparent; color: var(--black); border-color: var(--black); }
.btn-outline:hover { background: var(--black); color: var(--white); }

.btn-ghost { background: transparent; color: inherit; }
.btn-ghost:hover { background: rgba(255,255,255,.1); }

.btn-block { width: 100%; }
.btn-sm { padding: 7px 14px; font-size: .82rem; }

/* ==========================================================================
   8. CARDS
   ========================================================================== */
.card {
  background: var(--white); border: 1px solid var(--line);
  border-radius: var(--radius); box-shadow: var(--shadow-sm);
  transition: transform .25s var(--ease), box-shadow .25s;
}
.card-hover:hover { transform: translateY(-4px); box-shadow: var(--shadow); }
.card-head {
  display: flex; align-items: center; justify-content: space-between; gap: 12px;
  padding: 20px 22px 0;
}
.card-body { padding: 18px 22px 22px; }
.card-body.flush { padding: 10px 0 6px; }

/* Cards de indicadores */
.stat {
  position: relative; overflow: hidden; padding: 22px;
  animation: rise .6s var(--ease) both;
}
.stat:nth-child(2) { animation-delay: .07s; }
.stat:nth-child(3) { animation-delay: .14s; }
.stat:nth-child(4) { animation-delay: .21s; }
.stat::after { /* "gergelim" decorativo */
  content: ""; position: absolute; right: -28px; bottom: -28px; width: 110px; height: 110px;
  border-radius: 50%; background: var(--stat-tint, var(--mustard-soft)); opacity: .9;
}
.stat-icon {
  position: relative; z-index: 1; width: 48px; height: 48px; border-radius: 14px;
  display: grid; place-items: center;
  background: var(--stat-tint, var(--mustard-soft)); color: var(--stat-color, var(--red));
}
.stat-label { position: relative; z-index: 1; margin-top: 16px; color: var(--muted); font-size: .85rem; font-weight: 600; }
.stat-value { position: relative; z-index: 1; font-family: var(--font-display); font-size: 2rem; font-weight: 900; letter-spacing: -.02em; }
.stat-note  { position: relative; z-index: 1; font-size: .8rem; color: var(--muted); margin-top: 2px; }
.stat-note b { color: var(--ok); }
.stat--red     { --stat-tint: var(--red-soft);     --stat-color: var(--red); }
.stat--mustard { --stat-tint: var(--mustard-soft); --stat-color: #B27800; }
.stat--dark    { --stat-tint: #E9E6DF;             --stat-color: var(--black); }
.stat--green   { --stat-tint: var(--ok-soft);      --stat-color: var(--ok); }

/* Faixa de destaque (pedidos em andamento) */
.banner {
  display: flex; align-items: center; gap: 18px; flex-wrap: wrap;
  padding: 20px 24px; margin-bottom: 20px; border-radius: var(--radius-lg);
  color: var(--white);
  background:
    radial-gradient(circle at 95% 10%, rgba(244,185,66,.35), transparent 40%),
    linear-gradient(120deg, var(--red-dark), var(--red));
  box-shadow: 0 14px 30px rgba(178,34,34,.3);
  animation: rise .5s var(--ease) both;
}
.banner h2 { font-size: 1.3rem; }
.banner p  { opacity: .9; font-size: .92rem; }
.banner .btn { margin-left: auto; }
.banner-icon { width: 54px; height: 54px; border-radius: 16px; display: grid; place-items: center; background: rgba(255,255,255,.18); }

/* Ranking de produtos */
.rank { display: flex; flex-direction: column; }
.rank-item {
  display: grid; grid-template-columns: 34px 1fr auto; gap: 14px; align-items: center;
  padding: 13px 22px; border-top: 1px solid var(--line);
  transition: background .2s;
}
.rank-item:first-child { border-top: 0; }
.rank-item:hover { background: #FBF9F4; }
.rank-pos {
  width: 34px; height: 34px; border-radius: 10px; display: grid; place-items: center;
  font-family: var(--font-display); font-weight: 900; background: var(--bg); color: var(--gray-dark);
}
.rank-item:nth-child(1) .rank-pos { background: var(--mustard); }
.rank-item:nth-child(2) .rank-pos { background: #E4DED0; }
.rank-item:nth-child(3) .rank-pos { background: #F0D6B8; }
.rank-name { font-weight: 700; }
.bar { height: 6px; margin-top: 6px; border-radius: 6px; background: var(--bg); overflow: hidden; }
.bar > i {
  display: block; height: 100%; width: var(--w, 0%); border-radius: 6px;
  background: linear-gradient(90deg, var(--mustard), var(--red));
  animation: grow .9s var(--ease) both;
}
.rank-qty { font-family: var(--font-display); font-weight: 800; text-align: right; line-height: 1.1; }
.rank-qty small { display: block; font-family: var(--font-body); font-weight: 500; color: var(--muted); font-size: .72rem; }

/* Estado vazio */
.empty { text-align: center; padding: 56px 24px; }
.empty-art {
  width: 84px; height: 84px; margin: 0 auto 16px; border-radius: 50%; display: grid; place-items: center;
  background: var(--mustard-soft); color: #B27800; animation: float 3s ease-in-out infinite;
}
.empty-art .icon { width: 42px; height: 42px; }
.empty p { color: var(--muted); max-width: 420px; margin: 6px auto 0; }

/* ==========================================================================
   9. TABELAS
   ========================================================================== */
.table-wrap { overflow-x: auto; }
.table { width: 100%; border-collapse: collapse; font-size: .92rem; }
.table th {
  text-align: left; padding: 12px 22px; font-size: .72rem; font-weight: 800;
  text-transform: uppercase; letter-spacing: .08em; color: var(--muted);
  border-bottom: 2px solid var(--line); white-space: nowrap;
}
.table td { padding: 14px 22px; border-bottom: 1px solid var(--line); vertical-align: middle; }
.table tbody tr { transition: background .2s; }
.table tbody tr:hover { background: #FBF9F4; }
.table tbody tr:last-child td { border-bottom: 0; }
.table .num { font-variant-numeric: tabular-nums; white-space: nowrap; }
.cell-main strong { display: block; }
.cell-main span { font-size: .8rem; color: var(--muted); }

/* ==========================================================================
   10. BADGES DE STATUS
   ========================================================================== */
.badge {
  display: inline-flex; align-items: center; gap: 6px;
  padding: 4px 11px; border-radius: 999px; font-size: .75rem; font-weight: 800; white-space: nowrap;
  background: #ECE8DF; color: var(--gray-dark);
}
.badge::before { content: ""; width: 7px; height: 7px; border-radius: 50%; background: currentColor; }
.badge-new       { background: var(--info-soft);    color: var(--info); }
.badge-preparing { background: var(--mustard-soft); color: #9A6700; }
.badge-delivery  { background: #EAE3F8;             color: #5B3FA6; }
.badge-done      { background: var(--ok-soft);      color: var(--ok); }
.badge-cancel    { background: var(--red-soft);     color: var(--red-dark); }
.badge-preparing::before, .badge-new::before { animation: pulse 1.6s infinite; }

/* ==========================================================================
   11. FORMULÁRIOS, INPUTS E SELECTS
   ========================================================================== */
.form { display: grid; gap: 16px; }
.form-row { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
.field { display: flex; flex-direction: column; gap: 6px; }
.label { font-size: .82rem; font-weight: 700; color: var(--gray-dark); }
.hint  { font-size: .76rem; color: var(--muted); }

.input, .select, .textarea {
  width: 100%; padding: 11px 14px; background: var(--white);
  border: 2px solid var(--line); border-radius: var(--radius-sm);
  transition: border-color .2s, box-shadow .2s;
}
.input::placeholder, .textarea::placeholder { color: #ADA697; }
.input:hover, .select:hover, .textarea:hover { border-color: #D3CBBB; }
.input:focus, .select:focus, .textarea:focus {
  outline: none; border-color: var(--mustard); box-shadow: 0 0 0 4px rgba(244,185,66,.25);
}
.select {
  appearance: none; padding-right: 40px; cursor: pointer;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='%23252525' stroke-width='3' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
  background-repeat: no-repeat; background-position: right 14px center;
}
.select-inline { width: auto; padding-top: 8px; padding-bottom: 8px; font-size: .85rem; }
.textarea { min-height: 96px; resize: vertical; }
.input.is-invalid, .select.is-invalid { border-color: var(--red); }
.error-text { color: var(--red); font-size: .78rem; font-weight: 600; }

/* Mensagens de feedback (sucesso, erro, aviso) */
.alert { padding: 12px 16px; border-radius: var(--radius-sm); font-weight: 600; font-size: .9rem; border-left: 5px solid; margin-bottom: 16px; animation: rise .4s var(--ease) both; }
.alert-ok    { background: var(--ok-soft);      border-color: var(--ok);      color: #1D6B40; }
.alert-error { background: var(--red-soft);     border-color: var(--red);     color: var(--red-dark); }
.alert-warn  { background: var(--mustard-soft); border-color: var(--mustard); color: #7A5200; }

/* ==========================================================================
   12. MODAIS (100% CSS — abre com :target)
   ========================================================================== */
.modal {
  position: fixed; inset: 0; z-index: 100; display: grid; place-items: center; padding: 20px;
  background: rgba(23,23,23,.6); backdrop-filter: blur(4px);
  opacity: 0; visibility: hidden; transition: opacity .25s, visibility .25s;
}
.modal:target { opacity: 1; visibility: visible; }
.modal-dialog {
  width: 100%; max-width: 460px; background: var(--white); border-radius: var(--radius-lg);
  box-shadow: var(--shadow-lg); overflow: hidden; transform: translateY(24px) scale(.96);
  transition: transform .3s var(--ease);
}
.modal:target .modal-dialog { transform: none; }
.modal-head {
  display: flex; align-items: center; justify-content: space-between; padding: 18px 22px;
  color: var(--white); background: linear-gradient(120deg, var(--black), var(--gray-dark));
  border-bottom: 4px solid var(--mustard);
}
.modal-body { padding: 22px; }
.modal-foot { display: flex; justify-content: flex-end; gap: 10px; padding: 0 22px 22px; }
.modal-close { color: var(--white); width: 36px; height: 36px; display: grid; place-items: center; border-radius: 50%; transition: background .2s; }
.modal-close:hover { background: rgba(255,255,255,.15); }

/* ==========================================================================
   13. ANIMAÇÕES
   ========================================================================== */
@keyframes rise  { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: none; } }
@keyframes grow  { from { width: 0; } }
@keyframes float { 0%,100% { transform: translateY(0); } 50% { transform: translateY(-8px); } }
@keyframes pulse { 0%,100% { opacity: 1; } 50% { opacity: .35; } }

.fade-in { animation: rise .55s var(--ease) both; }
.delay-1 { animation-delay: .1s; }
.delay-2 { animation-delay: .2s; }

@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation: none !important; transition: none !important; scroll-behavior: auto !important; }
}

/* ==========================================================================
   14. RESPONSIVIDADE
   ========================================================================== */
/* Notebooks / tablets grandes */
@media (max-width: 1200px) {
  .grid-stats { grid-template-columns: repeat(2, 1fr); }
  .grid-main  { grid-template-columns: 1fr; }
}

/* Tablets: menu vira gaveta */
@media (max-width: 900px) {
  .app { grid-template-columns: 1fr; }
  .sidebar {
    position: fixed; z-index: 60; left: 0; top: 0; width: min(300px, 86vw);
    transform: translateX(-100%); transition: transform .3s var(--ease);
    box-shadow: var(--shadow-lg);
  }
  .nav a.active::after { display: none; }
  #menu-state:checked ~ .app .sidebar { transform: none; }
  #menu-state:checked ~ .backdrop {
    display: block; position: fixed; inset: 0; z-index: 50; background: rgba(23,23,23,.55);
    animation: rise .2s both;
  }
  .menu-toggle { display: grid; }
}

/* Celulares */
@media (max-width: 640px) {
  body { font-size: 14px; }
  h1 { font-size: 1.45rem; }
  .header { gap: 10px; }
  .search { display: none; }
  .user-info { display: none; }
  .user { padding: 4px; }
  .grid-stats { grid-template-columns: 1fr; gap: 14px; }
  .stat-value { font-size: 1.7rem; }
  .form-row { grid-template-columns: 1fr; }
  .banner .btn { margin-left: 0; width: 100%; }
  .page-head .btn { width: 100%; }
  .table th, .table td { padding: 12px 14px; }
  .rank-item, .card-head { padding-left: 16px; padding-right: 16px; }
  .card-body { padding: 14px 16px 18px; }
  /* tabela em formato de lista no celular */
  .table-stack thead { display: none; }
  .table-stack tr { display: block; padding: 12px 16px; border-bottom: 1px solid var(--line); }
  .table-stack td { display: flex; justify-content: space-between; gap: 12px; padding: 4px 0; border: 0; }
  .table-stack td::before { content: attr(data-label); font-size: .72rem; font-weight: 800; text-transform: uppercase; letter-spacing: .06em; color: var(--muted); }
}

/* Impressão: só o conteúdo */
@media print {
  .sidebar, .header, .backdrop, .btn, .footer { display: none !important; }
  .app { display: block; }
  body { background: #fff; }
  .card { box-shadow: none; }
}