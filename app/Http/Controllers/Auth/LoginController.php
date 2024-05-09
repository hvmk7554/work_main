<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\External\UserService;
use Illuminate\Http\Client\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Kreait\Firebase\Auth\UserRecord;
use Kreait\Firebase\Factory;
use Throwable;

class LoginController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            return redirect()->route('nova.pages.home');
        }

        return Inertia::render('Auth/Login', [
            'firebaseConfig' => config('services.firebase.config'),
        ]);
    }

    /**
     * @throws Throwable
     */
    public function store(Request $request): RedirectResponse
    {
        $record = $this->verifyIdToken($request->get('token'));
        if ($record == null) {
            abort(400);
        }

        // if (Str::endsWith($record->email, '@marathon.vn')) {
        //     $record->email = Str::replace('@marathon.vn', "@marathon.edu.vn", $record->email);
        // }

        // if (!Str::endsWith($record->email, '@marathon.edu.vn')) {
        //     abort(403, 'Only "@marathon.edu.vn" is allowed.');
        // }

        $user = User::where('email', $record->email)->first();
        if ($user == null) {
            $user = User::create([
                'name' => $record->displayName,
                'email' => $record->email,
                'password' => Str::random(),
            ]);
        } else {
            $user->name = $record->displayName;
            $user->save();
        }

        Auth::login($user, true);
        return redirect()->route('nova.pages.home');
    }

    public function destroy()
    {
        Auth::logout();
        return redirect()->route('nova.pages.home');
    }

    private function verifyIdToken(string $accessToken): ?UserRecord
    {
        try {
            $serviceAccountAsString = base64_decode(config('services.firebase.service_account'));
            $serviceAccount = json_decode($serviceAccountAsString, true);

            $auth = (new Factory)->withServiceAccount($serviceAccount)->createAuth();

            $verifiedIdToken = $auth->verifyIdToken($accessToken);
            $uid = $verifiedIdToken->claims()->get('sub');

            return $auth->getUser($uid);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return null;
        }
    }
}
