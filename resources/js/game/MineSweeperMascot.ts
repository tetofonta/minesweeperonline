export function startMoveEyes(eyeClass: string){

    document.body.onmousemove = (evt) => {
        // @ts-ignore
        const elements: HTMLElement[] = Array.from(document.getElementsByClassName(eyeClass))
        elements.map(async (e) => {
            let rect = e.getBoundingClientRect();
            let x = rect.left + e.clientWidth
            let y = rect.top + e.clientHeight
            let rad = Math.atan2(evt.pageX - x, evt.pageY - y);
            let rot = (rad * (180 / Math.PI) * -1) + 180;

            Object.assign(e.style, {
                '-webkit-transform': 'rotate(' + rot + 'deg)',
                '-moz-transform': 'rotate(' + rot + 'deg)',
                '-ms-transform': 'rotate(' + rot + 'deg)',
                'transform': 'rotate(' + rot + 'deg)'
            });
        })
    }


}
