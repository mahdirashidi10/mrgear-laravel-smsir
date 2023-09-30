<?php
/**
 * mahdirashidi.developer@gmail.com
 */

namespace MRGear\SMSIR;

use GuzzleHttp\Client;

/**
 * Class SmsIrNotification
 */
class SMSIR
{
    protected $api_key;
    protected $line_number;
    protected $message;
    protected $messages = [];
    protected $phone_number;
    protected $phone_numbers = [];
    protected $template_id;
    protected $parameters;
    protected $data;
    protected $url_part;

    public function __construct()
    {
        $this->api_key = config('smsir.api_key');
        $this->line_number = config('smsir.line_number');
        $this->template_id = config('smsir.template_id');
    }


    public function getBaseUrl()
    {
        return config('smsir.base_url');
    }

    public function single()
    {
        return $this->phoneNumbers([$this->phone_number])->multiple();
    }

    public function multiple()
    {
        if (is_array($this->message) || $this->message === null || !is_array($this->phone_numbers) || $this->phone_numbers === null)
            throw new \RuntimeException('The data has not been specified correctly. [Message => NOTNULL/STRING | PhoneNumbers => NOTNULL||ARRAY');

        $this->data = [
            'lineNumber' => $this->line_number,
            'messageText' => $this->message,
            'mobiles' => $this->phone_numbers
        ];
        $this->url_part = 'bulk';
        return $this;
    }

    public function p2p()
    {
        if (!is_array($this->messages) || !is_array($this->phone_numbers) || count($this->messages) !== count($this->phone_numbers))
            throw new \RuntimeException('The data has not been specified correctly. [Message => NOTNULL/ARRAY | PhoneNumbers => NOTNULL||ARRAY | COUNT(Messages) = COUNT(PhoneNumbers)');
        $this->data = [
            'mobiles' => $this->phone_numbers,
            'messageTexts' => $this->messages,
            'lineNumber' => $this->line_number,
        ];
        $this->url_part = 'likeToLike';
        return $this;
    }

    public function fast(array $parameters = [] , $magic_resolver = false)
    {
        if (($this->parameters === null && $parameters === null) || $this->template_id === null || $this->phone_number === null)
            throw new \RuntimeException('The data has not been specified correctly. [PhoneNumber => NOTNULL/STRING | TemplateId => NOTNULL|STRING | PARAMETERS => NOTNULL|ARRAY');
        $resolved_data = $this->dataResolver(!empty($this->parameters) ? (array)$this->parameters : $parameters , $magic_resolver);
        $this->data = [
            'mobile' => (string)$this->phone_number,
            'templateId' => (string)$this->template_id,
            'parameters' => $resolved_data
        ];
        $this->url_part = 'verify';
        return $this;
    }

    public function send()
    {
        if ($this->url_part === null || $this->data === null)
            throw new \RuntimeException('Please select sms send method [single/fast/multiple/p2p]');
        $url = $this->getBaseUrl() . $this->url_part;
        try {
            $client = new Client(['verify' => false]);
            $request = $client->request('POST', $url,
                [
                    'headers' => [
                        'X-API-KEY' => $this->api_key,
                        'ACCEPT' => 'application/json',
                        'Content-Type' => 'application/json',
                    ],
                    'body' => json_encode($this->data),

                ]
            );
            $response = json_decode($request->getBody()->getContents(), true);
            if (isset($response['status']) && $response['status'] == 1) {
                return ['message' => 'Message sent'];
            }
            return false;
        } catch (\Exception $exception) {
            throw $exception;
        }

    }

    public function phoneNumbers(array $phone_numbers)
    {
        $this->phone_numbers = $phone_numbers;
        return $this;
    }

    public function phoneNumber(string $phone_number)
    {
        $this->phone_number = $phone_number;
        return $this;
    }

    public function templateId($template_id = null)
    {
        if (!is_null($template_id)) {
            $this->template_id = $template_id;
        }
        return $this;
    }

    public function message(string $message)
    {
        $this->message = $message;
        return $this;
    }

    public function messages(array $messages)
    {
        $this->messages = $messages;
        return $this;
    }

    public function parameters(array $parameters)
    {
        $this->parameters = $parameters;
        return $this;
    }

    protected function dataResolver($parameters, $magic_resolve = false)
    {
        if ($magic_resolve === true) {
            if (count($parameters) == count($parameters, COUNT_RECURSIVE))
                $parameters = [$parameters];
            $counter = 1;
            $check_counter = 0;
            foreach ($parameters as $parent_key => $parameter):
                foreach ($parameter as $key => $value):
                    if ($counter < 3) {
                        if (ctype_alpha(str_replace('_', '', $value))) {
                            $check_counter++;
                            $name_key = $key;
                            $name_value = $value;
                        }
                        if (ctype_digit($value)) {
                            $check_counter++;
                            $value_key = $key;
                            $value_value = "{$value}";
                        }
                    }
                    if ($check_counter === 2) {
                        unset($parameters[$parent_key][$name_key]);
                        $parameters[$parent_key]['name'] = $name_value;
                        unset($parameters[$parent_key][$value_key]);
                        $parameters[$parent_key]['value'] = $value_value;
                        $check_counter = 0;
                    } else {
                        if ($counter == 1 && $key !== 'name') {
                            unset($parameters[$parent_key][$key]);
                            $parameters[$parent_key]['name'] = $value;
                        }
                        if ($counter == 2 && $key !== 'value') {
                            unset($parameters[$parent_key][$key]);
                            $parameters[$parent_key]['value'] = $value;
                        }
                    }
                    $array_helper = $parameter;
                    end($array_helper);
                    if ($counter >= 3)
                        unset($parameters[$parent_key][$key]);
                    if ($key === key($array_helper))
                        $counter = 0;
                    $counter++;
                endforeach;
            endforeach;
        } else {
            $resolved_parameters = [];
            foreach ($parameters as $key => $value) {
                $resolved_parameters[] = ['name' => (string)$key, 'value' => (string)$value];
            }
            $parameters = $resolved_parameters;
        }
        return $parameters;
    }
}
