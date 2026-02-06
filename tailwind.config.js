/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/views/app.blade.php',
        './resources/js/**/*.vue',
        './resources/js/**/*.js',
    ],
    darkMode: 'class',
    theme: {
        extend: {
            colors: {
                // Warmer, more unique color scheme
                primary: {
                    50: '#fef3e2',
                    100: '#fde4b8',
                    200: '#fbcb7d',
                    300: '#f9a842',
                    400: '#f78c1f',
                    500: '#e6730a',
                    600: '#c85a05',
                    700: '#a04408',
                    800: '#80360e',
                    900: '#682e0f',
                },
            },
            fontFamily: {
                sans: ['Inter', 'system-ui', '-apple-system', 'sans-serif'],
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
};
