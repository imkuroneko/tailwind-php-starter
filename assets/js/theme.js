/**
 * theme.js — Toggle dark/light mode
 *
 * Estrategia:
 *  - Guarda la preferencia en localStorage ('dark' | 'light')
 *  - Si no hay preferencia guardada, respeta el OS (prefers-color-scheme)
 *  - Agrega/quita la clase `dark` en <html>
 *  - El script de inicialización debe ir en <head> para evitar flash
 */

window.__initTheme = function () {
  const saved = localStorage.getItem('theme');
  const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
  const isDark = saved ? saved === 'dark' : prefersDark;
  document.documentElement.classList.toggle('dark', isDark);
};

window.__toggleTheme = function () {
  const isDark = document.documentElement.classList.toggle('dark');
  localStorage.setItem('theme', isDark ? 'dark' : 'light');

  document.querySelectorAll('[data-theme-toggle]').forEach(btn => {
    updateToggleBtn(btn, isDark);
  });
};

function updateToggleBtn(btn, isDark) {
  if (!btn) return;
  const iconSun  = btn.querySelector('[data-icon-sun]');
  const iconMoon = btn.querySelector('[data-icon-moon]');
  if (iconSun)  iconSun.classList.toggle('hidden', !isDark);
  if (iconMoon) iconMoon.classList.toggle('hidden',  isDark);
  btn.setAttribute('aria-label', isDark ? 'Cambiar a modo claro' : 'Cambiar a modo oscuro');
  btn.setAttribute('title',      isDark ? 'Modo claro'           : 'Modo oscuro');
}

document.addEventListener('DOMContentLoaded', function () {
  const isDark = document.documentElement.classList.contains('dark');
  document.querySelectorAll('[data-theme-toggle]').forEach(btn => {
    updateToggleBtn(btn, isDark);
    btn.addEventListener('click', window.__toggleTheme);
  });
});