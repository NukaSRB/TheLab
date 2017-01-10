<?php

namespace App\Services\Linking\Http\Controllers;

use App\Http\Controllers\BaseController;
// use App\Services\Linking\Events\AccountLinked;
use Laravel\Socialite\Facades\Socialite;

class Link extends BaseController
{
    public function redirect($driver)
    {
        list ($driver, $scopes, $extras) = $this->getProviderDetails($driver);

        return Socialite::driver($driver)
                        ->scopes($scopes)
                        ->with($extras)
                        ->redirect();
    }

    /**
     * Use the returned user to register (if needed) and login.
     *
     * @param null|string $provider
     *
     * @return mixed
     */
    public function callback($provider = null)
    {
        list ($driver, $scopes, $extras) = $this->getProviderDetails($provider);

        $socialUser = Socialite::driver($driver)->user();

        if (is_null($socialUser->token)) {
            $socialUser->token = $provider;
        }

        if (! auth()->user()->hasProvider($driver)) {
            auth()->user()->addSocial($socialUser, $driver);
        } else {
            auth()->user()->getProvider($driver)->updateFromProvider($socialUser, $driver);
        }

        // event(new AccountLinked($driver, auth()->user(), $socialUser));

        return redirect()
            ->intended(route('link.index'))
            ->with('message', $provider .' has been linked to your account.');
    }

    /**
     * Find the provider's driver, scopes andLinks.php extras based on a given provider name.
     *
     * @param $provider
     *
     * @return mixed
     * @throws \Exception
     */
    private function getProviderDetails($provider)
    {
        $providers = collect(config('jumpgate.users.providers'))->keyBy('driver');

        if (empty($providers)) {
            throw new \Exception('No Providers have been set in users config.');
        }

        $provider = $providers->get($provider);

        if (is_null($provider['driver'])) {
            throw new \InvalidArgumentException('You must set a social driver to use the social authenticating features.');
        }

        return [
            $provider['driver'],
            $provider['scopes'],
            $provider['extras'],
        ];
    }
}
