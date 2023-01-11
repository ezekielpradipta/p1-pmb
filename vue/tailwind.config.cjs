/** @type {import('tailwindcss').Config} */
module.exports = {
    darkMode: "class",
    content: [
        "./index.html",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {},
        colors: {
            "dark-new": "#292929",
            "dark-body-new": "#202020",
        },
    },
    plugins: [require("@tailwindcss/forms"), require("flowbite/plugin")],
};
