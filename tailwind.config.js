const defaultTheme = require('tailwindcss/defaultTheme');
const colors = require('tailwindcss/colors')
module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        ringColor: '#F48FB1',
        fontSize: {

            'xs': '.675rem',
     
            'sm': '.875rem',
     
            'tiny': '.875rem',
             'base': '1rem',
             'lg': '1.125rem',
             'xl': '1.25rem',
             '2xl': '1.5rem',
     
            '3xl': '1.875rem',
     
            '4xl': '2.25rem',
             '5xl': '3rem',
             '6xl': '4rem',
     
            '7xl': '5rem',
           },
        extend: {
            // fontFamily: {
            //     sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            // },
            ringColor: {
                white: colors.white,
                pink: colors.fuchsia,
              }
              
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
