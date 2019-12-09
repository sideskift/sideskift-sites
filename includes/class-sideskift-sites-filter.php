<?php
/**
 * Created for public
 * Date     22-09-2019
 * Time     18:32
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\includes;

use sideskift_sites\extensions\wp\Post;

class Filter
{
    /**
     * Stub for dk_sideskift_isPostMembershipProtected filter that takes an instance of \sideskift_sites\extensions\wp\Post.
     * This filter is called by the constructor of the \sideskift_sites\extensions\wp\Post class.
     * Effectivly
     * @param \sideskift_sites\extensions\wp\Post $post
     * @return \sideskift_sites\extensions\wp\Post
     */
    static function isPostMembershipProtected($post) {

        // Determine if the given post is protected by a membership or other system and then set the boolean value
        // on the post object passed as parameter

        // This is a stub method so we simple set the existing value as it is
        $post->setIsMembershipProtectedFromFilter($post->isMembershipProtected());

        return $post;
    }

    /**
     * Stub for dk_sideskift_hasMembershipAccessToPost filter that validates if a user has access to a postId. This
     * @param \sideskift_sites\extensions\wp\Post $post
     * @return \sideskift_sites\extensions\wp\Post
     */
    static function hasMembershipAccessToPost($post) {

        // Determine if the user has access to the post, or not and then try to set the access bool value on the
        // post object. Please not that another filter may have given access and if so, this overrules a false
        // value, on the object.

        // This is a stub method so we simple set the existing value as it is
        $post->setHasMembershipAccessFromFilter($post->hasMembershipAccessToPost());

        return $post;
    }

    /**
     * Stub for dk_sideskift_isPostFree filter that validates if a given post may allow free access.
     * @param \sideskift_sites\extensions\wp\Post $post
     * @return \sideskift_sites\extensions\wp\Post
     */
    static function isPostFree($post) {

        // Determine if the something on this post may allow free access, or not and then try to set the isPostFree bool value on the
        // post object. Please not that another filter may enable or disable free access depending upon
        // filter priority.

        // This is a stub method so we simple set the existing value as it is
        $post->setIsPostFreeFromFilter($post->isPostFree());

        return $post;
    }
}