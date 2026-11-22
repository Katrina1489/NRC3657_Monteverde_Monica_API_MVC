/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{html,js}"],
  theme: {
    extend: {
      colors: {
        royal: {
          50: "#f3eefa",
          100: "#e4d9f3",
          500: "#7b61a8",
          700: "#5a4480",
          900: "#2f2245",
        },
      },
      fontFamily: {
        titulo: ["Teko", "sans-serif"],
        cuerpo: ["Poppins", "sans-serif"],
      },
    },
  },
  plugins: [],
};