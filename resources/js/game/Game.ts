import Mascot from "./MineSweeperMascot";

class Game{

    private readonly mascot: Mascot
    private time = 0;
    private timer: number | null = null;
    private eyeListener = (e) => this.mascot.setEyeRotation(e.pageX, e.pageY)

    constructor(
        private readonly width: number,
        private readonly height: number,
        private bombs: number,
        private readonly mascot_id: string,
        private readonly play_area_id: string,
        private readonly timer_id: string,
        private readonly bomb_id: string,
        private readonly field_id: string,
        private enabled: boolean,
    ) {
        this.mascot = new Mascot(mascot_id);
        this.mascot.setState('standard')
    }

    public async init(id: string): Promise<void>{
        document.getElementById(this.play_area_id).addEventListener('mousemove', this.eyeListener)

        this.set_bombs(this.bombs)
        if(!this.enabled){
            this.set_timer(new Date().toString())
            this.reset_field(Array(10).fill('-'.repeat(10)).join("/"));
            return;
        }

        const res = await fetch('/api/game/state');
        if(res.status != 200){
            this.mascot.setState('dead');
        }
        const data = await res.json();
        this.reset_field(data.state)
        this.set_timer(data.created_at)
        this.start_timer();
    }

    private cell_mouse_down(e : MouseEvent, x, y){
        const target = e.target as HTMLElement
        if(target.classList.contains("cell-hidden") && target.classList.contains('cell-flag')) return;
        if(e.button == 2) return
        this.mascot.setState("suspense")
    }

    private cell_mouse_up(e : MouseEvent, x, y){
        const target = e.target as HTMLElement
        if(target.classList.contains("cell-hidden") && target.classList.contains('cell-flag')) return;
        if(e.button == 2) return
        this.mascot.setState("standard")
        this.update(x, y);
    }

    private toggle_flag(e : MouseEvent, x, y){
        e.stopPropagation();
        e.preventDefault();
        const target = e.target as HTMLElement
        if(!target.classList.contains("cell-hidden")) return;
        if(!target.classList.contains('cell-flag')){
            target.classList.add('cell-flag')
            this.bombs -= 1;
        } else {
            target.classList.remove('cell-flag')
            this.bombs += 1;
        }
        this.set_bombs(this.bombs)
    }

    public async reset_field(state){
        const orig = document.getElementById(this.field_id)
        orig.innerHTML = ""

        for(let j = 0; j < this.height; j++){
            const r = document.createElement('div')
            r.className = "d-flex flex-row flex-nowrap justify-content-center"
            orig.appendChild(r)
            for(let i = 0; i < this.width; i++){
                const c = document.createElement('div')
                c.className = "cell cell-hidden position-relative"
                c.style.width = c.style.height = c.style.paddingTop = `calc(min(80px, ${100/Math.max(this.height, this.width)}%`;
                r.appendChild(c)
                c.style.fontSize = (c.clientWidth)*0.85 + "px"

                if(this.enabled) {
                    c.onmousedown = (e) => this.cell_mouse_down(e, i, j);
                    c.onmouseup = (e) => this.cell_mouse_up(e, i, j);
                    c.oncontextmenu = (e) => this.toggle_flag(e, i, j)
                } else {
                    c.style.cursor = "not-allowed"
                }
            }
        }
        await this.update_field(state)
    }

    public async update_field(state){
        const orig = document.getElementById(this.field_id)

        state.split('/', this.height).forEach((r_val, row) => {
            Array.from(r_val).forEach((c_val: string, col) => {
                const cell = orig.children[row].children[col]
                const hadFlag = cell.classList.contains('cell-flag')
                cell.className = "cell position-relative"
                switch (c_val){
                    case '-':
                        cell.classList.add('cell-hidden')
                        if(hadFlag) cell.classList.add('cell-flag')
                        break;
                    case 'B':
                        cell.classList.add('cell-bomb')
                        break
                    default:
                        cell.classList.add('cell-uncovered')
                        cell.classList.add('cell-uncovered-' + c_val)
                        cell.setAttribute('data-value', c_val)
                }
            })
        })
    }

    private async update(x, y){
        const res = await fetch(`/api/game/update/${x}/${y}`);
        const data = await res.json();
        if(data.finished){
            this.stop_timer();
            this.mascot.setState(data.status == "lost" ? "dead" : "happy");
            this.enabled = false
            await this.reset_field(data.state)

            if(data.status == 'lost'){
                document.getElementById(this.play_area_id).removeEventListener('mousemove', this.eyeListener)
                this.mascot.clearEyeRotation()
            }
            return;
        }

        this.mascot.setState("standard");
        await this.update_field(data.state);
    }

    public set_timer(time: string){
        this.time = Math.round((Date.now() - new Date(time).getTime())/1000)
    }

    public start_timer(){
        const f = () => {
            document.getElementById(this.timer_id).innerHTML = this.format_time();
            this.time += 1
        }
        this.timer = setInterval(f, 1000)
        f()
    }

    public stop_timer(){
        clearInterval(this.timer)
    }

    private format_time(): string{
        let mins: number | string = Math.floor(this.time/60)
        if(mins > 240) {
            this.stop_timer()
            return "A LOT"
        }
        let sec: number | string = this.time % 60
        if (mins < 10) mins = "0" + mins
        if (sec < 10) sec = "0" + sec
        return mins + ":" + sec
    }

    private set_bombs(intval: number){
        this.bombs = intval;
        if(this.bombs < 0) document.getElementById(this.bomb_id).innerHTML = "00"
        document.getElementById(this.bomb_id).innerHTML = ("0" + intval).slice(intval > 99 ? 1 : -2)
    }
}

// @ts-ignore
window.Game = Game;
export default Game;
