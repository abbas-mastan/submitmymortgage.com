module.exports = {
  purge: {
    enabled: true,
    content: [
      "./resources/**/*.blade.php",
      "./resources/**/*.js",
      "./resources/**/*.vue",
    ],
  },
  theme: {
    extend: {
      colors: {
        themebackground: '#F5F5F5',
        themered: '#E25F41',
        themegreen:'#00ff00',
        gradientStart: '#A90D0E',
        gradientEnd: '#CB7C1D',
      }
    },
  },
  plugins: [require('@tailwindcss/forms')],
}
