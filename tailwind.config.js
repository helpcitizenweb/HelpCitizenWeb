import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['Segoe UI', 'Tahoma', 'Geneva', 'Verdana', 'sans-serif'],
        poppins: ['Poppins', 'sans-serif']
      },
      colors: {
        // You can add or extend colors if needed
      },
      // Any other theme extensions you may need
    },
  },
  plugins: [
    forms,  // Make sure you have the forms plugin if you're working with forms
  ],
};
