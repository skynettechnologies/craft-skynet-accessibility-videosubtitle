<?php

namespace skynettechnologies\craftskynetaccessibilityvideosubtitle\assetbundles;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

class AdminSettingsAsset extends AssetBundle
{
    public function init()
    {
        // Set the path where your resources are located
        $this->sourcePath = "@skynettechnologies/craftskynetaccessibilityvideosubtitle/resources";

        // Define the CSS files to be included   
        $this->css = [
            'css/bootstrap.min.css',
            'css/style.css',
        ];
        // JS files
        $this->js = [
            'js/videosubtitle.js',
        ];

        // Define the dependencies
        $this->depends = [
            CpAsset::class, // Ensures Craft's Control Panel styles and scripts are loaded
        ];

        parent::init();
    }
}
