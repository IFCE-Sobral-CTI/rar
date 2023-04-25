const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
        './src/**/*.{html,js}',
        './node_modules/tw-elements/dist/js/**/*.js'
    ],

    theme: {
        extend: {
            colors: {
                green: {
                    light: '#54b74f',
                    DEFAULT: '#3da33c',
                    dark: '#167911',
                },
            },
            screens: {
                'print': {'raw': 'print'},
            },
            fontFamily: {
                sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [require('@tailwindcss/forms'), require('tw-elements/dist/plugin.cjs')],
    darkMode: 'class'
};
