<?php

namespace App\Http\Socials\Providers;

use Auth;
use App\Http\Socials\Eraser;
use App\Http\Socials\Writer;
use App\Http\Socials\SocialApi;

use Exception;
use App\Status;

class Facebook extends SocialApi implements Writer, Eraser
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

		$params = [];
		$params['access_token'] = $this->status->owner->social_token;
		$params['message'] = $this->status->message;
		$params['link'] = null;
		if ( ! empty($this->status->link)) {
			$params['link'] = $this->status->link;
		}

		$this->setParams($params);
		$post = $this->send('post', $this->getPostUri())->body('json');

		$this->status->social_post_id = $post['id'];
		$this->status->status = 'live';
		$this->status->save();		
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

		$this->setParam('access_token', $this->status->owner->social_token);
		$this->send('delete', $this->status->social_post_id);

		$this->status->status = 'deleted';
		$this->status->save();
		$this->status->delete();
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
				? 'me/feed'
				: $this->postUri;
	}

	/**
	 * get base api uri
	 *
	 * @return string
	 */
	public function getDeleteUri()
	{
		return '';
	}

	/**
	 * get base api uri
	 *
	 * @return string
	 */
	public function getApiBaseUri()
	{
		return 'https://graph.facebook.com/v2.5/';
	}
}
	