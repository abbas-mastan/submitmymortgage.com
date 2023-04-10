module.exports = {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors:{
        themebackground:'#F5F5F5',
        themered:'#E25F41',
        gradientStart: '#A90D0E',
        gradientEnd: '#CB7C1D',
      }
    },
  },
  plugins: [require('@tailwindcss/forms')],
}
