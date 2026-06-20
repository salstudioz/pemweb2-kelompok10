import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';
import aspectRatio from '@tailwindcss/aspect-ratio';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./app/Livewire/**/*.php"
    ],
    theme: {
        extend: {
            colors: {
                // === Brand Colors ===
                'primary': {
                    DEFAULT: '#2D3B6D',
                    dark: '#1F2A4F',
                    50: '#E9EBF2',
                    100: '#D3D6E5',
                    200: '#A7ADCB',
                    300: '#7B84B1',
                    400: '#4F5B97',
                    500: '#2D3B6D',
                    600: '#242F57',
                    700: '#1B2341',
                    800: '#12172B',
                    900: '#090C16',
                },
                'secondary': {
                    DEFAULT: '#517BA8',
                    dark: '#3E6190',
                    50: '#EAF0F5',
                    100: '#D5E0EB',
                    200: '#AAC1D7',
                    300: '#7FA2C3',
                    400: '#5483AF',
                    500: '#517BA8',
                    600: '#41638A',
                    700: '#314B6B',
                    800: '#21344D',
                    900: '#192637',
                },
                'accent': {
                    DEFAULT: '#8ABDCE',
                    dark: '#6FA8BC',
                    50: '#F2F7F9',
                    100: '#E5EEF2',
                    200: '#C9DDE6',
                    300: '#ADCCDA',
                    400: '#91BBCE',
                    500: '#8ABDCE',
                    600: '#6FA8BC',
                    700: '#517A8A',
                    800: '#34515E',
                    900: '#293E46',
                },
                'highlight': {
                    DEFAULT: '#639487',
                    dark: '#4C756A',
                    50: '#EFF4F2',
                    100: '#DEE8E4',
                    200: '#BCD1CA',
                    300: '#9BBAB1',
                    400: '#79A398',
                    500: '#639487',
                    600: '#4C756A',
                    700: '#3C5C52',
                    800: '#2D443C',
                    900: '#1F302A',
                },

                // === Background & Surface ===
                'background': {
                    DEFAULT: '#EFEDEA',
                    light: '#F5F4F1',
                },
                'surface': {
                    DEFAULT: '#FFFFFF',
                },

                // === Neutral & Text ===
                'text-primary': {
                    DEFAULT: '#1A2332',
                },
                'text-secondary': {
                    DEFAULT: '#5A6579',
                },
                'text-muted': {
                    DEFAULT: '#9CA3B0',
                },
                'border-color': {
                    DEFAULT: '#E2DFDA',
                },

                // === Semantic Feedback ===
                'success': {
                    DEFAULT: '#4B8B6F',
                    light: '#EAF4EF',
                },
                'error': {
                    DEFAULT: '#C0604A',
                    light: '#F9EFEC',
                },
                'warning': {
                    DEFAULT: '#C5A059',
                    light: '#F9F4EA',
                },
                'info': {
                    DEFAULT: '#6C8EBF',
                    light: '#F0F3F9',
                },

                // === Admin Panel ===
                'admin': {
                    sidebar: '#1A243F',
                    header: '#2D3B6D',
                    hover: '#639487',
                    border: '#E8E5E0',
                },
            },
            fontFamily: {
                serif: ['Playfair Display', 'Merriweather', 'serif'],
                sans: ['Inter', 'Roboto', 'sans-serif'],
            },
            borderRadius: {
                'xs': '2px',
                'sm': '4px',
                'md': '6px',
                'lg': '8px',
                'xl': '12px',
                '2xl': '16px',
            },
            boxShadow: {
                'card': '0 4px 6px -1px rgba(26, 35, 50, 0.05), 0 2px 4px -1px rgba(26, 35, 50, 0.03)',
                'card-hover': '0 10px 15px -3px rgba(26, 35, 50, 0.08), 0 4px 6px -2px rgba(26, 35, 50, 0.03)',
                'dropdown': '0 10px 15px -3px rgba(26, 35, 50, 0.10), 0 4px 6px -2px rgba(26, 35, 50, 0.05)',
                'modal': '0 20px 25px -5px rgba(26, 35, 50, 0.15), 0 10px 10px -5px rgba(26, 35, 50, 0.04)',
            },
            spacing: {
                'xs': '8px',
                'sm': '16px',
                'md': '24px',
                'lg': '32px',
                'xl': '48px',
                '2xl': '64px',
            }
        }
    },
    plugins: [
        forms,
        typography,
        aspectRatio,
    ],
}