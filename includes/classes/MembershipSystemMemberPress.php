<?php
/**
 * Created for public
 * Date     11-04-2020
 * Time     19:57
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\includes\classes;


use sideskift_sites\extensions\wp\Post;

class MembershipSystemMemberPress extends MembershipSystem
{
    public function checkAccessToPost(Post $post): ?bool
    {
        if (method_exists('MeprRule', 'is_locked')) {
            if (MeprRule::is_locked($post->getWpPost())) {
                return false;
            }
            else {
                return true;
            }
        }

        return null;
    }
}