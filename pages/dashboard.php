<?php
session_start();

if (empty($_SESSION['user'])) {
    header('Location: login.php');
    exit;
}

$user = $_SESSION['user'];

$menu = [
    [
        'label' => 'General',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />',
        'items' => [
            ['href' => '#', 'label' => 'Inicio'],
            ['href' => '#', 'label' => 'Resumen'],
        ],
    ],
    [
        'label' => 'Gestión',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />',
        'items' => [
            ['href' => '#', 'label' => 'Productos'],
            ['href' => '#', 'label' => 'Categorías'],
            ['href' => '#', 'label' => 'Stock'],
        ],
    ],
    [
        'label' => 'Ventas',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />',
        'items' => [
            ['href' => '#', 'label' => 'Pedidos'],
            ['href' => '#', 'label' => 'Facturas'],
            ['href' => '#', 'label' => 'Clientes'],
        ],
    ],
    [
        'label' => 'Configuración',
        'icon'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />',
        'items' => [
            ['href' => '#', 'label' => 'Usuarios'],
            ['href' => '#', 'label' => 'Permisos'],
            ['href' => '#', 'label' => 'Sistema'],
        ],
    ],
];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>

    <script src="./assets/js/theme.js"></script>
    <script>window.__initTheme();</script>

    <link rel="stylesheet" href="./assets/css/tailwind.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />

    <style>
        html, body { height: 100%; margin: 0; overflow: hidden; font-family: 'DM Sans', sans-serif; }
        .layout { display: flex; height: 100vh; }

        #sidebar {
            width: 256px; flex-shrink: 0;
            border-right: 1px solid var(--border);
            background-color: var(--bg-surface);
            display: flex; flex-direction: column;
            transition: width 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden; z-index: 30;
        }
        #sidebar.collapsed { width: 60px; }

        @media (max-width: 768px) {
            #sidebar {
                position: fixed; top: 0; left: 0; bottom: 0;
                width: 256px !important;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            }
            #sidebar.mobile-open { transform: translateX(0); }
        }

        .sb-hide { transition: opacity 0.2s, width 0.2s; white-space: nowrap; overflow: hidden; }
        #sidebar.collapsed .sb-hide { opacity: 0; width: 0; pointer-events: none; }

        .sbi {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.5rem 0.65rem; border-radius: 0.6rem;
            color: var(--text-muted); cursor: pointer;
            transition: background 0.15s, color 0.15s;
            font-size: 0.875rem; font-weight: 500;
            text-decoration: none; border: none; background: none; width: 100%;
            text-align: left;
        }
        .sbi:hover { background-color: var(--bg-surface-2); color: var(--text-base); }
        .sbi.active { background-color: rgba(99,102,241,0.12); color: #818cf8; }

        .cat-body    { overflow: hidden; transition: max-height 0.28s cubic-bezier(0.4,0,0.2,1); max-height: 0; }
        .cat-body.open { max-height: 280px; }
        .cat-chevron { transition: transform 0.22s; }
        .cat-chevron.open { transform: rotate(180deg); }

        #navbar {
            height: 60px;
            background-color: var(--bg-surface);
            border-bottom: 1px solid var(--border);
            display: flex; align-items: center; padding: 0 1rem; gap: 0.75rem;
            flex-shrink: 0;
        }

        #user-dd {
            background-color: var(--bg-surface);
            transform-origin: top right;
            transition: transform 0.18s cubic-bezier(0.4,0,0.2,1), opacity 0.18s;
        }
        #user-dd.hidden-dd { transform: scale(0.95) translateY(-4px); opacity: 0; pointer-events: none; }

        #modal { transition: opacity 0.2s; }
        #modal.hidden-modal { opacity: 0; pointer-events: none; }
        #modal .modal-card { transition: transform 0.25s cubic-bezier(0.34,1.56,0.64,1), opacity 0.2s; }
        #modal.hidden-modal .modal-card { transform: scale(0.93); opacity: 0; }

        #overlay { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 20; }

        .main-wrap { flex: 1; display: flex; flex-direction: column; min-width: 0; overflow: hidden; }
        #main-content { flex: 1; overflow-y: auto; padding: 1.5rem; }

        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(99,102,241,0.3); border-radius: 99px; }
    </style>
