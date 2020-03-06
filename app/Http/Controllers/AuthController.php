<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Validator;
use App\User;
class AuthController extends Controller
{
    /**
     * Register a new user
     */
    public function register(Request $request)
    {
        $v = Validator::make($request->all(), [
            'first_name' => 'required|min:1|regex:/^[\pL\s\-]+$/u',
            'last_name' => 'required|min:1|regex:/^[\pL\s\-]+$/u',
            'email' => 'required|email|unique:users',
            'password'  => 'required|min:6|confirmed',
        ]);

        if ($v->fails())
        {
            return response()->json([
                'status' => 'error',
                'errors' => $v->errors()
            ], 422);
        }
        $user = new User();
        $user->first_name = ucwords(strtolower($request->first_name));
        $user->last_name = ucwords(strtolower($request->last_name));
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();
        $credentials = $request->only('first_name', 'last_name', 'email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success', 'token' => $token, 'userId' => $user->id, 'expires_in' => $this->guard()->factory()->getTTL() * 60], 200);
        }
    }
    /**
     * Login user and return a token
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if ($token = $this->guard()->attempt($credentials)) {
            return response()->json(['status' => 'success', 'token' => $token, 'userId' => Auth::user()->id, 'expires_in' => $this->guard()->factory()->getTTL() * 60], 200);
        }
        return response()->json(['error' => 'login_error'], 401);
    }
    /**
     * Logout User
     */
    public function logout()
    {
        $this->guard()->logout();
        return response()->json([
            'status' => 'success',
            'msg' => 'Logged out Successfully.'
        ], 200);
    }
    /**
     * Get authenticated user
     */
    public function user(Request $request)
    {
        $user = User::find(Auth::user()->id);
        return response()->json([
            'status' => 'success',
            'data' => $user
        ]);
    }
    /**
     * Refresh JWT token
     */
    public function refresh()
    {
        if ($token = $this->guard()->refresh()) {
            return response()
                ->json(['status' => 'successs'], 200)
                ->header('Authorization', $token);
        }
        return response()->json(['error' => 'refresh_token_error'], 401);
    }
    /**
     * Return auth guard
     */
    private function guard()
    {
        return Auth::guard();
    }
}
