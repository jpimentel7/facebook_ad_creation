<?php

use FacebookAds\Object\Ad;
use FacebookAds\Object\AdCreative;
use FacebookAds\Object\AdCreativeLinkData;
use FacebookAds\Object\AdCreativeObjectStorySpec;
use FacebookAds\Object\AdImage;
use FacebookAds\Object\Fields\AdCreativeFields;
use FacebookAds\Object\Fields\AdCreativeLinkDataFields;
use FacebookAds\Object\Fields\AdCreativeObjectStorySpecFields;
use FacebookAds\Object\Fields\AdFields;
use FacebookAds\Object\Fields\AdImageFields;
use FacebookAds\Object\Values\AdCreativeCallToActionTypeValues;

require 'vendor/autoload.php';
require 'FacebookSettings.php';

class FacebookAdCreation
{
    public static function main()
    {
        $settings = new FacebookSettings();
        $clickUrl = 'https://softwareandwebstuff.com';
        $imageFileLocation = '';
        $adSetId = '';

        /**
         * Step 1 Uploading the Image
         */
        $image = new AdImage(null, $settings->getDefaultAdAccount());
        $image->{AdImageFields::FILENAME} = $imageFileLocation;
        $image->create();
        $imageHash = $image->{AdImageFields::HASH};


        /**
         * Step 2 Creating the Ad Creative
         */
        $link_data = new AdCreativeLinkData();
        $link_data->setData(array(
            AdCreativeLinkDataFields::NAME => 'test ad creative',
            AdCreativeLinkDataFields::LINK => $clickUrl,
            AdCreativeLinkDataFields::IMAGE_HASH => $imageHash,
            AdCreativeLinkDataFields::CALL_TO_ACTION => array(
                'type' => AdCreativeCallToActionTypeValues::NO_BUTTON,
            ),
        ));

        $story = new AdCreativeObjectStorySpec();
        $story->setData([
            AdCreativeObjectStorySpecFields::PAGE_ID => $settings->getPageId(),
            AdCreativeObjectStorySpecFields::LINK_DATA => $link_data,
        ]);

        $creative = new AdCreative(null, $settings->getDefaultAdAccount());
        $creative->setData([
            AdCreativeFields::OBJECT_STORY_SPEC => $story,
        ]);

        $creative->create();
        $creativeId = $creative->{AdCreativeFields::ID};


        /**
         * Step 3 Putting it All Together
         */
        $ad = new Ad(null, $settings->getDefaultAdAccount());
        $ad->setData(array(
            AdFields::CREATIVE => [
                'creative_id' => $creativeId
            ],
            AdFields::NAME => 'First Ad',
            AdFields::ADSET_ID => $adSetId,
            AdFields::STATUS => Ad::STATUS_ACTIVE,
        ));

        $ad->create();
    }


}

FacebookAdCreation::main();