<?php

namespace Beanstalkapi\Credentials;

use JsonSchema\Validator;

class CredentialsFile
{

    /**
     * Parse credentials.json
     *
     * @throws \Exception
     */
    public function getCredentials()
    {
        $credentialsFile = $this->getCredentialsFile();
        $data            = json_decode(file_get_contents($credentialsFile));

        $schemaFile = __DIR__ . '/credentials-schema.json';
        $schemaData = json_decode(file_get_contents($schemaFile));

        $validator = new Validator();
        $validator->check($data, $schemaData);

        if (!$validator->isValid()) {
            $errors = array();
            foreach ((array)$validator->getErrors() as $error) {
                $errors[] = ($error['property'] ? $error['property'] . ' : ' : '') . $error['message'];
            }

            throw new \Exception('"' . $credentialsFile . '" does not match the expected JSON schema (' . json_encode(
                $errors
            ) . ')');
        }

        return array(
            'account'  => $data->account,
            'username' => $data->auth->username,
            'password' => $data->auth->password,
        );
    }

    protected function getCredentialsFile()
    {
        $file = 'credentials.json';
        if (!file_exists($file)) {
            throw new \Exception('No credentials.json file found');
        }

        return $file;
    }

    /**
     * Turns Object (nested) into assoxiative array
     * to ease integration with Laravel Config style.
     *
     * @param $object
     * @return array
     */
    protected function toArray($object)
    {
        if (is_array($object) || is_object($object)) {
            $result = array();
            foreach ($object as $key => $value) {
                $result[$key] = $this->toArray($value);
            }
            return $result;
        }
        return $object;
    }

}