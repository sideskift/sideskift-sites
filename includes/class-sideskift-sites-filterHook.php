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
class FilterHook
{
    const isPostMembershipProtected = 'dk_sideskift_isPostMembershipProtected';
    const hasMembershipAccessToPost = 'dk_sideskift_hasMembershipAccessToPost';
    const isPostFree                = 'dk_sideskift_isPostFree';
}