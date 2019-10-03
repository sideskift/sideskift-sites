<?php
/**
 * Created for public
 * Date     29-09-2019
 * Time     17:26
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\extensions\wp;
use sideskift_sites\includes\FilterTag;

class Post
{

    /**
     * @var \WP_Post $wp_post
     */
    private $wp_post;

    private $isProtected = false;
    private $hasAccess   = false;

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

    public function setHasAccessFromFilter(bool $hasAccess): void
    {
        if ($this->hasAccessToPost() == false)
        {
            $this->setHasAccessToPost($hasAccess);
        }
    }

    /**
     * Post constructor.
     * @param \WP_Post $wp_post
     */
    public function __construct(\WP_Post $wp_post)
    {
        $this->wp_post = $wp_post;

        $this->testAccess();
    }

    public function testAccess(): void
    {
        // Test if the post is protected.
        apply_filters(FilterTag::isPostProtected(), $this);

        if ($this->isProtected()) {
            apply_filters(FilterTag::hasAccessToPost(), $this);
        } else {
            $this->setHasAccessToPost(true);
        }
    }
}