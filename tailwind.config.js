module.exports = {
  content:[
    './*.{php,html,js}',
    './index.html',
    './Component/Sidebar/*.{php,html,css,js}',
    './Application/*.{php,html,js}',
    './Config/*.{php,html,js}',
    './CSS/*.{php,html,css,js}',
    './Pages/Application/*.{php,html,css,js}',
    "./node_modules/flowbite/**/*.js"],
  theme: {
    extend: {
      fontSize:{
        '2xs': '0.5rem',
      },
      spacing:{
        '88':'22rem',
        '105':'27.25rem',
        '73':'19.25rem',
      },
      colors : {
        "darkColor" : "#1a2e39", 
        "greenColor" : "#487f63",
        "yellowColor" : "#F0B86C", 
        "whiteColor" : "#FDF9F0", 
      }
    },
  },
  plugins: [require('flowbite/plugin')],
}
