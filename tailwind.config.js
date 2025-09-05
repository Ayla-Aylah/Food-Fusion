/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./app/views/**/*.php", // Scan all view files
    "./admin/views/**/*.php", // Scan all view files
    "./public/**/*.js", // Include JS files (e.g., modal.js)
    "./src/**/*.css", // Include your input.css
  ],
  theme: {
    extend: {},
    screens: {},
  },
  plugins: [
    require("@tailwindcss/forms"),
    require("@tailwindcss/typography"),
    require("@tailwindcss/aspect-ratio"),
  ],
};
