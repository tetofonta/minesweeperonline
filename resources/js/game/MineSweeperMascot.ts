// export function startMoveEyes(eyeClass: string){
//
//     document.body.onmousemove = (evt) => {
//         // @ts-ignore
//         const elements: HTMLElement[] = Array.from(document.getElementsByClassName(eyeClass))
//         elements.map(async (e) => {
//             let rect = e.getBoundingClientRect();
//             let x = rect.left + e.clientWidth/2
//             let y = rect.top + e.clientHeight/2
//             let rad = Math.atan2(evt.pageX - x, evt.pageY - y);
//             let rot = (rad * (180 / Math.PI) * -1) + 180;
//
//             Object.assign(e.style, {
//                 '-webkit-transform': 'rotate(' + rot + 'deg)',
//                 '-moz-transform': 'rotate(' + rot + 'deg)',
//                 '-ms-transform': 'rotate(' + rot + 'deg)',
//                 'transform': 'rotate(' + rot + 'deg)'
//             });
//         })
//     }
// }

export default class Mascot{

    private curState: string|null = null
    private eyes: HTMLElement[] = []
    constructor(
        private readonly mascotId: string
    ) {
        this.eyes = Array.from(document.getElementById(mascotId)
            .children[0] //mascot-background
            .children[0].children
        ) as HTMLElement[] //mascot-container-eye
    }

    public setState(cls: "standard"|"suspense"|"happy"|"dead"|"password"|"password-spy"){
        if(this.curState)
            document.getElementById(this.mascotId).classList.remove(`mascot-state-${this.curState}`)
        document.getElementById(this.mascotId).classList.add(`mascot-state-${cls}`)
        this.curState = cls
    }

    private static getRotation(e: HTMLElement, cx: number, cy: number): number{
        let rect = e.getBoundingClientRect();
        let x = rect.left + e.clientWidth/2
        let y = rect.top + e.clientHeight/2
        let rad = Math.atan2(cx - x, cy - y);
        return (rad * (180 / Math.PI) * -1) + 180;
    }

    public setEyeRotation(x: number, y: number){
        return this.eyes.map(async (e, i) => {
            const rot = Mascot.getRotation(e, x, y)

            if(this.curState === 'password-spy' && i != 0) return
            Object.assign(e.style, {
                '-webkit-transform': 'rotate(' + rot + 'deg)',
                '-moz-transform': 'rotate(' + rot + 'deg)',
                '-ms-transform': 'rotate(' + rot + 'deg)',
                'transform': 'rotate(' + rot + 'deg)'
            });
        })
    }

    public clearEyeRotation(){
        this.eyes.forEach(e => Object.assign(e.style, {
            '-webkit-transform': 'rotate(' + 0 + 'deg)',
            '-moz-transform': 'rotate(' + 0 + 'deg)',
            '-ms-transform': 'rotate(' + 0 + 'deg)',
            'transform': 'rotate(' + 0 + 'deg)'
        }))
    }

}

// @ts-ignore
window.Mascot = Mascot;
