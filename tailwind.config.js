const colors = require('tailwindcss/colors')

module.exports = {
    content: ['./resources/**/*.blade.php', './vendor/filament/**/*.blade.php'],
    theme: {
        container: {
            padding: '1rem',
        },
        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.purple,
                success: colors.green,
                warning: colors.yellow,
                manjam_primary: '#684e9a',
            },
            animation: {
                marquee: 'marquee 25s linear infinite',
            },
            keyframes: {
                marquee: {
                    '0%': {transform: 'translateY(0%)'},
                    '100%': {transform: 'translateY(-50%)'},
                },
            },
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
}
