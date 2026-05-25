// tailwind.config.mjs (or tailwind.config.js if you remove `type: "module"`)
export default {
  content: [
   './resources/views/**/*.blade.php',   // Laravel Blade templates
    './resources/js/**/*.{js,jsx,ts,tsx}', //
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Inter', 'ui-sans-serif', 'system-ui', 'sans-serif'],
        serif: ['Merriweather', 'Georgia', 'serif'],
      },
      colors: {
        primary: {
          50: '#eef3fb',
          100: '#d9e4f5',
          200: '#b8cbeb',
          300: '#92ade0',
          400: '#6986d3',
          500: '#4f66c7',
          600: '#3e4db6',
          700: '#1E3A8A',
          800: '#192d6a',
          900: '#172858',
        },
        secondary: {
          50: '#fcf5f7',
          100: '#f9ebee',
          200: '#f3d5de',
          300: '#e8b1c2',
          400: '#d8819f',
          500: '#c55c81',
          600: '#b64066',
          700: '#9F1239',
          800: '#7e1635',
          900: '#66162d',
        },
      },
    },
  },
  plugins: [],
};
