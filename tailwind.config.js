import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                steamDark: "#171a21",
                steamBlue: "#66c0f4",
                steamNavy: "#1b2838",
                steamSlate: "#2a475e",
                steamLight: "#c7d5e0",
            },
            fontFamily: {
                alegrayaSc: ['"Alegreya Sans SC"', ...defaultTheme.fontFamily.sans],
                alegraya: ['"Alegreya Sans"', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
