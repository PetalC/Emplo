/** @type {import('tailwindcss').Config} */

// const colors = require("tailwindcss/colors");

export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./vendor/usernotnull/tall-toasts/config/**/*.php",
    "./vendor/usernotnull/tall-toasts/resources/views/**/*.blade.php",
    "./app/Livewire/**/*.php",
  ],
  theme: {
    extend: {
      fontFamily: {
        'app': ['aileron']
      },
      maxWidth: {
        '8xl': '1600px'
      },
      colors: {
        primary: '#4d8c27',
        secondary: '#4a4a4a',
        third: '#e07055',
        danger: '#e07055',
        success: '#4d8c27',
        tertiary: '#617674',
        orange: '#df6c50',
        theme_blue: '#1569DB',
        school_primary: 'var(--school-primary-color, #e07055)',
        school_primary_alt: 'var(--school-primary-color-alt, #FFFFFF00)',
        school_secondary: 'var(--school-secondary-color, #e07055)',
        school_tertiary: 'var(--school-tertiary-color, #e07055)',
      },
      borderColor: {
        app: '#cecece'
      },
      divideColor: {
        app: '#cecece'
      },
      textColor: {
        app: '#4a4a4a'
      },
      dropShadow: {
        'app': '0 0 20px rgba(0, 0, 0, 0.15)',
        'dropdown': '0 0 10px rgba(0, 0, 0, 0.15)',
        'primary': [
          '0 10px 10px rgba(77, 140, 39, 0.25)',
          '0 10px 10px rgba(77, 140, 39, 0.25)'
        ],
        'orange': [
          '0 10px 10px rgba(223, 108, 80, 0.25)',
          '0 10px 10px rgba(223, 108, 80, 0.25)'
        ]
      },
        gridTemplateColumns: {
            '14': 'repeat(14, minmax(0, 1fr))',
        }
    },
  },
  plugins: [
  ],
}

