<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Game;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use function PHPUnit\Framework\isNull;

class GameController extends Controller
{

    private function createGameSeed($width, $height, $numberOfBombs)
    {
        if ($numberOfBombs > $width * $height) throw new BadRequestException();

//        $seed = random_int(0, getrandmax()/2);
        $seed = 0;

        $field = [];
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                srand($seed + $x * $width + $y);
                $field[$x * $width + $y] = rand();
            }
        }

        rsort($field);
        $limit = $field[$numberOfBombs];
        return ["seed" => $seed, "limit" => $limit];
    }

    private function isBombAt($x, $y, $width, $height, $seed, $limit)
    {
        if ($x < 0) return false;
        if ($y < 0) return false;
        if ($x >= $width) return false;
        if ($y >= $height) return false;

        srand($seed + $x * $width + $y);
        return rand() >= $limit;
    }

    private function getCountAround($x, $y, $width, $height, $seed, $limit)
    {
        $count = 0;
        for ($i = -1; $i < 2; $i++)
            for ($j = -1; $j < 2; $j++)
                $count += $this->isBombAt($x + $i, $y + $j, $width, $height, $seed, $limit) ? 1 : 0;

        return $count;
    }

    private function getContentAt($x, $y, $width, $height, $seed, $limit)
    {
        if ($this->isBombAt($x, $y, $width, $height, $seed, $limit)) return 'B';
        return $this->getCountAround($x, $y, $width, $height, $seed, $limit);
    }

    private function updateState($prev_state, $x, $y, $width, $height, $seed, $limit)
    {
        if ($x < 0 || $y < 0 || $x >= $width || $y >= $height) return ["updated" => 0, "state" => $prev_state];

        if ($prev_state == '') return implode("/", array_fill(0, $height, str_repeat('-', $width)));

        $rows = explode("/", $prev_state, $height);
        $value = $this->getContentAt($x, $y, $width, $height, $seed, $limit);
        $rows[$y][$x] = $value;

        $ret = ["updated" => 1, "value" => $value, "state" => implode("/", $rows)];

        if ($value > 0) return $ret;
        for ($i = -1; $i < 2; $i++)
            for ($j = -1; $j < 2; $j++) {
                if (
                    $x + $i < 0 ||
                    $y + $j < 0 ||
                    $x + $i >= $width ||
                    $y + $j >= $height ||
                    $rows[$y + $j][$x + $i] != '-'
                ) continue;

                $update = $this->updateState($ret['state'], $x + $i, $y + $j, $width, $height, $seed, $limit);
                $ret['updated'] += $update['updated'];
                $ret['state'] = $update['state'];
            }

        return $ret;
    }


    public static function isGameRunning(){
        return Game::where('user_id', auth()->user()->id)->where('status', 'running')->count() > 0;
    }

    public function getGame(Request $request){
        return view('html.game.game', ['error' => false, 'width' => $request->_game->width, 'height' => $request->_game->height, 'bombs' => $request->_game->bombs]);
    }

    public function api_get_game_state(Request $request){
        return ["state" => $request->_game->state];
    }

    public function newGame(Request $request)
    {
        $request->validate([
            'game-type' => ['required'],
        ]);

        if ($request['game-type'] == 'custom') {
            $request->validate([
                'custom-w' => ['required'],
                'custom-h' => ['required'],
                'custom-b' => ['required'],
            ]);
        }

        if ($request['game-type'] != 'easy')
            if ($request['game-type'] != 'normal')
                if ($request['game-type'] != 'hard')
                    if ($request['game-type'] != 'custom') return redirect('/');

        $width = $request['game-type'] == 'easy' ? 8 : ($request['game-type'] == 'normal' ? 16 : ($request['game-type'] == 'hard' ? 30 : $request['custom-w']));
        $height = $request['game-type'] == 'easy' ? 8 : ($request['game-type'] == 'normal' ? 16 : ($request['game-type'] == 'hard' ? 16 : $request['custom-h']));
        $bombs = $request['game-type'] == 'easy' ? 10 : ($request['game-type'] == 'normal' ? 40 : ($request['game-type'] == 'hard' ? 99 : $request['custom-b']));

        //abandon eventually running game
        $previous_game = Game::where('user_id', auth()->user()->id)->where('status', 'running')->first();
        if ($previous_game) {
            $previous_game->status = 'abandoned';
            $previous_game->save();
        }

        $game_seed = $this->createGameSeed($width, $height, $bombs);
        $game = new Game();
        $game->user_id = auth()->user()->id;
        $game->width = $width;
        $game->height = $height;
        $game->bombs = $bombs;
        $game->seed = $game_seed['seed'];
        $game->limit = $game_seed['limit'];
        $game->status = "running";
        $game->state = $this->updateState("", 0, 0, $width, $height, 0, 0);
        $game->save();

        return view('html.game.game', ['error' => false, 'width' => $game->width, 'height' => $game->height, 'bombs' => $game->bombs]);
    }

}
