<?php

namespace Beanstalkapi;

use Beanstalkapi\Credentials\CredentialsFile;

class Api
{
    protected $account;
    protected $username;
    protected $password;

    public function __construct($credentials = null)
    {
        // Try to set crendentials
        $this->setCrendentials($credentials);

    }

    protected function setCrendentials($credentials)
    {
        // If no credentials are given, pick them from crendentials.json
        if (is_null($credentials)) {
            $c = new CredentialsFile();
            $this->setCredentialsFromArray($c->getCredentials());
        } // Credentials given as an array
        elseif (is_array($credentials)) {
            $this->setCredentialsFromArray($credentials);
        } //
        else {
            throw new \Exception("Invalid credentials");
        }


        print_r(array('$this'=>$this));exit;
        
    }

    protected function setCredentialsFromArray($array)
    {
        if (empty($array['account'])
            || empty($array['username'])
            || empty($array['password'])
        ) {
            throw new \Exception("Invalid credentials");
        } else {
            $this->account  = $array['account'];
            $this->username = $array['username'];
            $this->password = $array['password'];
        }
    }

}