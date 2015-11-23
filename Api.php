<?php

namespace GuildWars2;

use GuildWars2\Api\Entity\Account;
use GuildWars2\Api\Entity\Character;
use GuildWars2\Api\Entity\Specialization;
use GuildWars2\Api\Entity\SpecializationTrait;
use GuildWars2\Api\EntitySet;

class Api
{

    private $_options;
    private $_entitySets;

    public function __construct(array $options = null)
    {

        $this->_options = array_replace_recursive([
            'key' => null,
            'uri' => 'https://api.guildwars2.com/v2',
            'language' => 'en',
            'entitySets' => [
                'characters' => [
                    '/characters',
                    Character::class,
                    false
                ],
                'specializations' => [
                    '/specializations',
                    Specialization::class
                ],
                'traits' => [
                    '/traits',
                    SpecializationTrait::class
                ]
            ],
            'cacheDirectory' => sys_get_temp_dir(),
            'cacheLifeTime' => 3600
        ], $options ? $options : []);

        $this->_entitySets = [];

        foreach ($this->_options['entitySets'] as $name => $args) {

            list($path, $className, $supportsAll) = array_pad($args, 3, true);

            $this->_entitySets[$name] = new EntitySet($this, $name, $path, $className, $supportsAll);
        }
    }

    public function getAccount()
    {

        $accInfo = $this->fetchAccount();

        $acc = new Account($this, $accInfo->getPath());
        $acc->update($accInfo->getData());

        return $acc;
    }

    public function getFontUri()
    {

        return 'https://d1h9a8s8eodvjz.cloudfront.net/fonts/menomonia/08-02-12/menomonia.css';
    }

    public function getItalicFontUri()
    {

        return 'https://d1h9a8s8eodvjz.cloudfront.net/fonts/menomonia/08-02-12/menomonia-italic.css';
    }

    public function getImageUri($signature, $fileId, $format = null)
    {

        $format = $format ? $format : 'png';

        return 'https://render.guildwars2.com/file/'.$signature.'/'.$fileId.'.'.$format;
    }

    public function fetch($path, array $data = null, $method = null)
    {

        $data = $data ? $data : [];
        $method = $method ? $method : 'GET';

        //Default passed data
        $data['lang'] = $this->_options['lang'];

        //HTTP stream context options
        $options = [
            'http' => [
                'method' => $method
            ]
        ];

        if ($this->_options['key']) {

            $options['http']['header'] = "Authorization: Bearer {$this->_options['key']}\r\n";
        }

        $uri = $this->_options['uri'].$path;

        if ($method === 'POST') {

            $options['http']['content'] = http_build_query($data);
        } else {

            $uri .= '?'.http_build_query($data);
        }

        //Create a cache-key to be able to cache this request by it's request data
        $key = sha1($uri.serialize($options));

        $cachePath = $this->_options['cacheDirectory'].'/gw2php-'.$key.'.cache';
        if (file_exists($cachePath) && time() - filemtime($cachePath) <= $this->_options['cacheLifeTime'])
            return unserialize(file_get_contents($cachePath));

        $context = stream_context_create($options);
        $stream = @fopen($uri, 'r', false, $context);

        if (!$stream)
            throw new Api\Exception(
                "Failed to fetch: ".error_get_last()['message']
            );

        $content = stream_get_contents($stream);

        $result = @json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE)
            throw new Api\Exception(
                "Failed to fetch: Invalid JSON received (".json_last_error_msg().")"
            );

        if (isset($result['error']))
            throw new Api\Exception(
                "Failed to fetch: ".$result['error']
            );

        if (isset($result['text']) && count($result) === 1)
            throw new Api\Exception(
                "Failed to fetch: ".$result['text']
            );


        $data = stream_get_meta_data($stream);
        $headers = [];
        foreach ($data['wrapper_data'] as $header) {

            if (!strstr($header, ':'))
                continue;

            list($name, $value) = explode(':', $header, 2);
            $headers[trim($name)] = trim($value);
        }

        $page = isset($data['page']) ? $data['page'] : 0;
        $resultCount = isset($headers['X-Result-Count']) ? $headers['X-Result-Count'] : count($result);
        $totalCount = isset($headers['X-Result-Total']) ? $headers['X-Result-Total'] : $resultCount;
        $totalPages = isset($headers['X-Page-Total']) ? $headers['X-Page-Total'] : 1;
        $pageSize = isset($headers['X-Page-Size']) ? $headers['X-Page-Size'] : (
            isset($data['page_size']) ? $data['page_size'] : $resultCount
        );


        $page = new Api\Page(
            $path,
            $page,
            $totalPages,
            $pageSize,
            $totalCount,
            $resultCount,
            $result
        );

        file_put_contents($cachePath, serialize($page));

        return $page;
    }

    public function fetchAccount()
    {

        if (!isset($this->_options['key']))
            throw new Api\Exception(
                "You need to set the \"key\" option to enter account info"
            );

        return $this->fetch('/account');
    }

    /**
     * @param $name
     *
     * @return EntitySet
     */
    public function __get($name)
    {

        return $this->_entitySets[$name];
    }
}