#Plugin Shortcodes
This document describes the shortcodes that the plugin provides, and how to use them in your site.

##dk_sideskift_condition
This shortcode can be used in elementor together with the **DynamicConditions** plugin:



###Examples of usage of dk_sideskift_condition
//TODO: Dokumenter eksempel for brug af denne shortcode klasse. 

##dk_sideskift_do_shortcode
//TODO: Skal beskrives når den er kodet..

Bemærk at du kan ikke bare smide en shortcode i parameteren fordi Toolset og Wordpress ændrer på strengen for at finde ud af hvad der står i argumentet.

Derfor skal der laves en løsning hvor du i attributter skriver Tag og Content

shortcode-tag="fisk"
shortcode-content="ACCESS"

Og så skal funktionen selv pille det fra og bygge shortcode strengen ud fra indholdet og afvikle den...