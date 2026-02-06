import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],

  corePlugins: {
    preflight: true,
  },

  theme: {
    extend: {
      fontFamily: {
        sans: ['Segoe UI', 'Tahoma', 'Geneva', 'Verdana', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif'],
      },
    },
  },

  plugins: [
    forms,
  ],
};

