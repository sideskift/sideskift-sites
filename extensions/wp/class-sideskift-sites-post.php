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
    private $isProtected        = false;
    /**
     * @var bool
     */
    private $hasAccess          = false;

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
    public function isProtected(): bool
    {
        return $this->isProtected;
    }

    /**
     *
     * @param bool $isProtected
     */
    private function setIsProtected(bool $isProtected): void
    {
        $this->isProtected = $isProtected;
    }

    /**
     * @param bool $isProtected
     */
    public function setIsProtectedFromFilter(bool $isProtected): void
    {
        if ($this->isProtected() == false)
        {
            $this->setIsProtected($isProtected);
        }
    }

    /**
     * @return bool
     */
    public function hasAccessToPost(): bool
    {
        return $this->hasAccess;
    }

    /**
     * @param bool $hasAccess
     */
    private function setHasAccessToPost(bool $hasAccess): void
    {
        $this->hasAccess = $hasAccess;
    }

    /**
     * Method to set the hasAccess parameter from a filter.
     * If a filter has already decided that the user has access, another filter with lower priority is not able to
     * revoke the access
     * @param bool $hasAccess
     */
    public function setHasAccessFromFilter(bool $hasAccess): void
    {
        if ($this->hasAccessToPost() == false)
        {
            $this->setHasAccessToPost($hasAccess);
        }
    }

    /**
     * Returns if the user is a member of the post
     * @return bool
     */
    public function isUserPostMember(): bool
    {
        return $this->isProtected() && $this->hasAccessToPost() && is_user_logged_in();
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
        apply_filters(FilterHook::isPostProtected, $this);

        if ($this->isProtected()) {
            apply_filters(FilterHook::hasAccessToPost, $this);
        } else {
            $this->setHasAccessToPost(true);
        }
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