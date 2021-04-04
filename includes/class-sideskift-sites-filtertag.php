<?php
/**
 * Created for public
 * Date     24-09-2019
 * Time     22:12
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\includes;


/**
 * Class FilterTags. Returns the tags used in filters used in the plugin
 * @package sideskift_sites\includes
 */
class FilterTag
{
    static function isPostProtected() {
        return 'dk_sideskift_isPostProtected';
    }

    static function hasAccessToPost() {
        return 'dk_sideskift_hasAccessToPost';
    }
}