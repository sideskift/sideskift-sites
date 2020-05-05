# Access / membership features.
The plugin includes features that can be used to validate content and test for access to content in code or shortcuts.  

There are basically two questions that needs to be asked when it comes to testing for access.  

1. Is the content protected
2. Does the user has access to see the content. 

Because content can be controlled by various membership or protection plugins, two filters has been created which code
can hook into.

These filters must react on a post, so to incapsulate the needed data for tests, a new class has been defined.

## The Sideskift Post class
**FilePath:** /extensions/wp/class-sideskift-sites-post.php

This class encapsulates a wordpress WP-Post object. The constructor take this WP-Post object as its parameter. And
during initialization, filters are applied to test if the user has access to the 

## The Defined filters
All Defined filters are declared in the /includes/clas-sideskift-sites-filterHook.php file as string constants. 

### Filter to test if content is protected
The sideskiftdk/Post class constructor will call this filter to test if a post is protected.

#### isPostMembershipProtected
Ths isPostMembershipProtected shold 

## Filter to test if user has access to the content

## Conditional shortcode structure

[dk_sideskift_condition name="classname"]