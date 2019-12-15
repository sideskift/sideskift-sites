<?php
/**
 * Created for public
 * Date     04-12-2019
 * Time     23:35
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */
namespace sideskift_sites\includes;

use sideskift_sites\extensions\wp\Post;

class PostCache
{
    /**
     * @var null
     */
    private static $instance = null;

    /**
     * Array of SideSkift Post objects, key is the Post Id and value is the Post object
     * @var array
     */
    private $cachedPosts = array();

    /**
     * PostCache constructor. Private since postcache is a singleton
     */
    private function __construct()
    {

    }

    /**
     * Returns the cache array
     * @return array
     */
    protected function getCacheArray(): array
    {
        return $this->cachedPosts;
    }

    /**
     * The constructor method to get the singleton instance.
     * @return PostCache|null
     */
    public static function getInstance() {
        if (!self::$instance)
        {
            self::$instance = new PostCache();
        }

        return self::$instance;
    }

    /**
     * Is the postId saved in cache
     * @param int $postId
     * @return bool
     */
    private function isPostIdCached(int $postId) {
        if (array_key_exists($postId, $this->getCacheArray())) {
            return true;
        }

        return false;
    }

    /**
     * @param int $postId
     * @return Post|null
     */
    private function lookupPostId(int $postId) : ?Post {
        if ($this->isPostIdCached($postId)) {
            return $this->getCacheArray()[$postId];
        }

        return null;
    }

    /**
     * Will return a Post object  for a WP_Post object if it exists in cache
     * @param \WP_Post $wp_post
     * @return Post|null
     */
    public function getCachedPost(\WP_Post $wp_post) : ?Post
    {
        if ($this->isPostIdCached($wp_post->ID)) {
            return $this->lookupPostId($wp_post->ID);
        }

        return null;
    }

    /**
     * @param Post $post
     */
    public function cachePost(Post $post) : void {
        if (!empty($post)) {
            $this->getCacheArray()[$post->getWpPost()->ID] = $post;
        }
    }
}