<?php
/**
 * Created by PhpStorm.
 * User: moeloubani
 * Date: 2014-06-10
 * Time: 5:13 AM
 */

namespace wptrebrets\inc;


class Update extends Save {

    protected $post;
    protected $photos;
    protected $mls;

    function __construct($mls, $id, $photos)
    {
        $this->mls = $mls;
        $this->id = $id;
        $this->photos = $photos;
    }


    public function photos(Array $photos)
    {
        //check if photos were updated

        //get current photos list

        //get new photos list

        //loop through and check if sizes match, if not delete old one and download new one to same name as old one

    }

    public function posts(Array $post)
    {

        //get post data
        $property_formatted = array();

        //reassign fields to ones that look good

        $property_formatted['price'] = $property['Lp_dol'];
        $property_formatted['mls'] = $property['Ml_num'];
        $property_formatted['address'] = $property['Addr'];
        $property_formatted['bathrooms'] = $property['Bath_tot'];
        $property_formatted['bedrooms'] = $property['Br'];
        $property_formatted['province'] = $property['County'];
        $property_formatted['broker'] = $property['Rltr'];
        $property_formatted['rooms'] = $property['Rms'];
        $property_formatted['rentorsale'] = $property['S_r'];
        $property_formatted['status'] = $property['Status'];
        $property_formatted['postal_code'] = $property['Zip'];
        $property_formatted['city'] = $property['Area'];
        $property_formatted['last_updated_text'] = $property['Timestamp_sql'];
        $property_formatted['last_updated_photos'] = $property['Pix_updt'];
        $property_formatted['description'] = $property['Ad_text'];

        //set up arguments before entering post to wp
        $post_args = array(
            'post_content' => $property_formatted['description'],
            'post_status' => 'publish',
            'post_type' => 'wptrebs_property',
            'post_id' => $this->id
        );

        //insert post and return new post id
        $posted_property = wp_insert_post($post_args);

        //add post meta using the new post id and good looking array
        foreach ($property_formatted as $key => $value) {
            if (!empty($value)) {
                add_post_meta($this->id, $key, $value, true) || update_post_meta($this->id, $key, $value);
            }
        }

        //update photos
        self::photos($this->photos);

    }

} 