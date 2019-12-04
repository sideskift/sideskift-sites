<?php
/**
 * Created for public
 * Date     04-12-2019
 * Time     23:35
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

class Sideskift_Sites_Post_Factory
{
    private static $instance = null;

    private $currentPosts = array();

    private function __construct()
    {

    }

    /**
     * @return array
     */
    protected function getCurrentPosts(): array
    {
        return $this->currentPosts;
    }

    private static function getInstance() {
        if (!self::$instance)
        {
            self::$instance = new Sideskift_Sites_Post_Factory();
        }

        return self::$instance;
    }

    public static function getPostFromId(int $postId) : \sideskift_sites\extensions\wp\Post
    {
        /*
        if (!empty(self::getInstance()->currentPosts()[$postId])) {
            return self::getInstance()->current
        }

        */
    }
}