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
    const fieldOutput_raw = Array('output' => 'raw');

    /**
     * @description Returns the value of a custom field, for the current post
     * @param string $fieldSlug
     * @return mixed|string
     */
    static function GetFieldString(string $fieldSlug) {

        return Types::GetFieldOutput($fieldSlug);
    }

    /**
     * Gets the time value of a toolset date field. Using the toolset ouput function if possible.
     * @param $fieldSlug
     * @return int
     */
    static function GetFieldDateTime($fieldSlug) : int {

        $output = Types::GetFieldOutput($fieldSlug, Types::fieldOutput_raw);

        if (is_numeric($output)) {
            return intval($output);
        }

        return 0;
    }

    /**
     * @description Returns the post_meta value as an integer, if possible if not possible then 0 is returned
     * @param string $fieldSlug
     * @param string $toolsetPrefix
     * @return int
     */
    static function getPostFieldInt(string $fieldSlug, string $toolsetPrefix = Types::field_prefix) {

        $value = Types::getPostFieldValue($fieldSlug, $toolsetPrefix);

        if (is_numeric($value)) {
            return intval($value);
        }

        return 0;
    }

    // ------------------------------------ Private below ----------------------------------------------------------

    /**
     * Gets the output of a toolset Field.
     * @param string $fieldSlug
     * @param array $outputParam
     * @param Int|null $forPostId
     * @return mixed|string
     */
    private static function GetFieldOutput(string $fieldSlug, $outputParam = Array(), Int $forPostId = null) {

        $fieldString = '';

        $post_Id = $forPostId;
        if (is_null($post_Id)) {
            $post_Id = \get_the_ID();
        }

        if (!empty($post_Id) && strlen($fieldSlug) > 0) {

            if (function_exists('types_render_field')) {
                $fieldString = \types_render_field($fieldSlug, $outputParam);
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
    private static function getPostFieldValue(string $fieldSlug, string $toolsetPrefix = Types::field_prefix, bool $singleValue = true) {
        $toolsetFieldSlug = $toolsetPrefix . $fieldSlug;
        $postId = \get_the_ID();

        if (!empty($postId) && strlen($toolsetFieldSlug) > 0) {
            return \get_post_meta($postId, $toolsetFieldSlug, $singleValue);
        }

        return "";
    }
}
