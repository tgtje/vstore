<?php

/**
 * e107 website system
 *
 * Copyright (C) 2008-2016 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 */

e107::lan('vstore',true, true);

class vstore_cron       // plugin-folder name + '_cron'.
{
    function config() // Setup
    {
        $cron = array();

        $cron[] = array(
            'name'            => "Vstore - Purge cart",  // Displayed in admin area. .
            'function'        => "purgeCart",    // Name of the function which is defined below.
            'category'        => 'content',           // Choose between: mail, user, content, notify, or backup
            'description'     => LAN_VSTORE_ADMIN_090  // Displayed in admin area.
        );

        return $cron;
    }

    public function purgeCart()
    {
        // Check if the cart table has already the field 'cart_lastupdate'
        if (!e107::getDb()->field('vstore_cart', 'cart_lastupdate'))
        {
            return;
        }
        // create date
        $date = date('Y-m-d H:i:s', mktime(0,0,0, date('m'), date('d') - 2, date('Y')));
        e107::getDb()->delete('vstore_cart', 'cart_lastupdate <= ' . $date);
    }

}