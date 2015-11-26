<?php

namespace GuildWars2;

use GuildWars2\Api\Entity\Account;
use GuildWars2\Api\Entity\Achievement;
use GuildWars2\Api\Entity\Character;
use GuildWars2\Api\Entity\Color;
use GuildWars2\Api\Entity\Continent;
use GuildWars2\Api\Entity\Currency;
use GuildWars2\Api\Entity\Emblem\Background;
use GuildWars2\Api\Entity\Emblem\Foreground;
use GuildWars2\Api\Entity\File;
use GuildWars2\Api\Entity\Guild;
use GuildWars2\Api\Entity\Item;
use GuildWars2\Api\Entity\Mini;
use GuildWars2\Api\Entity\Skin;
use GuildWars2\Api\Entity\Specialization;
use GuildWars2\Api\Entity\SpecializationTrait;
use GuildWars2\Api\Entity\TokenInfo;
use GuildWars2\Api\Entity\World;
use GuildWars2\Api\EntitySet;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Stream;

class Api
{

    private $_options;
    private $_client;
    private $_entitySets;

    public function __construct(array $options = null)
    {

        $this->_options = array_replace_recursive([
            'key' => null,
            'uri' => 'https://api.guildwars2.com',
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
                ],
                'achievements' => [
                    '/achievements',
                    Achievement::class,
                    false
                ],
                'colors' => [
                    '/colors',
                    Color::class
                ],
                'minis' => [
                    '/minis',
                    Mini::class
                ],
                'skins' => [
                    '/skins',
                    Skin::class
                ],
                'currencies' => [
                    '/currencies',
                    Currency::class
                ],
                'worlds' => [
                    '/worlds',
                    World::class
                ],
                'emblemForegrounds' => [
                    '/emblem/foregrounds',
                    Foreground::class,
                    true,
                    false
                ],
                'emblemBackgrounds' => [
                    '/emblem/backgrounds',
                    Background::class,
                    true,
                    false
                ],
                'continents' => [
                    '/continents',
                    Continent::class
                ]
            ],
            'cacheDirectory' => sys_get_temp_dir(),
            'cacheLifeTime' => 3600,
            'debug' => fopen(__DIR__.'/log.txt', 'a+')
        ], $options ? $options : []);

        $headers = [];
        if ($this->_options['key'])
            $headers['Authorization'] = "Bearer {$this->_options['key']}";

        $headers['User-Agent'] = $this->_options['userAgent'];

        $this->_client = new Client([
            'base_uri' => $this->_options['uri'],
            'headers' => $headers,
            'verify' => false,
            'debug' => $this->_options['debug']
        ]);
        $this->_entitySets = [];

        foreach ($this->_options['entitySets'] as $name => $args) {

            list($path, $className, $supportsAll, $supportsOne) = array_pad($args, 4, null);

            $this->_entitySets[$name] = new EntitySet($this, $name, $path, $className, $supportsAll, $supportsOne);
        }

        @ini_set('max_execution_time', 0);
        @ini_set('xdebug.max_nesting_level', 10000);

        if (function_exists('mb_internal_encoding')) {

            mb_http_output('UTF-8');
            mb_internal_encoding('UTF-8');
            ob_start('mb_output_handler');
        }
    }

    /**
     * @return Account
     * @throws Api\Exception
     */
    public function getAccount()
    {

        $accInfo = $this->fetchAccount();

        $acc = new Account($this, $accInfo->getPath());
        $acc->update($accInfo->getData());

        return $acc;
    }

    /**
     * @return TokenInfo
     * @throws Api\Exception
     */
    public function getTokenInfo()
    {

        $tokenInfo = $this->fetchTokenInfo();

        $token = new TokenInfo($this, $tokenInfo->getPath());
        $token->update($tokenInfo->getData());

        return $token;
    }

    /**
     * @param $guildId
     *
     * @return Guild
     */
    public function getGuild($guildId)
    {

        $guildInfo = $this->fetchGuild($guildId);

        $guild = new Guild($this, '/guild_details.json?guild_id='.$guildId);
        $guild->update($guildInfo->getData());

        return $guild;
    }

    public function getBuildId()
    {

        $info = $this->fetchBuildId();

        return $info->getData()['id'];
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

    public function fetch($path, array $data = null, $method = null, $apiVersion = null)
    {

        $apiVersion = $apiVersion ? $apiVersion : 'v2';

        $data = $data ? $data : [];
        $method = $method ? $method : 'GET';

        //Default passed data
        $data['lang'] = $this->_options['lang'];

        //Create a cache-key to be able to cache this request by it's request data
        $key = sha1($method.$path.serialize($data).($this->_options['key'] ? $this->_options['key'] : ''));

        $cachePath = $this->_options['cacheDirectory'].'/gw2php-'.$key.'.cache';
        if (file_exists($cachePath) && time() - filemtime($cachePath) <= $this->_options['cacheLifeTime'])
            return unserialize(file_get_contents($cachePath));

        $options = [];

        array_walk($data, function(&$value) {

            if (function_exists('mb_convert_encoding') && function_exists('mb_detect_encoding')) {

                $value = mb_convert_encoding($value, mb_detect_encoding($value), 'UTF-8');
            }
        });

        if ($method === 'GET')
            $options['query'] = http_build_query($data, null, '&', \PHP_QUERY_RFC1738);
        else
            $options['form_params'] = $data;

        $request = new Request($method, "/$apiVersion$path");
        $response = $this->_client->sendAsync($request, $options)->wait();
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

    public function download($uri, $bodyAsString = false)
    {
        $key = 'gw2php-'.sha1($uri).'-dl.cache';
        $path = $this->_options['cacheDirectory'].'/'.$key;

        if (!file_exists($path) || time() - filemtime($path) > $this->_options['cacheLifeTime']) {

            $client = new Client;
            $fp = fopen($path, 'w+');
            $response = $client->getAsync($uri, [
                'verify' => false,
                'save_to' => $fp
            ])->wait();
            $body = $response->getBody();

            fclose($fp);
        }

        return $bodyAsString ? file_get_contents($path) : fopen($path, 'r');
    }

    public function fetchAccount()
    {

        if (!isset($this->_options['key']))
            throw new Api\Exception(
                "You need to set the \"key\" option to enter account info"
            );

        return $this->fetch('/account');
    }

    public function fetchTokenInfo()
    {

        if (!isset($this->_options['key']))
            throw new Api\Exception(
                "You need to set the \"key\" option to enter token info"
            );

        return $this->fetch('/tokeninfo');
    }

    public function fetchGuild($guildId)
    {

        return $this->fetch('/guild_details.json', ['guild_id' => $guildId], null, 'v1');
    }

    public function fetchBuildId()
    {

        return $this->fetch('/build');
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