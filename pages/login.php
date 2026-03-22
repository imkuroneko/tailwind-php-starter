<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    # Reemplazar con lógica real de autenticación (just dummy thing)
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['user'] = [
            'name'     => 'Administrador',
            'username' => $username,
            'avatar'   => strtoupper(substr($username, 0, 1)),
        ];
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Usuario o contraseña incorrectos.';
    }
}

if (!empty($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Iniciar sesión</title>

    <script src="./assets/js/theme.js"></script>
    <script>window.__initTheme();</script>

    <link rel="stylesheet" href="./assets/css/tailwind.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&family=DM+Serif+Display&display=swap" rel="stylesheet" />
    <style>
        body { font-family: 'DM Sans', sans-serif; }
        .noise-bg {
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 40%, rgba(99,102,241,0.12) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 80% 70%, rgba(139,92,246,0.08) 0%, transparent 70%);
        }
        .dark .noise-bg {
            background-image:
                radial-gradient(ellipse 80% 60% at 20% 40%, rgba(99,102,241,0.18) 0%, transparent 70%),
                radial-gradient(ellipse 60% 50% at 80% 70%, rgba(139,92,246,0.12) 0%, transparent 70%);
        }
        .card-glow {
            box-shadow: 0 0 0 1px rgba(99,102,241,0.1),
                        0 24px 48px -12px rgba(0,0,0,0.15);
        }
        .dark .card-glow {
            box-shadow: 0 0 0 1px rgba(99,102,241,0.12),
                        0 32px 64px -12px rgba(0,0,0,0.6),
                        0 0 80px -20px rgba(99,102,241,0.18);
        }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp 0.45s cubic-bezier(0.22,1,0.36,1) forwards; }
    </style>
</head>
<body class="noise-bg min-h-screen flex items-center justify-center px-4 surface-page">
    <div class="fixed top-4 right-4">
        <button
            data-theme-toggle
            aria-label="Cambiar tema"
            class="w-9 h-9 rounded-xl flex items-center justify-center
                surface-2 border border-theme text-muted
                hover:text-base-color transition-colors"
        >
            <svg data-icon-sun class="hidden w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="12" cy="12" r="5"/>
                <path stroke-linecap="round" d="M12 1v2M12 21v2M4.22 4.22l1.42 1.42M18.36 18.36l1.42 1.42M1 12h2M21 12h2M4.22 19.78l1.42-1.42M18.36 5.64l1.42-1.42"/>
            </svg>
            <svg data-icon-moon class="hidden w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
            </svg>
        </button>
    </div>

    <div class="w-full max-w-md fade-up">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-primary-600 mb-4 shadow-lg shadow-primary-900/30">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                </svg>
            </div>
            <h1 class="text-3xl text-base-color leading-tight" style="font-family:'DM Serif Display',serif">MiPlataforma</h1>
            <p class="text-muted text-sm mt-1">Panel de administración</p>
        </div>

        <div class="card card-glow">

            <?php if ($error): ?>
            <div class="alert-error mb-5">
                <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-4">
                    <label for="username" class="input-label">Usuario</label>
                    <input type="text" id="username" name="username"
                        required autocomplete="username"
                        placeholder="tu_usuario"
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
                        class="input" />
                </div>

                <div class="mb-6">
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="input-label mb-0">Contraseña</label>
                        <a href="#" class="text-xs text-primary-500 hover:text-primary-600 dark:text-primary-400 dark:hover:text-primary-300 transition-colors">
                            ¿Olvidaste tu clave?
                        </a>
                    </div>
                    <input type="password" id="password" name="password"
                        required autocomplete="current-password"
                        placeholder="••••••••"
                        class="input" />
                </div>

                <button type="submit" class="btn-primary w-full py-3">
                    Iniciar sesión
                </button>
            </form>

        </div>

        <p class="text-center text-faint text-xs mt-6">
            &copy; <?= date('Y') ?> MiPlataforma — Todos los derechos reservados
        </p>
    </div>
</body>
</html>