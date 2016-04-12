<?php

namespace App\Http\Socials;

interface Writer
{
	/**
	 * post to social media
	 *
	 * @return string
	 */
	public function post();

	/**
	 * post to social media
	 *
	 * @return string
	 */
	public function getPostUri();
}
