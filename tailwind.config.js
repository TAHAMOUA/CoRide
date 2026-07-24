import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            colors: {
                // "night" carries every dark background/surface/border step, deepest to lightest.
                night: {
                    950: '#0A0F0D',
                    900: '#121815',
                    800: '#1C2521',
                    700: '#2A3833',
                    600: '#3D4E47',
                },
                ink: {
                    50: '#F1F3F5',
                    100: '#E3E7EB',
                    400: '#93A39B',
                    600: '#333F4E',
                    800: '#1B2430',
                    900: '#141B24',
                },
                route: {
                    50: '#EAF5EF',
                    100: '#D2EADC',
                    300: '#7BE3B4',
                    400: '#43CB93',
                    500: '#1F8A5F',
                    600: '#186E4C',
                    700: '#125537',
                    900: '#0E2B21',
                    950: '#081D16',
                },
                amber: {
                    50: '#FBF1E1',
                    100: '#F4DDB2',
                    300: '#F3CE8A',
                    400: '#EDBB5E',
                    500: '#D9932B',
                    600: '#B87A20',
                    900: '#3A2A12',
                },
                rust: {
                    50: '#F8E9E5',
                    100: '#EFC9BE',
                    300: '#F0A08F',
                    400: '#E67A61',
                    500: '#C4432E',
                    600: '#A33322',
                    900: '#3A150F',
                },
                paper: '#EFF3EF',
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
                display: ['"Space Grotesk"', ...defaultTheme.fontFamily.sans],
                mono: ['"IBM Plex Mono"', ...defaultTheme.fontFamily.mono],
            },
        },
    },

    plugins: [forms],
};