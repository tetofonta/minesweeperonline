import Mascot from "./MineSweeperMascot";

class Game{

    private readonly mascot: Mascot
    private time = 0;
    private timer: number | null = null;

    constructor(
        private readonly width: number,
        private readonly height: number,
        private bombs: number,
        private readonly mascot_id: string,
        private readonly play_area_id: string,
        private readonly timer_id: string,
        private readonly bomb_id: string,
        private readonly field_id: string,
    ) {
        this.mascot = new Mascot(mascot_id);
        this.mascot.setState('standard')
    }

    public async init(id: string): Promise<void>{
        document.getElementById(this.play_area_id).addEventListener('mousemove', (e) => this.mascot.setEyeRotation(e.pageX, e.pageY))
        const res = await fetch('/api/game/state');
        if(res.status != 200){
            this.mascot.setState('dead');
            alert("Connection error.")
        }
        const data = await res.json();
        this.set_timer(data.created_at)
        this.start_timer();
        this.reset_field(data.state)
        this.set_bombs(this.bombs)
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
                c.onmousedown = (e) => this.cell_mouse_down(e, i, j);
                c.onmouseup = (e) => this.cell_mouse_up(e, i, j);
                c.oncontextmenu = (e) => this.toggle_flag(e, i, j)
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
        await this.update_field(data.state);
        if(data?.value == "B"){
            this.mascot.setState("dead");
            //todo endgame
        }
        this.mascot.setState("standard");
    }

    public set_timer(time: string){
        this.time = Math.round((Date.now() - new Date(time).getTime())/1000)
    }

    public start_timer(){
        this.timer = setInterval(() => {
            document.getElementById(this.timer_id).innerHTML = this.format_time();
            this.time += 1
        }, 1000)
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
        document.getElementById(this.bomb_id).innerHTML = ("0" + intval).slice(-2)
    }
}

// @ts-ignore
window.Game = Game;
export default Game;
