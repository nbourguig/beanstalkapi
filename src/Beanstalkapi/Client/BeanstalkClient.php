<?php

namespace Beanstalkapi\Client;


use Guzzle\Common\Collection;
use Guzzle\Plugin\CurlAuth\CurlAuthPlugin;
use Guzzle\Service\Client;
use Guzzle\Service\Description\ServiceDescription;

class BeanstalkClient extends Client
{

    protected $resource = false;

    public static function factory($config = array())
    {
        // Get credentials
        $default = array(
            'base_url'   => 'https://{account}.beanstalkapp.com/api',
            'user_agent' => 'beanstalk-sdk-php'
        );

        // Required options
        $required = array('account', 'username', 'password');
        $config   = Collection::fromConfig($config, $default, $required);

        $client = new static($config->get('base_url'), $config);

        // Set default headers
        $client->setDefaultHeaders(
            array(
                'Content-Type' => 'application/json',
                'User-Agent'   => $config->get('user_agent'),
            )
        );

        // Basic auth
        $authPlugin = new CurlAuthPlugin(
            $config->get('username'),
            $config->get('password')
        );
        $client->addSubscriber($authPlugin);


        // Attach service description
        $client->setDescription(ServiceDescription::factory(__DIR__ . '/../Resources/beanstalk.json'));

        return $client;
    }

    public function __call($method, $args)
    {
        // Parent __call
        $result = $this->getCommand($method, isset($args[0]) ? $args[0] : array())->getResult();

        // Collection ?
        if (is_array($result)) {
            return $this->extractFromArray($result);
        }
    }


    protected function extractFromArray($array)
    {
        $result = array();
        foreach ($array as $item) {
            $result[] = isset($item[$this->resource])
                ? $item[$this->resource] : $item;
        }

        return $result;
    }


}