<?php
/**
 * Created for public
 * Date     22-09-2019
 * Time     18:32
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\includes;


class Filter
{
    /**
     * Stub for dk_sideskift_isPostProtected filter that takes a string of either 'true' or 'false' and a postId as a second parameter.
     * If a feature is implemented that needs to test if a specific post is protected this filter should be implemented
     * This filter may be applied in filters like hasAccessToPost to test if the post should be controlled for access
     * @param string $trueFalseString
     * @param \WP_Post $wp_post
     * @return string
     */
    static function isPostProtected($trueFalseString, $wp_post) {

        // Start your implementation by testing if the filter should be performed.
        if (Filter::unresolvedFilter($trueFalseString)) {
            // Perform filter and return the value
            return $trueFalseString;
        }

        // Another filter has already resolved that the post is protected so simply return the value
        return $trueFalseString;
    }

    /**
     * Stub for dk_sideskift_hasAccessToPost filter that validates if a user has access to a postId. This
     * @param string $trueFalseString
     * @param \WP_Post $wp_post
     * @return string
     */
    static function hasAccessToPost($trueFalseString, $wp_post) {

        // Start your implementation by testing if the filter should be performed.
        if (Filter::unresolvedFilter($trueFalseString)) {
            // Perform checks to see if the user has access to the post and apply the
            return $trueFalseString;
        }

        // Another filter has already resolved that the current user has access so simply return the value.
        return $trueFalseString;
    }

    /**
     * Function that calls a boolean filter, where the filter is a string of value 'true' or 'false'
     * This is a way to create an event that can extend checks if a user has access to a post etc
     * The filterTag is the name of the filter, the filterArguments are additional arguments to the WordPress filter
     * @param string $filterTag
     * @param bool $initialValue
     * @param mixed ...$filterArguments
     * @return bool
     */
    static function applyBoolFilter(string $filterTag, bool $initialValue = false, ...$filterArguments) {

        $boolValue = $initialValue;
        $boolString = $initialValue ? Filter::trueString() : Filter::falseString();

        $filterArgs = array();
        $filterArgs[] = $filterTag;
        $filterArgs[] = &$boolString;

        if (!empty($filterArguments)) {
            foreach($filterArguments as &$argument) {
                $filterArgs[] = &$argument;
            }
        }

        call_user_func_array('apply_filters', $filterArgs);

        $boolValue = $boolString == Filter::trueString() ? true : false;

        return $boolValue;
    }

    /**
     * Determines if the value of the filter is unresolved and still needs to be handled
     * @param string $trueFalseString
     * @return bool
     */
    static function unresolvedFilter(string $trueFalseString) {
        if ($trueFalseString == Filter::trueString()) {
            return true;
        }

        return false;
    }

    /**
     * Constant for a value that represents a boolean true
     * @return string
     */
    static function trueString() {
        return 'true';
    }

    /**
     * Constant for a value that represents a boolean false
     * @return string
     */
    static function falseString() {
        return 'false';
    }
}