<?php
/**
 * Created for SideSkift.dk
 * Date     26-06-2019
 * Time     17:20
 * @package Sideskift_Sites
 * @author  Henrik Gregersen <henrik@sideskift>
 */

namespace sideskift_sites\includes;

use sideskift_sites\extensions\wp\Post;

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

/**
 * Class ConditionShortCode
 * @package sideskift_sites\includes
 */
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
            if (substr($nameSpace,-1) !=  '\\') {
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

        if (class_exists($classname)) {
            $reflection = new \ReflectionClass($classname);

            if ($reflection->isSubclassOf(__CLASS__)) {
                $shortCode = new $classname($atts, $content);
            }
        }

        return $shortCode->render();
    }
}

/**
 * Class ShortCodeExecuter
 * @package sideskift_sites\includes
 * @desc    This shortcode takse a shortcode string as arguments, and executes the shortcode and returns it, Why is this needed? It is needed in toolset conditions where you want to build a condition based upon the output of a shortcode.
 */
class ShortCodeExecuter extends ShortCode {
//TODO: Virker ikke efter hensigten hvor jeg angiver shortcoden som argument i en toolset conditionall

/*
 * Fra Shortcodes.md
 *  Bemærk at du kan ikke bare smide en shortcode i parameteren fordi Toolset og Wordpress ændrer på strengen for at finde ud af hvad der står i argumentet.

Derfor skal der laves en løsning hvor du i attributter skriver Tag og Content

shortcode-tag="fisk"
shortcode-content="ACCESS"

Og så skal funktionen selv pille det fra og bygge shortcode strengen ud fra indholdet og afvikle den...

Du kan registrere do_shortcode som en custom function i toolset, og skrive chortcode strengen i parameteren og det vil virke som jeg egentlig har kodet her, bortset fra at der ikke er cache på det

 */


    /**
     * @var string - the shortcode that should be rendered to an output
     */
    protected $shortCodeText = '';

    /**
     * @var Post - Initialized current Post object
     */
    private $currentPost = null;

    /**
     * @return string
     */
    public function getShortCodeText(): string
    {
        return $this->shortCodeText;
    }

    /**
     * @param string $shortCodeText
     */
    public function setShortCodeText(string $shortCodeText): void
    {
        $this->shortCodeText = $shortCodeText;
    }

    protected function setShortCodeFromAttributes(array $atts) {
        // The Array is expected to only hold one element which is the shortcode string.
        if (!empty($atts[1])) {
            $this->setShortCodeText($atts[1]);
        }
    }

    /**
     * @desc Check if a shortcode value is cached in the Post object.
     * @return bool
     */
    private function cachedValueExists() : bool {
        if ($this->currentPost != null) {
            if ($this->currentPost->getCachedShortCode($this->shortCodeText) != null) {
                return true;
            }
        }

        return false;
    }

    private function getCachedValue() {
        if ($this->currentPost != null) {
            if ($this->currentPost->getCachedShortCode($this->shortCodeText) != null) {
                return $this->currentPost->getCachedShortCode($this->shortCodeText);
            }
        }

        return '';
    }

    private function saveCachedValue(string $cachedValue) {
        if ($this->currentPost != null) {
            $this->currentPost->saveShortCodeCacheValue($this->getShortCodeText(), $cachedValue);
        }
    }

    public function render()
    {
        $isCached = $this->cachedValueExists();

        if ($isCached) {
            return $this->getCachedValue();
        }

        $renderedValue = do_shortcode($this->getShortCodeText());

        $this->saveCachedValue($renderedValue);

        return $renderedValue;
    }

    public function __construct(array $atts = [], $content = null)
    {
        parent::__construct($atts, $content);

        //Initialize the current post
        $this->currentPost = Post::getCurrentExtendedPost();
    }

    static function doShortCode(array $atts, $content = null): string {

        $shortCodeExec = new ShortCodeExecuter($atts, $content);

        //Get the shortcodes from the arguments
        $shortCodeExec->setShortCodeFromAttributes($atts);

        return $shortCodeExec->render();
    }
}
