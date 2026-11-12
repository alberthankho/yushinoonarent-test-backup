import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree','Poppins', ...defaultTheme.fontFamily.sans],
            },
            colors: { // <-- Add your custom colors here
                'brand-pink-bg': '#f7c0c7',
                'brand-pink-text': '#ef7c8b',
                'brand-teal': '#87d6c3',
                'brand-teal-light': '#d7f5ee', // Phone Screen Light Green/Teal
                'brand-dark': '#3c3430',
                'brand-skin': '#f9d9c7',
                'brand-yellow': '#f8e574',
                // 'brand-white': '#ffffff', // White is already available as `white`
            }
        },
    },
    plugins: [],
};
