<?php

namespace App\Http\Socials;

use URL;
use Auth;
use Socialite;
use App\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Exception\RequestException;
use Laravel\Socialite\Contracts\User as SocialUser;

class Authentication extends Controller
{
	/**
	 * provider
	 *
	 * @var string
	 */
	public $provider;

	/**
	 * scopes
	 *
	 * @var array
	 */
	public $scopes = [];

    /**
     * Handle process request getAuth
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getAuth(Request $request)
    {
    	$socialite = Socialite::with($this->provider);

    	if (count($this->scopes) > 0) {
    		$socialite->scopes($this->scopes);
    	}

    	return $socialite->redirect();
    }

	/**
     * Handle process request getCallback
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function getCallback(Request $request)
    {
        try {
        	$userSocial = Socialite::with($this->provider)->user();
        	$user = $this->getUser($userSocial);
            Auth::login($user);
            return redirect(URL::to($user->provider));            
        }
        catch (RequestException $e) {
            return redirect(URL::to('/'));
        }
    }

    /**
     * getUser of authenticated
     *
     * @param User $user
     * @return void
     */
    protected function getUser(SocialUser $socialUser)
    {
    	$user = User::whereSocialId($socialUser->getId());

    	if ($user->exists()) {
    		//use user
    		$user = $user->first();
        } else {
            $token = $socialUser->token;
            if (isset($socialUser->tokenSecret)) {
                $mergeToken['token'] = $socialUser->token;
                $mergeToken['tokenSecret'] = $socialUser->tokenSecret;
                $token = json_encode($mergeToken);
            }
            
            //create user
            $user = new User;
            $user->name = $socialUser->getName();
            $user->email = $socialUser->getEmail() ?: '';
            $user->profile_picture = $socialUser->getAvatar();
            $user->provider = $this->provider;
            $user->social_id = $socialUser->getId();
            $user->social_token = $token;
            $user->save();
    	}

    	return $user;
    }
}
