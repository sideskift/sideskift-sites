<?php
/**
 * Created for public
 * Date     11-04-2020
 * Time     19:56
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\includes\classes;


use sideskift_sites\extensions\wp\Post;

abstract class MembershipSystem
{
    abstract public function checkAccessToPost(Post $post): ?bool;

    protected function hasAccessToPost(Post $post): bool {
        $checkValue = $this->checkIfPostIsProtected($post);

        if (!is_null($checkValue)) {
            return $checkValue;
        }

        return true;
    }
}