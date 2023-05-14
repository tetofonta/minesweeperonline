
//@ts-ignore
window.jQuery = window.$ = $
console.log($)

import "bootstrap"
import 'bootstrap4-toggle'
import {DARK_MODE_KEY, setTheme} from "../theme";

const theme_cycle = {
    "light": "dark",
    "dark": "auto",
    "auto": "light"
}

document.addEventListener('DOMContentLoaded', () => {


    let last_value: string = localStorage.getItem(DARK_MODE_KEY);

    if(last_value !== "dark" && last_value !== "light" && last_value !== 'auto') last_value = "auto"
    setTheme(last_value as any)

    document.getElementById('theme-toggler')?.addEventListener('click', () => {
        setTheme(theme_cycle[localStorage.getItem(DARK_MODE_KEY)])
    })
})

