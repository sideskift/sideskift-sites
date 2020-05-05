<?php
/**
 * Created for public
 * Date     11-04-2020
 * Time     19:58
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\includes\classes;


use sideskift_sites\extensions\wp\Post;

class MembershipSystemWishList extends MembershipSystem
{

    /**
     * @param Post $post
     * @return bool|null
     */
    public function checkAccessToPost(Post $post): ?bool
    {
        if (function_exists('member_can_access')) {

            if (is_user_logged_in()) {
                if (wlmapi_member_can_access(get_current_user_id(),
                                             $post->getWpPost()->post_type,
                                             $post->getWpPost()->ID)) {
                    return true;
                }
                else {
                    return false;
                }
            }
            /*
             * Skal man have adgang hvis ikke man er logget ind?
            else {
                return false;
            }
            */
        }

        return null;
    }
}