/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./src/**/*.{js,jsx,ts,tsx}"],
  theme: {
    extend: {
      screens: {
        xs: "575px", //575px
        "3xl": " 1792px", // 1792px
        "4xl": "2048px", // 2048px
        "5xl": "2304px", // 2304px
        "6xl": "2560px", // 2560px
        "7xl": "2816px", // 2816px
        "8xl": "3072px", // 3072px
      },
      fontFamily: {
        inter: ["Inter", "sans-serif"],
        "plus-Jakarta-sans": ["Plus Jakarta Sans", "sans-serif"],
      },
      colors: {
        primary: "#de5fd5",
        secondary: "#041137",
        "light-gray": "#F3F3F3",
        "ex-light-gray": "#BABABA",
        gray: "#F9F9FB",
        "ice-blue-light": "#eceff4",
      },
      borderRadius: {
        10: "0.625rem",
      },
    },
  },
  plugins: [],
  corePlugins: {
    preflight: false,
  },
};
