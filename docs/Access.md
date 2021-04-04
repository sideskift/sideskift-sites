# Access / membership features.
The plugin includes features that can be used to validate content and test for access to content in code or shortcuts.  

There are basically two questions that needs to be asked when it comes to testing for access.  

1. Is the content protected
2. Does the user has access to see the content. 

Because content can be controlled by various membership or protection plugins, two filters has been created which code
can hook into.

These filters must react on a post, so to incapsulate data needed for the test a new class has been defined.

## The Sideskift Post class

## Filter to test if content is protected

## Filter to test if user has access to the content

## Conditional shortcode structure

[dk_sideskift_condition name="classname"]