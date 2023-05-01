<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>MineSweeperOnline</title>

        <!-- Scripts -->
        @vite('resources/js/game/main.ts')

        <!-- Fonts -->

        <!-- Styles -->
        @vite('resources/css/app.sass')
        @vite('resources/css/game/game.sass')
    </head>
    <body class="antialiased">

        <div id="minesweeper" class="minesweeperGame">
            <div class="header">
                <span>00:00</span>
                <div class="mascot-container">
                    <div class="mascot">
                        <div class="eye-container">
                            <div class="eye"></div>
                            <div class="eye"></div>
                        </div>
                        <div class="mouth-container">
                            <div class="mouth"></div>
                        </div>
                    </div>
                </div>
                <span>000</span>
            </div>
            <div id="game">

            </div>
        </div>

    </body>


    <script>
        document.body.onmousedown = evt => {
            document.getElementsByClassName('mouth')[0].classList.add('mouth-suspance')
        }

        document.body.onmouseup = evt => {
            document.getElementsByClassName('mouth')[0].classList.remove('mouth-suspance')
        }
    </script>
</html>
