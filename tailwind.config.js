/** @type {import('tailwindcss').Config} */

/**
 * 🎨 Paleta de colores para la UI (para facilidad de brandear chill)
 * Se puede crear desde: https://uicolors.app/create
 **/
const primary = {
    50:  '#eef2ff',
    100: '#e0e7ff',
    200: '#c7d2fe',
    300: '#a5b4fc',
    400: '#818cf8',
    500: '#6366f1',
    600: '#4f46e5',
    700: '#4338ca',
    800: '#3730a3',
    900: '#312e81',
    950: '#1e1b4b',
};

/**
 * 🛡️ Safelist de colores y variantes darks
 * Para evitar que Tailwind elimine clases que se generan dinámicamente
 * (para contar con una paleta de colores amplia y variantes darks)
 **/

const colors = [
    'slate', 'gray', 'zinc', 'neutral', 'stone',
    'red', 'orange', 'amber', 'yellow',
    'lime', 'green', 'emerald', 'teal',
    'cyan', 'sky', 'blue', 'indigo',
    'violet', 'purple', 'fuchsia', 'pink', 'rose',
    'white', 'black',
];

const shades = [ 50, 100, 200, 300, 400, 500, 600, 700, 800, 900, 950 ];

const prefixes = [
    'bg', 'text', 'border',
    'ring', 'ring-offset',
    'shadow', 'divide',
    'accent', 'caret', 'fill', 'stroke',
    'from', 'via', 'to',
    'decoration', 'outline',
];

const variants = [
    'hover', 'focus',
    'active', 'disabled',
    'dark', 'group-hover'
];

const colorSafelist = [];
for(const prefix of prefixes) {
    for(const color of colors) {
        if(color === 'white' || color === 'black') {
            colorSafelist.push({ pattern: new RegExp(`^${prefix}-${color}$`), variants });
            continue;
        }
        for(const shade of shades) {
            colorSafelist.push({ pattern: new RegExp(`^${prefix}-${color}-${shade}$`), variants });
        }
    }
    for(const shade of shades) {
        colorSafelist.push({ pattern: new RegExp(`^${prefix}-primary-${shade}$`), variants });
    }
}

module.exports = {
    darkMode: 'class',

    content: [
        './**/*.php',
        './**/*.html',
        './assets/js/**/*.js',
        './src/**/*.js',
    ],

    safelist: colorSafelist,

    theme: {
        extend: {
            colors: { primary },
        },
    },

    plugins: [],
};