<?php

namespace App\Http\Socials;
use App\Status;

interface Eraser
{
	/**
	 * post to social media
	 *
	 * @return string
	 */
	public function delete();

	/**
	 * get api base uri
	 *
	 * @return string
	 */
	public function getDeleteUri();
}
