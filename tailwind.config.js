/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.{js,ts,vue}",
    "./templates/**/*.html.twig"    
  ],
  theme: {
    extend: {},
  },
  plugins: [require("daisyui")],
  daisyui:{
    themes: ["fantasy"]
  }
}

