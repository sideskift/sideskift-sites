<?php
/**
 * Created for dev.bidblog.dk.
 * User: henrik
 * Date: 2019-03-02
 * Time: 20:25
 */
namespace sideskift_sites\extensions\plugins\toolset;

class Types {

    const field_prefix = "wpcf-";

    static function hello() {
        echo "Hello";
    }

    /**
     * @description Returns the value of a custom field, for the current post
     * @param string $fieldSlug
     * @return mixed|string
     */
    static function GetFieldString(string $fieldSlug) {

        return Types::GetFieldOutput($fieldSlug);

    }

    //TODO: Make sure there is a single point of contact to the types functions in case toolset decides to change their code
    /*
    static function GetFieldDateTimeStamp($fieldSlug) {
        Types::GetFieldRawOutput();
    }
    */

    /***
     * Single point calling Types field render, incase they change this function.
     * @param string $fieldSlug
     * @param bool $useRaw - Types parameter option
     * @return mixed|string
     */
    private static function GetFieldOutput(string $fieldSlug, bool $useRaw = false) {

        $fieldString = '';
        $post_Id     = \get_the_ID();

        if (!empty($post_Id) && strlen($fieldSlug) > 0) {

            if (function_exists('types_render_field')) {

                $parameters = Array();

                if ($useRaw) {
                    $parameters = Array("output => raw");
                }

                $fieldString = \types_render_field($fieldSlug, $parameters);
            } else {
                $fieldString = Types::getPostFieldValue($fieldSlug);
            }

        }

        return $fieldString;
    }

    /**
     * @description Returns the post_meta value as a string
     * @param string $fieldSlug
     * @param string $toolsetPrefix
     * @param bool $singleValue - Set to false if the field value is an array
     * @return mixed|string
     */
    static function getPostFieldValue(string $fieldSlug, string $toolsetPrefix = Types::field_prefix, bool $singleValue = true) {
        $toolsetFieldSlug = $toolsetPrefix . $fieldSlug;
        $postId = \get_the_ID();

        if (!empty($postId) && strlen($toolsetFieldSlug) > 0) {
            return \get_post_meta($postId, $toolsetFieldSlug, $singleValue);
        }

        return "";
    }

    /**
     * @description Returns the post_meta value as an integer usefull for date fields
     * @param string $fieldSlug
     * @param string $toolsetPrefix
     * @return int
     */
    static function getPostFieldInt(string $fieldSlug, string $toolsetPrefix = Types::field_prefix) {
        return intval(Types::getPostFieldValue($fieldSlug, $toolsetPrefix));
    }
}
