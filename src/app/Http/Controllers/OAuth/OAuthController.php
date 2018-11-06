<?php

namespace Cast\OAuth\app\Http\Controllers;

use Illuminate\Routing\Controller;
use Laravel\Socialite\Facades\Socialite;

class OAuthController extends Controller
{
    /**
     *
     */
    public function redirectToProvider($service)
    {
        return Socialite::driver($service)->stateless()->redirect();
    }

    /**
     *
     */
    public function handleProviderCallback($service)
    {
        $client = $this->authenticate($service);

        dd((array)$client);
    }

    public function authenticate($service)
    {
        if (!in_array($service, array_keys(config('services')))) {
            abort(422, 'Provider not found.');
        }

        if ($error = app('request')->input('error', null)) {
            abort(422, "OAuth error: \"{$error}\".");
        }

        $client = $this->getClient($service);

        if (!$client) {
            abort(403, 'Unauthorized action.');
        }

        return $client;
    }

    /**
     * @param $service
     * @return mixed
     */
    public function getClient($service)
    {
        $driver = Socialite::driver($service);

        if ($service == 'facebook') {
            $driver->fields(['name', 'first_name', 'last_name', 'email', 'gender', 'verified']);
        }

        return $driver->stateless()->user();
    }

}
