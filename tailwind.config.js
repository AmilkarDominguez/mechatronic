const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        screens: {
            'sm': '640px',
            // => @media (min-width: 640px) { ... }

            'md': '768px',
            // => @media (min-width: 768px) { ... }

            'lg': '1024px',
            // => @media (min-width: 1024px) { ... }

            'xl': '1280px',
            // => @media (min-width: 1280px) { ... }

            '2xl': '1536px',
            // => @media (min-width: 1536px) { ... }
        },
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    '50': '#FEA1B1',
                    '100': '#FD8DA1',
                    '200': '#FD6480',
                    '300': '#FC3C5E',
                    '400': '#FC143D',
                    '500': '#E4032B',
                    '600': '#AD0221',
                    '700': '#750216',
                    '800': '#3E010C',
                    '900': '#070001',
                    '950': '#000000'
                },

                secondary: {
                    '50': '#F8EBE4',
                    '100': '#F2D7CC',
                    '200': '#E5AC9C',
                    '300': '#D87B6C',
                    '400': '#CB463B',
                    '500': '#9F2A2A',
                    '600': '#83232A',
                    '700': '#661B26',
                    '800': '#4A1420',
                    '900': '#2E0C16'
                },
            }
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
