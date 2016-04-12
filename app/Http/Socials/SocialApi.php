<?php

namespace App\Http\Socials;

use LogicException;
use InvalidArgumentException;

use GuzzleHttp\Client;

abstract class SocialApi
{
	/**
	 * client guzzlehttp
	 *
	 * @var GuzzleHttp/Client
	 */
	protected $client;

	/**
	 * response
	 *
	 * @var stdObject
	 */
	protected $response;

	/**
	 * parameter of request
	 *
	 * @var array
	 */
	protected $params = [];

	/**
	 * class constructor
	 *
	 * @param array $params
	 * @return void
	 **/
	public function __construct()
    {
        $this->client = new Client([
            'base_uri' => $this->getApiBaseUri(),
            'timeout'  => 2.0,
        ]);
    }

    /**
     * set values to params
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setParam($key, $value)
    {
    	$this->params[$key] = $value;
    	return $this;
    }

    /**
     * set values of param/s
     *
     * @param mixed $params
     * @return void
     */
    public function setParams(Array $params)
    {
    	foreach ($params as $key => $value) {
    		$this->setParam($key, $value);
    	}

    	return $this;
    }

    /**
     * send request
     *
     * @return void
     **/
    public function send($method, $uri)
    {
        $this->response = $this->client->request($method, $uri, [
            'form_params' => $this->params,
        ]);

        return $this;
    }

    /**
     * undocumented function
     *
     * @param string $type
     * @return void
     **/
    public function body($type = null)
    {
        if ($this->response === null) {
            throw new LogicException("Request has not been sent.");
        }

        if ($type === 'json') {
            return json_decode((string) $this->response->getBody(), true);
        } elseif ($type === 'string') {
            return (string) $this->response->getBody();
        } elseif ($type === null) {
            return $this->response->getBody();
        } else {
            throw new InvalidArgumentException("Type not supported.");
        }
    }
    
    /**
     * get base of api social provider
     *
     * @return string
     **/
    abstract public function getApiBaseUri();
}
