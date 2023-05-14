document.addEventListener('DOMContentLoaded', () => {
    let show_password = [false, false]
    document.getElementById("toggle-show-password").addEventListener('click', () => {
        // @ts-ignore
        document.getElementById("password-input").type = show_password[0] ? "password" : "text"
        show_password[0] = !show_password[0]
    })
    document.getElementById("toggle-show-password-repeat").addEventListener('click', () => {
        // @ts-ignore
        document.getElementById("password-repeat-input").type = show_password[1] ? "password" : "text"
        show_password[1] = !show_password[1]
    })
})
