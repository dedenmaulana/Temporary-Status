<?php

namespace App\Http\Socials\Providers;

use Auth;
use App\Http\Socials\Eraser;
use App\Http\Socials\Writer;
use App\Http\Socials\SocialApi;
use Abraham\TwitterOAuth\TwitterOAuth;

use Exception;
use App\Status;

class Twitter extends SocialApi implements Writer, Eraser
{
	/**
	 * status
	 *
	 * @var App\Status
	 */
	protected $status;

	/**
	 * post uri to facebook
	 *
	 * @var string
	 */
	protected $postUri;

	/**
	 * Create a new Facebook instance.
	 *
	 * @param Illuminate\Http\Request $request
	 * @return void
	 */
	public function __construct(Status $status)
	{
		parent::__construct();	
		$this->setStatus($status);
	}

	/**
	 * set request
	 *
	 * @param Illuminate\Http\Request $request
	 * @return Facebook
	 */
	public function setStatus(Status $status)
	{
		$this->status = $status;

		return $this;
	}

	/**
	 * post request to social media
	 *
	 * @return Facebook
	 */
	public function post()
	{
		if ($this->status->status !== 'pending') {
			throw new Exception('Status is not pending '.$this->status->id);
		}

		$token = json_decode($this->status->owner->social_token);
		$connection = new TwitterOAuth(env('TWITTER_ID'), env('TWITTER_SECRET'), $token->token, $token->tokenSecret);
		
		$message = $this->status->message;
		if ( ! empty($this->status->link)) {
			$message .= $this->status->link;
		}

		$connection->post($this->getPostUri(), ["status" => $message]);
		if ($connection->getLastHttpCode() == 200) {
			$this->status->social_post_id = $connection->getLastBody()->id;
			$this->status->status = 'live';
			$this->status->save();
		}	
	}

	/**
	 * delete posting status
	 *
	 * @param App\Status $status
	 * @return data type
	 */
	public function delete()
	{
		if ($this->status->status !== 'live' OR empty($this->status->social_post_id)) {
			throw new Exception("Status is not live");
		}

		$token = json_decode($this->status->owner->social_token);
		$connection = new TwitterOAuth(env('TWITTER_ID'), env('TWITTER_SECRET'), $token->token, $token->tokenSecret);
		
		$message = $this->status->message;
		if ( ! empty($this->status->link)) {
			$message .= $this->status->link;
		}

		$connection->post($this->getDeleteUri().$this->status->social_post_id);
		if ($connection->getLastHttpCode() == 200) {
			$this->status->status = 'deleted';
			$this->status->save();
			$this->status->delete();
		}
	}

	/**
	 * set posturi
	 *
	 * @param string $uri
	 * @return void
	 */
	public function setPostUri($uri)
	{
		$this->postUri = $uri;
	}

	/**
	 * get base api uri
	 *
	 * @return string
	 */
	public function getPostUri()
	{
		return empty($this->postUri)
				? 'statuses/update'
				: $this->postUri;
	}

	/**
	 * get base api uri
	 *
	 * @return string
	 */
	public function getDeleteUri()
	{
		return 'statuses/destroy/';
	}

	/**
	 * get base api uri
	 *
	 * @return string
	 */
	public function getApiBaseUri()
	{
		//
	}
}
	