<?php

namespace App\Http\Controllers;

use App\Mail\AccountCreated;
use App\Models\EmailCode;
use App\Models\Game;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;
use PharIo\Manifest\Email;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function verify(Request $request, string $code){
        $code_entry = EmailCode::find($code);
        $user = $code_entry->user;
        $user->email_verified_at = now();
        $user->save();
        $code_entry->delete();
        return redirect('/login');
    }

    private function checkPasswordStrength(string $password): bool{
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number    = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@\W@', $password);
        return $uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8;
    }

    /**
     * @throws \Exception
     */
    public function store(Request $request): View|RedirectResponse{
        if(Auth::check()) return redirect('/');

        $request->validate([
            'email' => ['required', 'email'],
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if($request->get("password") != $request->get("password-repeat"))
            return view('html.register.register', ["error_msg" => "Passwords do not match"]);

        if(!$this->checkPasswordStrength($request->get("password")))
            return view('html.register.register', ["error_msg" => "Password must be at least 8 characters, must contain a capital and a non capital letter, number and symbol."]);

        $user = User::factory()->unverified()->create([
            "username" => $request->get('username'),
            "id" => $request->get("email"),
            "password" => password_hash($request->get("password"), PASSWORD_ARGON2ID)
        ]);
        $user->save();

        $code = EmailCode::factory()->make(["user_id" => $user->id]);
        $code->save();

        Mail::to($user->email)
            ->to($request->get("email"))
            ->send(new AccountCreated($user->username, $code->token));

        return view('html.register.register_after', ["username" => $user->username]);
    }

    public function login(Request $request): View|RedirectResponse{

        $request->validate([
            'name' => ['required'],
            'password' => ['required'],
        ]);

        $user = User::where('username', $request->get('name'))
            ->orWhere('id', $request->get('name'))
            ->first();

        if(!$user) return view('html.login.login', ['error_msg' => 'Cannot find the requested user']);
        if(!Auth::attempt([
            'id' => $user->id,
            'password' => $request->get('password')
        ])) return view('html.login.login', ['error_msg' => 'Wrong Password']);

        $user->last_login = now();
        $user->save();
        return redirect('/');
    }


    public function logout(Request $request){
        Auth::logout();
        return redirect('/');
    }

    public function self_delete(Request $request){
        if(Storage::exists("public/avatars/" . sha1(auth()->user()->id)))
            Storage::delete("public/avatars/" . sha1(auth()->user()->id));
        auth()->user()->delete();
        //todo send email
        return redirect('/');
    }

    public function chpsw(Request $request){

        $request->validate([
            'password' => ['required'],
            'password-repeat' => ['required'],
        ]);

        if($request->get("password") != $request->get("password-repeat"))
            return view('html.profile.profile', ["error_msg" => "Passwords do not match"]);

        if(!$this->checkPasswordStrength($request->get("password")))
            return view('html.profile.profile', ["error_msg" => "Password must be at least 8 characters, must contain a capital and a non capital letter, number and symbol."]);

        $usr = auth()->user();
        $usr->password = password_hash($request->get("password"), PASSWORD_ARGON2ID);
        $usr->save();

        //todo send email
        return view('html.profile.profile', ["info_msg" => "Password changed"]);
    }

    public function chimg(Request $req){
        if(! $req->hasFile('profilepic'))
            return view("html.profile.profile", ["error_msg" => "Invalid Image"]);

        $req->profilepic->storeAs('public/avatars/', sha1(auth()->user()->id));
        return view('html.profile.profile');
    }

    public function show(Request $req, $username){
        $user = User::where('username', '=', $username)->first();
        if(!$user) return response("not found", 404);

        $games = Game::select(['bombs', 'status', 'created_at', 'finished_at', 'ranked'])
            ->where('user_id', '=', $user->id)
            ->whereNotNull('finished_at')->get();
        $points = Game::select([DB::raw("(CASE WHEN status='won' THEN bombs ELSE -bombs END) as point")])
            ->where('user_id', '=', $user->id)
            ->where('status', '!=', 'running')
            ->where('ranked', '=', 'true')->get();

        $ret = array_fill(0, count($points), 0);
        for($i = 0; $i < count($points); $i++){
            if($i == 0) $ret[0] = $points[0]->point + 1000;
            else $ret[$i] = $ret[$i-1] + $points[$i]->point;
        }

        return [
            "user" => $user,
            "games" => $games,
            "points" => $ret
        ];
    }
}
