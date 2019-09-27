<?php
/**
 * Created for SideSkift.dk
 * Date     26-06-2019
 * Time     17:20
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\includes;

/**
 * Class ShortCode
 * @package sideskift_sites\includes
 * @desc    Basic shortcode class used for all sideskift shortcodes.
 */
class ShortCode
{
    protected $attributes   = array();
    protected $content      = "";

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     */
    public function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }


    public function __construct(array $atts = [], $content = null) {

        $defaultAttributes = $this->getDefaultAttributes();

        if (!empty($defaultAttributes)) {
            $this->setAttributes(shortcode_atts( $defaultAttributes, $atts));
        } else if (!empty($atts)) {
            $this->setAttributes($atts);
        }

        if (!empty($content)) {
            $this->setContent($content);
        }
    }

    /**
     * @desc   Function that returns an array of default values for the shortcode if any. The purpose is to use it with the shortcode_atts function
     * @return array
     */
    protected function getDefaultAttributes() {
        return Array();
    }

    public function render() {
        return '';
    }
}


class ConditionShortCode extends ShortCode {

    /**
     * @return string
     */
    public function getName()
    {
        return $this->getAttributes()['name'];
    }

    /**
     * @return string
     */
    public function getNamespace()
    {
        $nameSpace = $this->getAttributes()['namespace'];

        if (!empty($nameSpace)) {
            if (substr($nameSpace) !=  '\\') {
                $nameSpace .= '\\';
            }
        }

        return $nameSpace;
    }

    /**
     * @desc   Return a subclass name
     * @return string
     */
    protected function getConditionClassName() {

        return $this->getNamespace() . $this->getName();

    }

    /**
     * @return string
     */
    protected function getTrueValue()
    {
        return $this->getAttributes()['true'];
    }

    /**
     * @return string
     */
    protected function getFalseValue()
    {
        return $this->getAttributes()['false'];
    }

    /**
     * @return string
     */
    private function getDebugValue()
    {
        return $this->getAttributes()['debug'];
    }

    public function isDebug() {
        if ($this->getDebugValue() != '') {
            return true;
        }

        return false;
    }



    protected function getDefaultAttributes()
    {
        return  array(
            'name' => '',
            'namespace' => '',
            'true' => 'true',
            'false' => 'false',
            'debug' => ''
            );
    }

    protected function testCondition()
    {
        return true;
    }

    public function render()
    {
        /*
        if ($this->isDebug()) {
            //todo: oversættelse..
            return "Condition Name Does Not Exist: " . $this->getConditionName();
        }
        */

        if ($this->testCondition())
        {
            return $this->getTrueValue();
        }

        return $this->getFalseValue();
    }

    /**
     * @desc  Common creator for a condition shortcode attributes array is a key value with
     *
     * name         = classname
     * namespace    = namespace for class
     * true         = value to return if condition is true
     * false        = value to return if condition is false
     * debug        = if any value then debug the shortcode. Not implemented yet.
     *
     * @param array $atts
     * @param null $content
     * @return string
     */
    static function newConditionShortCode(array $atts, $content = null) {

        $shortCode = new ConditionShortCode($atts, $content);

        // Test if its a specific subclass
        $classname = $shortCode->getConditionClassName();

        $reflection = new \ReflectionClass($classname);

        if ($reflection->isSubclassOf(__CLASS__)) {
            $shortCode = new $classname($atts, $content);
        }

        return $shortCode->render();
    }
}