<h2 align="center">💨 tailwind-php-starter </h2>

Base super simple para dashboard en **PHP** + **Tailwind CSS v3**, sin CDN, y soporte para dark/light mode.


## 🦄 Empezar a utilizar
```bash
npm install      # instalar recursos
npm run dev      # rebuildea el css según ajustes realizados
npm run build    # build minified listo para producción
```

---

## 🔥 Importante
- Toggle Dark/Light mode en el navbar y login
- CSS variables para tokens de color (`--bg-surface`, `--text-base`, ...)
- Todos los componentes adaptativos (funcionan en ambos temas)
- `assets/js/theme.js` — lógica reutilizable para cualquier página nueva
- Anti-flash: el tema se aplica antes del primer paint del browser

---

## 🗺️ Estructura

```
├── src/
│   └── input.css               ← fuente Tailwind (vars de CSS y componentes)
├── assets/
│   ├── css/
│   │   └── tailwind.css        ← CSS generado listo para usar
│   └── js/
│       └── theme.js            ← toggle dark/light reutilizable
├── pages/                      ← demo de componentes y base simple responsive para replicar para dashboard
│   ├── index.html
│   ├── login.php
│   ├── dashboard.php
│   └── logout.php
├── tailwind.config.js
├── package.json
├── .gitignore
└── readme.md                   ← usted está aquí 
```

---

## 🖍️ Comportamiento del tema

| Situación | Tema aplicado |
|---|---|
| Primera visita, OS en dark | Dark |
| Primera visita, OS en light | Light |
| Usuario eligió dark manualmente | Dark (guardado en localStorage) |
| Usuario eligió light manualmente | Light (guardado en localStorage) |

---

## 🎨 CSS Variables de color

Los componentes usan variables CSS definidas en `src/input.css` en vez de
clases hardcodeadas. Esto hace que cambiar de tema sea instantáneo.

```css
/* Light */
:root {
    --bg-page:      theme('colors.gray.50');
    --bg-surface:   theme('colors.white');
    --text-base:    theme('colors.gray.900');
    --text-muted:   theme('colors.gray.500');
    --border:       theme('colors.gray.200');
    ...
}

/* Dark */
.dark {
    --bg-page:      #0d0d17;
    --bg-surface:   #13131f;
    --text-base:    theme('colors.gray.100');
    --text-muted:   theme('colors.gray.400');
    --border:       rgba(255,255,255,0.08);
    ...
}
```

**Usá las clases utilitarias custom en tus PHP:**

```html
<body class="surface-page">         <!-- bg: var(--bg-page) -->
<div class="surface">               <!-- bg: var(--bg-surface) -->
<p class="text-base-color">         <!-- color: var(--text-base) -->
<p class="text-muted">              <!-- color: var(--text-muted) -->
<p class="text-faint">              <!-- color: var(--text-faint) -->
<div class="border-theme">          <!-- border-color: var(--border) -->
```

**O directamente con `style` inline para casos puntuales:**

```html
<div style="background:var(--bg-surface-2); border:1px solid var(--border)">
```

---

## ⚙️ Componentes

Usá estas clases en tus PHP directamente:

```html
<!-- Botones -->
<button class="btn-primary">Guardar</button>
<button class="btn-secondary">Cancelar</button>
<button class="btn-danger">Eliminar</button>
<button class="btn-ghost">Ver más</button>

<!-- Inputs -->
<label class="input-label">Email</label>
<input class="input" type="email" />

<!-- Cards -->
<div class="card">...</div>
<div class="card-hover">...</div>    <!-- con efecto hover -->

<!-- Badges -->
<span class="badge-success">Activo</span>
<span class="badge-warning">Pendiente</span>
<span class="badge-danger">Error</span>
<span class="badge-info">Info</span>
<span class="badge-primary">Nuevo</span>

<!-- Alerts -->
<div class="alert-success">Todo OK</div>
<div class="alert-error">Algo falló</div>
<div class="alert-warning">Atención</div>
<div class="alert-info">Info</div>

<!-- Tabla -->
<table class="table-base">...</table>

<!-- Divider -->
<div class="divider"></div>

<!-- Utilidades -->
<p class="text-gradient-primary">Gradiente</p>
<div class="glow-primary">Glow</div>
```

---

## Color primary

Editá el objeto `primary` al inicio de `tailwind.config.js`:

```js
const primary = {
  50:  '#f0fdf4',
  500: '#22c55e',   // verde
  600: '#16a34a',
  ...
};
```

Generadores de paleta: https://uicolors.app/create — https://www.tints.dev

---

## 🛡️ Safelist

El safelist cubre todos los colores de Tailwind v3 + `primary` con variantes `hover:`, `focus:`, `dark:`, etc. para clases generadas dinámicamente en PHP.

---

## ☁️ Que se sube al servidor

Todo el content en `assets/`, todos tus archivos `*.php` y los demás que hayas creado en su momento. <br/>
Omitir la carpeta `node_modules/` y `src/` y consecuentes


---

🦄 Este readme tiene emojis solo porque me gusta (y me sirve de guía rápida/visual)
🤖 La base experimental de UI de dashboard fue hecho con Claude Sonnet 4.6 (work smart, not hard)
