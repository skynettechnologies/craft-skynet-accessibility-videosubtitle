<?php

namespace skynettechnologies\craftskynetaccessibilityvideosubtitle;

use Craft;
use craft\base\Plugin;
use craft\base\Model;
use craft\web\View;
use craft\helpers\UrlHelper;
use yii\base\Event;

use skynettechnologies\craftskynetaccessibilityvideosubtitle\models\Settings;

class CraftSkynetAccessibilityvideosubtitle extends Plugin
{
    public static $plugin;

    public string $schemaVersion = '2.0.0';

    public bool $hasCpSettings = true;

    public bool $hasCpSection = false;

    public function init(): void
    {
        parent::init();

        self::$plugin = $this;

        /*
         * Frontend only
         */
        Event::on(
            View::class,
            View::EVENT_END_BODY,
            function () {
                if (Craft::$app->getRequest()->getIsSiteRequest()) {

                    Craft::$app->getView()->registerJs(
                        'console.log("SkynetAccessibility Video Subtitle");',
                        View::POS_END
                    );
                     // Video Subtitle Widget
                    Craft::$app->getView()->registerJsFile(
                        'https://www.skynettechnologies.com/accessibility/js/video-subtitle/video-subtitle-widget.js',
                        [
                            'id' => 'aioa-adavs',
                            'defer' => true,
                            'position' => View::POS_END,
                        ]
                    );
                }
            }
        );
    }

    /**
     * Register API only after plugin installation
     */
    public function afterInstall(): void
    {
        parent::afterInstall();

        $this->registerDomainApi();
    }

    /**
     * Settings model
     */
    protected function createSettingsModel(): ?Model
    {
        return new Settings();
    }

    /**
     * Plugin settings page
     */
    protected function settingsHtml(): ?string
    {
        \skynettechnologies\craftskynetaccessibilityvideosubtitle\assetbundles\AdminSettingsAsset::register(
            Craft::$app->getView()
        );

        $phpFile = __DIR__ . '/templates/videosubtitlesetting.php';

        if (file_exists($phpFile)) {

            ob_start();

            include $phpFile;

            $output = ob_get_clean();

            return Craft::$app->view->renderTemplate(
                'craft-skynet-accessibility-videosubtitle/template',
                [
                    'content' => $output
                ]
            );
        }

        return '';
    }

    /**
     * Register domain with API
     */
    private function registerDomainApi(): void
    {
        /*
         * Website/domain
         */
        $websiteUrl = UrlHelper::siteUrl();

        $websiteUrl = parse_url(
            $websiteUrl,
            PHP_URL_HOST
        );

        /*
         * Current Craft user
         */
        $user = Craft::$app->getUser()->getIdentity();

        $userEmail = '';
        $userName = '';

        if ($user) {
            $userEmail = $user->email ?? '';

            /*
             * Craft user full name
             */
            $userName = trim(
                ($user->firstName ?? '') . ' ' .
                ($user->lastName ?? '')
            );

            /*
             * If first/last name is empty,
             * use username.
             */
            if ($userName === '') {
                $userName = $user->username ?? '';
            }
        }

        /*
         * API data
         */
        $postData = [
            'website_url'        => $websiteUrl,
            'email'              => $userEmail,
            'name'               => $userName,
            'manage_by_platform' => '0',
            'platform'           => 'Craft CMS',
        ];

        /*
         * API request
         */
        $ch = curl_init(
            'https://ada.skynettechnologies.us/api/video-subtitle/get-start'
        );

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $postData,
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => true,
        ]);

        $response = curl_exec($ch);

        /*
         * Optional logging
         */
        if (curl_errno($ch)) {

            Craft::error(
                'Video Subtitle API Error: ' . curl_error($ch),
                __METHOD__
            );

        } else {

            $result = json_decode(
                $response,
                true
            );

            Craft::info(
                'Video Subtitle API registration completed.',
                __METHOD__
            );
        }

        curl_close($ch);
    }
}