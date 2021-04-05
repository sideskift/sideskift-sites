#Extensions
The extension folder in the plugin includes extensions of various other plugins as well as core wordpress objects and features.

In most situations the types are wrappers of other objects, since extensions (not OOP inheritance) is not possible in php 7.4 and 8.0

So in order to be able to add functionality to objects that are declared final, wrapper types and functions are included in this folder to be able to extend the functionality of core and plugins.

##wp/class-sideskift-sites-post.php
This file includes a wrapper for the Wp-post object, so features that functions and types in the sideskift-sites plugin depends on added to this object.

So it is always possible to get the the post object from the sideskift_sites\extensions\wp\Post object

###How to instantiate the Post object

You create an instance of the extended Post object by calling the static getExtendedPost method with an instance of the Wp-post object

**Be aware of the name space**

```php
\sideskift_sites\extensions\wp\Post::getExtendedPost(get_post())
``
