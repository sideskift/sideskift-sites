<?php
/**
 * Created for dev.bidblog.dk.
 * User: henrik
 * Date: 2019-03-30
 * Time: 15:52
 */
namespace sideskift_sites\extensions\plugins\memberpress;

/**
 * Description : Type for SideSkift.dk created membership constants and functions
 */
class Access {
    const tax_MembershipId_slug = "ssdk-membership-ids";

    /**
     * Returns if a user has access according to the adgangsnummer taxonomy
     * @param $postId
     * @return bool
     */
    static function hasMembershipToPostId($postId) {

        $accessIds = \get_the_terms($postId, Access::tax_MembershipId_slug);

        if (is_array($accessIds)){
            foreach ( $accessIds as $accessId ) {
                if (\current_user_can('mepr-active',('membership:' . $accessId->name) )) {
                    return true;
                }
            }
            // If we are here then there is no access.
            return false;
        }

        //And if we are here it means that AccessID are not activated on the post
        return true;
    }
}