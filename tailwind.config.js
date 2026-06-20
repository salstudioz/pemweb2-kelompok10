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
                'sigmaven': {
                    cream: '#FBFBF9',
                    white: '#FFFFFF',
                    forest: '#1C3F35',
                    'forest-dark': '#142E26',
                    gold: '#C69C6D',
                    'gold-dark': '#B08A5A',
                    charcoal: '#2A2A2A',
                    gray: '#686868',
                    border: '#E5E5E5',
                    'admin-blue': '#1E3A5F',
                },
                green: {
                    50: '#F0FDF4',
                    500: '#10B981',
                },
                red: {
                    50: '#FEF2F2',
                    500: '#EF4444',
                },
                yellow: {
                    50: '#FFFBEB',
                    500: '#F59E0B',
                },
                blue: {
                    50: '#EFF6FF',
                    500: '#3B82F6',
                }
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
            },
            boxShadow: {
                'card': '0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03)',
                'card-hover': '0 10px 15px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.03)',
                'dropdown': '0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)',
                'modal': '0 20px 25px -5px rgba(0, 0, 0, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04)',
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