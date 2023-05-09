import Mascot from "./game/MineSweeperMascot";

const mascot = new Mascot("login-mascot")
let show_password = false
const aux = document.getElementById("text-length-determining")


function mascotMouseFollow(e: MouseEvent){
    mascot.setEyeRotation(e.pageX, e.pageY)
}

function mascotFollowText (e: InputEvent | MouseEvent | FocusEvent) {
        e.preventDefault()
        e.stopPropagation()
        const target = e.target as HTMLInputElement
        const textPosition = target.selectionStart
        const rect = target.getBoundingClientRect()

        aux.innerText = target.value.substring(0, textPosition)
        mascot.setEyeRotation(rect.left + Math.min(aux.offsetWidth, target.clientWidth), rect.top)
}

function passwordFieldFollow(e:  | FocusEvent){
    e.stopPropagation()
    if(!show_password){
        mascot.setState("password")
        mascot.clearEyeRotation()
        document.body.removeEventListener('mousemove', mascotFollowText)
        e.target.removeEventListener('keyup', mascotFollowText)
        return
    }

    mascot.clearEyeRotation()
    mascot.setState("password-spy")
    mascotFollowText(e)
    e.target.addEventListener('keyup', mascotFollowText)
}

function togglePasswordVisibility(e: MouseEvent) {
    e.stopPropagation()
    const target = e.target as HTMLElement
    if(show_password){
        show_password = false
        target.classList.remove('fa-eye-slash')
        target.classList.add('fa-eye');
        (document.getElementById('password-input') as HTMLInputElement).type = "password"
    } else {
        show_password = true
        target.classList.remove('fa-eye')
        target.classList.add('fa-eye-slash');
        (document.getElementById('password-input') as HTMLInputElement).type = "text"
    }
    document.getElementById('password-input').focus()
}


document.addEventListener('DOMContentLoaded', () => {
    mascot.setState('standard')

    document.getElementById('username-input').addEventListener('keyup', mascotFollowText)
    document.getElementById('username-input').addEventListener('click', (e) => {
        mascot.setState("standard")
        mascotFollowText(e)
    })
    document.body.addEventListener('mousemove', mascotMouseFollow)
    document.body.addEventListener('click', () => {
        mascot.setState("standard")
        document.body.addEventListener('mousemove', mascotMouseFollow)
    })
    document.getElementById('username-input').addEventListener('focus', (e) => {
        document.body.removeEventListener('mousemove', mascotMouseFollow)
    })

    document.getElementById('show-password-button').addEventListener('click', togglePasswordVisibility)
    document.getElementById('password-input').addEventListener('click', passwordFieldFollow)
    document.getElementById('password-input').addEventListener('focus', (e) => {
        document.body.removeEventListener('mousemove', mascotMouseFollow)
        passwordFieldFollow(e)
    })

})
