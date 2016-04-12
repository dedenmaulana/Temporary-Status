<?php

namespace App;

use Mail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
	/**
    * Get the statuses record associated with the User.
    */
   public function statuses()
   {
   		return $this->hasMany('App\Status','user','id');
   }

   /**
    * The "booting" method of the model.
    *
    * @return void
    */
   protected static function boot()
   {
		parent::boot();
   		
   		static::created(function($user) {
   			Mail::send('email-admin', $user->toArray(), function ($message) {
	            $message->to(env('ADMIN_EMAIL','aku@dedenmaulana.com'), env('ADMIN_NAME','Deden Maulana'));
	            $message->subject('New Registerd User');
	        });
   		});
   }
}
