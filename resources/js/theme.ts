export const DARK_MODE_KEY = 'darkMode'

export function setTheme(theme: "light"|"dark"|"auto"){
    localStorage.setItem(DARK_MODE_KEY, theme)
    document.documentElement.setAttribute('data-bs-theme', theme);

    Array.from(document.getElementsByClassName('theme-icon')).map(async (e: HTMLElement) => {
        if(e.id !== `theme-icon-${theme}`) e.style.display = "none"
        else e.style.display = 'block'
    })
}
