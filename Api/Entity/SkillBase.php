<?php

namespace GuildWars2\Api\Entity;

use GuildWars2\Api\Entity\SpecializationTrait\Fact\AttributeAdjust;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Buff;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\BuffConversion;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\ComboField;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\ComboFinisher;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Damage;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Distance;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\NoData;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Number;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Percent;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\PrefixedBuff;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\PrefixedBuff\Prefix;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Radius;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Range;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Recharge;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Time;
use GuildWars2\Api\Entity\SpecializationTrait\Fact\Unblockable;
use GuildWars2\Api\Exception;
use GuildWars2\Api\SetEntityBase;

abstract class SkillBase extends SetEntityBase
{

    private $_id;
    private $_name;
    private $_description;
    private $_facts;
    private $_traitedFacts;
    private $_iconUri;

    protected function init()
    {

        $this->_id = null;
        $this->_name = null;
        $this->_description = null;
        $this->_facts = [];
        $this->_traitedFacts = [];
        $this->_iconUri = null;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * @return mixed
     */
    public function getFacts()
    {
        return $this->_facts;
    }

    /**
     * @return mixed
     */
    public function getTraitedFacts()
    {
        return $this->_traitedFacts;
    }

    /**
     * @return mixed
     */
    public function getIconUri()
    {
        return $this->_iconUri;
    }

    protected function set($key, $value)
    {

        switch ($key) {
            case 'id':

                $this->_id = intval($value);
                break;
            case 'name':

                $this->_name = $value;
                break;
            case 'description':

                $this->_description = $value;
                break;
            case 'icon':

                $this->_iconUri = $value;
                break;
            case 'facts':

                foreach ($value as $factInfo) {

                    $this->_facts[] = $this->createFact($factInfo);
                }
                break;
            case 'traited_facts':

                foreach ($value as $factInfo) {

                    $this->_traitedFacts[] = $this->createFact(
                        $factInfo
                    );
                }
                break;
        }
    }

    protected function createFact(array $info)
    {

        $text = isset($info['text']) ? $info['text'] : null;
        $icon = isset($info['icon']) ? $info['icon'] : null;

        $fact = null;
        switch ($info['type']) {
            case 'AttributeAdjust':
                $fact = new AttributeAdjust($text, $icon, $info['value'], $info['target']);
                break;
            case 'Buff':
                $fact = new Buff(
                    $text,
                    $icon,
                    isset($info['duration']) ? $info['duration'] : 0,
                    isset($info['status']) ? $info['status'] : null,
                    isset($info['description']) ? $info['description'] : null,
                    isset($info['apply_count']) ? $info['apply_count'] : 1
                );
                break;
            case 'BuffConversion':
                $fact = new BuffConversion($text, $icon, $info['percent'], $info['source'], $info['target']);
                break;
            case 'ComboField':
                $fact = new ComboField($text, $icon, $info['type']);
                break;
            case 'ComboFinisher':
                $fact = new ComboFinisher($text, $icon, $info['type'], $info['percent']);
                break;
            case 'Damage':
                $fact = new Damage($text, $icon, $info['hit_count']);
                break;
            case 'Distance':
                $fact = new Distance($text, $icon, $info['distance']);
                break;
            case 'NoData':
                $fact = new NoData($text, $icon);
                break;
            case 'Number':
                $fact = new Number($text, $icon, $info['value']);
                break;
            case 'Percent':
                $fact = new Percent($text, $icon, $info['percent']);
                break;
            case 'PrefixedBuff':

                $prefix = new Prefix(
                    $info['prefix']['text'],
                    $info['prefix']['icon'],
                    isset($info['prefix']['status']) ? $info['prefix']['status'] : null,
                    isset($info['prefix']['description']) ? $info['prefix']['description'] : null
                );

                $fact = new PrefixedBuff(
                    $text,
                    $icon,
                    isset($info['duration']) ? $info['duration'] : 0,
                    isset($info['status']) ? $info['status'] : null,
                    isset($info['description']) ? $info['description'] : null,
                    isset($info['apply_count']) ? $info['apply_count'] : 1,
                    $prefix
                );
                break;
            case 'Radius':
                $fact = new Radius($text, $icon, $info['distance']);
                break;
            case 'Range':
                $fact = new Range($text, $icon, $info['value']);
                break;
            case 'Recharge':
                $fact = new Recharge($text, $icon, $info['value']);
                break;
            case 'Time':
                $fact = new Time($text, $icon, $info['duration']);
                break;
            case 'Unblockable':
                $fact = new Unblockable($text, $icon, $info['value']);
                break;
        }

        if (!$fact)
            throw new Exception(
                "Failed to create buff fact: Invalid type {$info['type']} encountered"
            );

        if (isset($info['requires_trait'])) {

            $fact->setRequiredTraitId(intval($info['requires_trait']));

            if (isset($info['overrides'])) {

                $fact->setOverriddenIndex(intval($info['overrides']));
            }
        }

        return $fact;
    }
}