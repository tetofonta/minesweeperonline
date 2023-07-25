import Mascot from "./game/MineSweeperMascot";

const mascot = new Mascot("mascot")


function mascotMouseFollow(e: MouseEvent){
    mascot.setEyeRotation(e.pageX, e.pageY)
}
document.addEventListener('DOMContentLoaded', () => {
    mascot.setState('standard')
    document.body.addEventListener('mousemove', mascotMouseFollow)
})
