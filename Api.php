<?php

namespace GuildWars2;

use GuildWars2\Api\Entity\Account;
use GuildWars2\Api\Entity\Character;
use GuildWars2\Api\Entity\File;
use GuildWars2\Api\Entity\Item;
use GuildWars2\Api\Entity\Specialization;
use GuildWars2\Api\Entity\SpecializationTrait;
use GuildWars2\Api\EntitySet;
use Tale\Http\Client;
use Tale\Http\Method;

class Api
{

    private $_options;
    private $_client;
    private $_entitySets;

    public function __construct(array $options = null)
    {

        $this->_options = array_replace_recursive([
            'key' => null,
            'uri' => 'https://api.guildwars2.com/v2',
            'userAgent' => 'GuildWars2 PHP API Library',
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
                ],
                'files' => [
                    '/files',
                    File::class
                ],
                'items' => [
                    '/items',
                    Item::class,
                    false
                ]
            ],
            'cacheDirectory' => sys_get_temp_dir(),
            'cacheLifeTime' => 3600
        ], $options ? $options : []);

        $headers = [];
        if ($this->_options['key'])
            $headers['Authorization'] = "Bearer {$this->_options['key']}";

        $headers['User-Agent'] = $this->_options['userAgent'];

        $this->_client = new Client([
            'baseUri' => $this->_options['uri'],
            'headers' => $headers
        ]);
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
        $method = $method ? $method : Method::GET;

        //Default passed data
        $data['lang'] = $this->_options['lang'];

        //Create a cache-key to be able to cache this request by it's request data
        $key = sha1($method.$path.serialize($data).($this->_options['key'] ? $this->_options['key'] : ''));

        $cachePath = $this->_options['cacheDirectory'].'/gw2php-'.$key.'.cache';
        if (file_exists($cachePath) && time() - filemtime($cachePath) <= $this->_options['cacheLifeTime'])
            return unserialize(file_get_contents($cachePath));

        $response = $this->_client->request($method, $path, $data);
        $body = (string)$response->getBody();

        $result = @json_decode($body, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            echo((string)$response->getBody());
            throw new Api\Exception(
                "Failed to fetch: Invalid JSON received (".json_last_error_msg().")"
            );
        }

        if (isset($result['error']))
            throw new Api\Exception(
                "Failed to fetch: ".$result['error']
            );

        if (isset($result['text']) && count($result) === 1)
            throw new Api\Exception(
                "Failed to fetch: ".$result['text']
            );

        $page = isset($data['page']) ? $data['page'] : 0;
        $resultCount = $response->hasHeader('x-result-count')
                     ? intval($response->getHeaderLine('x-result-count'))
                     : count($result);
        $totalCount = $response->hasHeader('x-result-total')
                    ? intval($response->getHeader('x-result-total'))
                    : $resultCount;
        $totalPages = $response->hasHeader('x-page-total')
                    ? intval($response->getHeaderLine('x-page-total'))
                    : 1;
        $pageSize = $response->hasHeader('x-page-size')
                  ? intval($response->getHeaderLine('x-page-size'))
                  :  (
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