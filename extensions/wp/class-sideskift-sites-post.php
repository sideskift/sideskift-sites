<?php
/**
 * Created for public
 * Date     29-09-2019
 * Time     17:26
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\extensions\wp;
use sideskift_sites\includes\FilterHook;
use sideskift_sites\includes\PostCache;

class Post
{

    /**
     * @var \WP_Post $wp_post
     */
    private $wp_post;

    /**
     * @var bool
     */
    private $isMembershipProtected  = false;
    /**
     * @var bool
     */
    private $hasMembershipAccess    = false;

    private $isPostFree             = true;

    /**
     * @return \WP_Post
     */
    public function getWpPost(): \WP_Post
    {
        return $this->wp_post;
    }

    /**
     * @return bool
     */
    public function isMembershipProtected(): bool
    {
        return $this->isMembershipProtected;
    }

    /**
     *
     * @param bool $isMembershipProtected
     */
    private function setIsMembershipProtected(bool $isMembershipProtected): void
    {
        $this->isMembershipProtected = $isMembershipProtected;
    }

    /**
     * @param bool $isMembershipProtected
     */
    public function setIsMembershipProtectedFromFilter(bool $isMembershipProtected): void
    {
        if ($this->isMembershipProtected() == false)
        {
            $this->setIsMembershipProtected($isMembershipProtected);
        }
    }

    /**
     * @return bool
     */
    public function hasMembershipAccessToPost(): bool
    {
        return $this->hasMembershipAccess;
    }

    /**
     * @param bool $hasMembershipAccess
     */
    private function setHasMembershipAccessToPost(bool $hasMembershipAccess): void
    {
        $this->hasMembershipAccess = $hasMembershipAccess;
    }

    /**
     * Method to set the hasAccess parameter from a filter.
     * If a filter has already decided that the user has access, another filter with lower priority is not able to
     * revoke the access
     * @param bool $hasMembershipAccess
     */
    public function setHasMembershipAccessFromFilter(bool $hasMembershipAccess): void
    {
        if ($this->hasMembershipAccessToPost() == false)
        {
            $this->setHasMembershipAccessToPost($hasMembershipAccess);
        }
    }

    /**
     * @return bool
     */
    public function isPostFree(): bool
    {
        return $this->isPostFree;
    }

    /**
     *
     * @param bool $isPostFree
     */
    private function setIsPostFree(bool $isPostFree): void
    {
        $this->isPostFree = $isPostFree;
    }

    /**
     * @param bool $isPostFree
     */
    public function setIsPostFreeFromFilter(bool $isPostFree): void
    {
        // Because a filter may revoke or give free access and a post is considered free as default
        // Unless it is membership protected. All releventfilters are able to set this true or false.
        $this->setIsPostFree($isPostFree);
    }


    /**
     * Returns if the user is a member of the post
     * @return bool
     */
    public function isUserPostMember(): bool
    {
        return $this->isMembershipProtected() && $this->hasMembershipAccessToPost() && is_user_logged_in();
    }

    /**
     * Post constructor. Is protected to make sure that instance creation is always cached.
     * @param \WP_Post $wp_post
     */
    protected function __construct(\WP_Post $wp_post)
    {
        $this->wp_post = $wp_post;

        $this->testAccess();
    }

    /**
     * Test if the post is protected and if the user has access to the post, using filters
     */
    public function testAccess(): void
    {
        // Test if the post is protected.
        apply_filters(FilterHook::isPostMembershipProtected, $this);

        if ($this->isMembershipProtected()) {
            apply_filters(FilterHook::hasMembershipAccessToPost, $this);

            // Consider the post to not be free, before applying filters
            $this->setIsPostFree(false);

        } else {
            $this->setHasMembershipAccessToPost(true);
        }

        apply_filters(FilterHook::isPostFree, $this);
    }

    /**
     * @param \WP_Post $wpPost
     * @return Post
     */
    public static function getExtendedPost(\WP_Post $wpPost) : Post {

        $post = PostCache::getInstance()->getCachedPost($wpPost);

        if (!empty($post)) {
            return $post;
        }

        $post = new Post($wpPost);
        PostCache::getInstance()->cachePost($post);

        return $post;
    }
}