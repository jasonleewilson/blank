export default {
  content: [
    "./src/**/*.{js,jsx,php}", // your JS/PHP sources
    "./templates/**/*.html",
    "./parts/**/*.html",
    "./*.php", // all PHP files in theme root
    "./**/*.php", // all PHP files in any subfolder
  ],
  theme: {
    extend: {},
  },
};