</head>
<body class="surface-page">

<div id="overlay" onclick="closeMobile()"></div>

<div id="modal" class="hidden-modal fixed inset-0 z-50 flex items-center justify-center p-4" style="background:rgba(0,0,0,0.55);backdrop-filter:blur(4px)">
    <div class="modal-card card w-full max-w-sm shadow-2xl">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-10 h-10 rounded-xl bg-red-500/15 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-red-500 dark:text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            <div>
                <p class="text-base-color text-sm font-semibold">Cerrar sesión</p>
                <p class="text-muted text-xs">¿Estás seguro/a?</p>
            </div>
        </div>
        <p class="text-muted text-sm mb-5 leading-relaxed">
            Se cerrará tu sesión actual. Vas a necesitar iniciar sesión nuevamente.
        </p>
        <div class="flex gap-3">
            <button onclick="closeModal()" class="btn-secondary flex-1">Cancelar</button>
            <a href="logout.php" class="btn-danger flex-1 text-center">Sí, cerrar sesión</a>
        </div>
    </div>
</div>

<div class="layout">
    <aside id="sidebar">
        <div class="flex items-center gap-3 px-3.5 h-[60px] flex-shrink-0" style="border-bottom:1px solid var(--border)">
            <div class="w-8 h-8 rounded-lg bg-primary-600 flex items-center justify-center flex-shrink-0 shadow-md shadow-primary-900/30">
                <svg class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <span class="sb-hide font-semibold text-base-color" style="font-family:'DM Serif Display',serif;font-size:1.1rem">
                TailwindPHP
            </span>
        </div>

        <nav class="flex-1 overflow-y-auto px-2.5 py-3 space-y-0.5">
            <?php foreach ($menu as $i => $cat): ?>
            <div>
                <button onclick="toggleCat(<?= $i ?>)" class="sbi" id="cat-<?= $i ?>">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <?= $cat['icon'] ?>
                    </svg>
                    <span class="sb-hide flex-1"><?= htmlspecialchars($cat['label']) ?></span>
                    <svg class="sb-hide cat-chevron w-3.5 h-3.5" id="chev-<?= $i ?>" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <div class="cat-body" id="body-<?= $i ?>">
                    <div class="pl-3 pb-1 space-y-0.5">
                        <?php foreach ($cat['items'] as $item): ?>
                        <a href="<?= htmlspecialchars($item['href']) ?>" class="sbi">
                            <span class="w-1 h-1 rounded-full ml-1 flex-shrink-0" style="background:var(--text-faint)"></span>
                            <span class="sb-hide"><?= htmlspecialchars($item['label']) ?></span>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </nav>

        <div class="px-2.5 pb-3 flex-shrink-0 hidden md:block pt-2" style="border-top:1px solid var(--border)">
            <button onclick="toggleSidebar()" class="sbi" title="Colapsar">
                <svg id="col-icon" class="w-5 h-5 flex-shrink-0 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                </svg>
                <span class="sb-hide">Colapsar</span>
            </button>
        </div>
    </aside>

    <div class="main-wrap">
        <header id="navbar">
            <button onclick="openMobile()" class="md:hidden text-muted hover:text-base-color transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <span class="text-muted text-sm flex-1">Inicio</span>

            <button
                data-theme-toggle
                class="w-8 h-8 rounded-lg flex items-center justify-center text-muted hover:text-base-color transition-colors"
                style="background:var(--bg-surface-2); border:1px solid var(--border)"
            >
                <svg data-icon-sun class="hidden w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="5"/>
                    <path stroke-linecap="round" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
                </svg>
                <svg data-icon-moon class="hidden w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>

            <button class="relative w-8 h-8 flex items-center justify-center text-muted hover:text-base-color transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-1.5 right-1.5 w-1.5 h-1.5 rounded-full bg-primary-500"></span>
            </button>

            <div class="relative">
                <button id="user-btn" onclick="toggleDD()"
                    class="flex items-center gap-2 pl-2 pr-3 py-1.5 rounded-xl transition-colors hover:bg-[var(--bg-surface-2)]">
                    <div class="w-7 h-7 rounded-lg bg-primary-700 flex items-center justify-center text-xs font-bold text-white flex-shrink-0">
                        <?= htmlspecialchars($user['avatar']) ?>
                    </div>
                    <span class="text-sm font-medium text-base-color hidden sm:block max-w-[120px] truncate">
                        <?= htmlspecialchars($user['name']) ?>
                    </span>
                    <svg class="w-3.5 h-3.5 text-faint hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div id="user-dd" class="hidden-dd absolute right-0 top-full mt-2 w-52 rounded-xl shadow-2xl py-1.5 z-40" style="border:1px solid var(--border)">
                    <div class="px-3.5 py-2.5 mb-1" style="border-bottom:1px solid var(--border)">
                        <p class="text-base-color text-xs font-semibold truncate"><?= htmlspecialchars($user['name']) ?></p>
                        <p class="text-faint text-xs">@<?= htmlspecialchars($user['username']) ?></p>
                    </div>
                    <a href="#" class="flex items-center gap-2.5 px-3.5 py-2 text-muted hover:text-base-color hover:bg-[var(--bg-surface-2)] text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Mi cuenta
                    </a>
                    <button onclick="closeDD();openModal();"
                        class="w-full flex items-center gap-2.5 px-3.5 py-2 text-red-500 dark:text-red-400 hover:bg-red-500/10 text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Cerrar sesión
                    </button>
                </div>
            </div>

        </header>

        <main id="main-content" class="surface-page">
            <div class="mb-6">
                <h1 class="text-base-color text-xl font-semibold">Bienvenido/a, <?= htmlspecialchars($user['name']) ?> 👋</h1>
                <p class="text-muted text-sm mt-0.5">Aquí tenés un resumen de lo que está pasando hoy.</p>
            </div>

            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <?php
                $stats = [
                    ['label'=>'Ventas hoy',   'value'=>'₲ 1.240.000', 'delta'=>'+12%', 'badge'=>'badge-success'],
                    ['label'=>'Pedidos',       'value'=>'38',          'delta'=>'+5',   'badge'=>'badge-info'],
                    ['label'=>'Clientes',      'value'=>'214',         'delta'=>'+2',   'badge'=>'badge-primary'],
                    ['label'=>'Stock crítico', 'value'=>'6',           'delta'=>'-3',   'badge'=>'badge-danger'],
                ];
                foreach ($stats as $s): ?>
                <div class="card-hover">
                    <p class="text-muted text-xs font-medium mb-2"><?= $s['label'] ?></p>
                    <p class="text-base-color text-xl font-semibold mb-2"><?= $s['value'] ?></p>
                    <span class="<?= $s['badge'] ?>"><?= $s['delta'] ?> vs ayer</span>
                </div>
                <?php endforeach; ?>
            </div>

            <div class="card p-0 overflow-hidden mb-6">
                <div class="px-5 py-4 flex items-center justify-between" style="border-bottom:1px solid var(--border)">
                    <h3 class="text-base-color font-medium text-sm">Últimos pedidos</h3>
                    <span class="badge-primary">En vivo</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="table-base">
                        <thead>
                            <tr>
                                <th>#</th><th>Cliente</th><th>Total</th><th>Estado</th><th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $orders = [
                                ['id'=>'#0091','client'=>'Luisa Pérez',  'total'=>'₲ 85.000',  'badge'=>'badge-success','status'=>'Entregado', 'date'=>'hoy, 10:32'],
                                ['id'=>'#0090','client'=>'Carlos Vera',  'total'=>'₲ 210.000', 'badge'=>'badge-info',   'status'=>'En camino', 'date'=>'hoy, 09:15'],
                                ['id'=>'#0089','client'=>'María López',  'total'=>'₲ 43.500',  'badge'=>'badge-warning','status'=>'Pendiente', 'date'=>'ayer, 17:50'],
                                ['id'=>'#0088','client'=>'Roberto Díaz', 'total'=>'₲ 128.000', 'badge'=>'badge-danger', 'status'=>'Cancelado', 'date'=>'ayer, 14:10'],
                                ['id'=>'#0087','client'=>'Ana Benítez',  'total'=>'₲ 67.000',  'badge'=>'badge-success','status'=>'Entregado', 'date'=>'ayer, 11:40'],
                            ];
                            foreach ($orders as $o): ?>
                            <tr>
                                <td class="text-faint font-mono text-xs"><?= $o['id'] ?></td>
                                <td class="text-base-color"><?= $o['client'] ?></td>
                                <td class="text-base-color font-medium"><?= $o['total'] ?></td>
                                <td><span class="<?= $o['badge'] ?>"><?= $o['status'] ?></span></td>
                                <td class="text-muted"><?= $o['date'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <h3 class="text-base-color font-medium text-sm mb-4">Demo — clases dinámicas con safelist</h3>
                <div class="flex flex-wrap gap-3">
                    <?php
                    $demo = [
                        [ 'color' => 'red',    'shade'=>500, 'label' => 'Rojo' ],
                        [ 'color' => 'orange', 'shade'=>500, 'label' => 'Naranja' ],
                        [ 'color' => 'yellow', 'shade'=>400, 'label' => 'Amarillo' ],
                        [ 'color' => 'green',  'shade'=>500, 'label' => 'Verde' ],
                        [ 'color' => 'blue',   'shade'=>500, 'label' => 'Azul' ],
                        [ 'color' => 'violet', 'shade'=>500, 'label' => 'Violeta' ],
                        [ 'color' => 'pink',   'shade'=>500, 'label' => 'Rosa' ],
                    ];
                    foreach ($demo as $d): ?>
                    <span class="badge bg-<?= $d['color'] ?>-<?= $d['shade'] ?>/15 text-<?= $d['color'] ?>-500 dark:text-<?= $d['color'] ?>-400">
                        <?= $d['label'] ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <p class="text-faint text-xs mt-3">
                    Clases generadas dinámicamente con PHP — incluidas gracias al safelist en <code class="text-primary-500 dark:text-primary-400">tailwind.config.js</code>
                </p>
            </div>

        </main>
    </div>

</div>

<script src="./assets/js/theme.js"></script>
<script>
// Sidebar collapse
let collapsed = false;
function toggleSidebar() {
    collapsed = !collapsed;
    document.getElementById('sidebar').classList.toggle('collapsed', collapsed);
    document.getElementById('col-icon').style.transform = collapsed ? 'rotate(180deg)' : '';
}
function openMobile()  { document.getElementById('sidebar').classList.add('mobile-open');    document.getElementById('overlay').style.display='block'; }
function closeMobile() { document.getElementById('sidebar').classList.remove('mobile-open'); document.getElementById('overlay').style.display='none';  }

// Categorías
function toggleCat(i) {
    const body = document.getElementById('body-'+i);
    const chev = document.getElementById('chev-'+i);
    const open = body.classList.contains('open');
    document.querySelectorAll('.cat-body').forEach(b => b.classList.remove('open'));
    document.querySelectorAll('.cat-chevron').forEach(c => c.classList.remove('open'));
    if (!open) { body.classList.add('open'); chev.classList.add('open'); }
}
toggleCat(0);

// User dropdown
let ddOpen = false;
function toggleDD() { ddOpen = !ddOpen; document.getElementById('user-dd').classList.toggle('hidden-dd', !ddOpen); }
function closeDD()  { ddOpen = false;   document.getElementById('user-dd').classList.add('hidden-dd'); }
document.addEventListener('click', e => {
    if (!document.getElementById('user-btn').contains(e.target) &&
        !document.getElementById('user-dd').contains(e.target)) closeDD();
});

// Modal
function openModal()  { document.getElementById('modal').classList.remove('hidden-modal'); }
function closeModal() { document.getElementById('modal').classList.add('hidden-modal'); }
document.addEventListener('keydown', e => { if(e.key==='Escape') closeModal(); });
</script>
</body>
</html>