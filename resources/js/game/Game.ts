class Game{

    constructor(
        private readonly width: number,
        private readonly height: number,
        private readonly bombs: number
    ) {
    }

    public async init(id: string): Promise<void>{
        const status = await fetch('/api/game/state');
        console.log(status)
    }

}

// @ts-ignore
window.Game = Game;
export default Game;
