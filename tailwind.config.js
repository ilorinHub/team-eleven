const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './node_modules/flowbite/**/*.js'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Commissioner', ...defaultTheme.fontFamily.sans],
                title: ['Montserrat', ...defaultTheme.fontFamily.sans],
            },
            animation: {
              'bounce-y': 'bounce-y 1s infinite'
            },
            keyframes: {
              'bounce-y': {
                '0%, 100%': {
                   transform: 'translateY(-18%)',
                   'animation-timing-function': 'cubic-bezier(0.8, 0, 1, 1)',
                },
                '50%': {
                  transform: 'translateY(18%)',
                  'animation-timing-function': 'cubic-bezier(0, 0, 0.2, 1)',
                }
              }
            },
        },
    },

    plugins: [
        require('@tailwindcss/typography'),
        require('@tailwindcss/line-clamp'),
        require('@tailwindcss/forms'),
        require('flowbite/plugin')
    ],
};
