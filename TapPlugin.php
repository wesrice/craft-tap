<?php
namespace Craft;

class TapPlugin extends BasePlugin
{
    // Public Methods
    // =========================================================================

    /**
     * Returns the plugin’s version number.
     *
     * @return string The plugin’s version number.
     */
    public function getVersion()
    {
        return '0.0.0';
    }

    /**
     * Returns the plugin developer’s name.
     *
     * @return string The plugin developer’s name.
     */
    public function getDeveloper()
    {
        return 'Airtype Studio';
    }

    /**
     * Returns the plugin developer’s URL.
     *
     * @return string The plugin developer’s URL.
     */
    public function getDeveloperUrl()
    {
        return 'http://airtype.com';
    }

    /**
     * Returns whether this plugin has its own section in the CP.
     *
     * @return bool Whether this plugin has its own section in the CP.
     */
    public function hasCpSection()
    {
        return false;
    }

    public function init()
    {
        Craft::import('plugins.tap.vendor.autoload', true);
    }

    public function registerSiteRoutes()
    {
        return [
            'tap/(?P<elementType>\w+)/(?P<elementId>\w+)' => ['action' => 'tap/tap'],
            'tap/(?P<elementType>\w+)'                    => ['action' => 'tap/tap'],
        ];
    }

}
