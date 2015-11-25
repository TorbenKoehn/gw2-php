<?php

namespace GuildWars2\Api\Entity\Account;

use GuildWars2\Api\Entity\ItemInfoBase;


class BankItemInfo extends ItemInfoBase
{

    public static function getIndexField()
    {
        //Notice that you can have multiple slots with the same
        //item ID. There is no field "index", so he just appends
        //the item to the entity array.
        return 'index';
    }
}