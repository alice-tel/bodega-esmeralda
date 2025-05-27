import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                // for light, semibold etc refer with font-poppins font-semibold
                poppins: ['Poppins', 'sans-serif'],
                // Rare details
                lora: ['Lora', 'serif'],
            },
            fontSize: {
                base: '10px',
                lg: '14px',
            },
            colors: {
                primary: {
                    100: '#eeebe3',
                },
                secondary: {
                    100: '#2b394E',
                },
                font: {
                    100: '#333333',
                },
                details: {
                    100: '#CF1F25',
                }
            },
        },
    },

    plugins: [forms],
};
