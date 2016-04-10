<?php

/**
 * --------------------------------------------------
 * Class Asset
 * --------------------------------------------------
 *
 * Add scripts and styles styles to theme or plugin
 *
 * @package Affinity4
 * @author Luke Watts
 * @version 0.0.2
 */
class Asset
{
    /**
     * This tells the classes which functions to use
     * to load the assets, such as plugins_url
     * or get_stylesheet_diretory_uri()
     *
     * @var string  Either `theme` or `plugin`
     */
    protected $asset_is_for;

    /**
     * @var string The name of this plugin.
     */
    protected $plugin_dir;

    /**
     * @var string The name of this theme.
     */
    protected $theme_dir;

    /**
     * @var string The directory within this plugin to look for assets.
     */
    protected $assets_dir;

    /**
     * Example:
     * 'script-id' => array(
     *      'src'       => 'css/style.css',
     *      'deps'      => array('normalize.css'),
     *      'ver'       => '1.0.0',
     *      'media'     => 'all'
     * )
     * @var array Array of CSS files to load
     */
    private $css;

    /**
     * Example:
     * 'script-id' => array(
     *      'src'       => 'js/script.js',
     *      'deps'      => array('jquery'),
     *      'ver'       => '1.0.0',
     *      'in_footer' => true||false
     * )
     * @var array Array of JS files to load
     */
    private $js;

    /**
     * --------------------------------------------------
     * Asset constructor.
     * --------------------------------------------------
     *
     * @param   $assets
     * @throws  \Exception If $this->asset_for is not `plugin`||`theme`
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function __construct($assets, $asset_is_for = 'plugin')
    {
        $this->setAssetIsFor($asset_is_for);

        if ($this->getAssetIsFor() == 'plugin') {
            $this->setPluginDir(key($assets));
            $this->setAssetsDir(key($assets[$this->getPluginDir()]));
            $this->setCSS($assets[$this->getPluginDir()][$this->getAssetDir()]['css']);
            $this->setJS($assets[$this->getPluginDir()][$this->getAssetDir()]['js']);
        } elseif($this->getAssetIsFor() == 'theme') {
            $this->setThemeDir(key($assets));
            $this->setAssetsDir(key($assets[$this->getThemeDir()]));
            $this->setCSS($assets[$this->getThemeDir()][$this->getAssetDir()]['css']);
            $this->setJS($assets[$this->getThemeDir()][$this->getAssetDir()]['js']);
        } else {
            throw new  \Exception(sprintf(
                'Unknown `asset_for` in Asset::__construct(). Should be `plugin` or `theme`. %s given.',
                $this->asset_for
            ));
        }


        if (array_keys($this->getCSS())) add_action('wp_enqueue_scripts', array($this, 'css'));
        if (array_keys($this->getJS())) add_action('wp_enqueue_scripts', array($this, 'js'));
    }

    /**
     * --------------------------------------------------
     * Asset Is For: Setter
     * --------------------------------------------------
     *
     * Set what the asset is for, theme or plugin
     *
     * @param   string $asset_is_for
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.3
     */
    public function setAssetIsFor($asset_is_for)
    {
        $this->asset_is_for = $asset_is_for;
    }

    /**
     * --------------------------------------------------
     * Asset Is For: Getter
     * --------------------------------------------------
     *
     * Return what the asset is for, theme or plugin
     *
     * @return  string The value of $this->asset_is_for
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.3
     */
    public function getAssetIsFor()
    {
        return $this->asset_is_for;
    }

    /**
     * --------------------------------------------------
     * Set Plugin Dir
     * --------------------------------------------------
     *
     * Set the plugin name
     *
     * @param   string $plugin_dir The directory of this plugin
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function setPluginDir($plugin_dir)
    {
        $this->plugin_dir = $plugin_dir;
    }

    /**
     * --------------------------------------------------
     * Get Plugin Dir
     * --------------------------------------------------
     *
     * Get the plugin dir
     *
     * @return  string The plugin directory
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function getPluginDir()
    {
        return $this->plugin_dir;
    }

    /**
     * --------------------------------------------------
     * Set Theme Dir
     * --------------------------------------------------
     *
     * Set the theme name
     *
     * @param   string $theme_dir The directory of this theme
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.2
     */
    public function setThemeDir($theme_dir)
    {
        $this->theme_dir = $theme_dir;
    }

    /**
     * --------------------------------------------------
     * Get Theme Dir
     * --------------------------------------------------
     *
     * Get the theme dir
     *
     * @return (string) The theme directory
     * @package Affinity4
     * @author Luke Watts
     * @since 0.0.2
     */
    public function getThemeDir()
    {
        return $this->theme_dir;
    }

    /**
     * --------------------------------------------------
     * Set Assets Dir
     * --------------------------------------------------
     *
     * Set the assets dir
     *
     * @param   string $assets_dir The name of the assets dir
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function setAssetsDir($assets_dir)
    {
        $this->assets_dir = $assets_dir;
    }

    /**
     * --------------------------------------------------
     * Get Asset Dir
     * --------------------------------------------------
     *
     * Get the assets name
     *
     * @return  string      The name of the assets dir within this plugin
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function getAssetDir()
    {
        return $this->assets_dir;
    }

    /**
     * --------------------------------------------------
     * Set CSS
     * --------------------------------------------------
     *
     * Set the CSS array
     *
     * @param   array $css Array of CSS files to load
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function setCSS($css)
    {
        $this->css = $css;
    }

    /**
     * --------------------------------------------------
     * Get CSS
     * --------------------------------------------------
     *
     * Get the CSS array to loop over
     *
     * @return  array       The CSS files array to loop over
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function getCSS()
    {
        return $this->css;
    }

    /**
     * --------------------------------------------------
     * Set JS
     * --------------------------------------------------
     *
     * Set the JS array
     *
     * @param   array $js   Array of JS files to load
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function setJS($js)
    {
        $this->js = $js;
    }

    /**
     * --------------------------------------------------
     * Get JS
     * --------------------------------------------------
     *
     * Get the JS array to loop over
     *
     * @return  array       The Javascript files array to loop over
     * @package Affinity4
     * @author  Luke Watts
     * @since   0.0.1
     */
    public function getJS()
    {
        return $this->js;
    }

    /**
     * --------------------------------------------------
     * Get Asset URL
     * --------------------------------------------------
     *
     * Creates the full assets dir for use in
     * wp_enqueue_{style|script}
     *
     * @return  string     The full assets dir.
     * @throws  \Exception If $this->asset_for is not `plugin`||`theme`
     * @author  Luke Watts
     * @package Affinity4
     * @since   0.0.1
     */
    public function getAssetUrl($file)
    {
        if ($this->getAssetIsFor() == 'plugin') {
            return sprintf('%s/%s/%s', plugins_url('/' . $this->getPluginDir()), $this->getAssetDir(), $file);
        } elseif($this->getAssetIsFor() == 'theme') {
            return sprintf('%s/%s/%s', get_stylesheet_directory_uri(), $this->getAssetDir(), $file);
        } else {
            throw new  \Exception(sprintf(
                'Unknown `asset_for` in Asset::getAssetUrl(). Should be `plugin` or `theme`. %s given.',
                $this->asset_for
            ));
        }
    }

    /**
     * --------------------------------------------------
     * CSS
     * --------------------------------------------------
     *
     * Loops over the set CSS files and loads
     * each of them.
     *
     * @author  Luke Watts
     * @package Affinity4
     * @since   0.0.1
     */
    public function css()
    {
        foreach ($this->getCSS() as $id => $property) {
            wp_enqueue_style($id, $this->getAssetUrl($property['src']), $property['deps'], $property['ver'], $property['media']);
        }
    }

    /**
     * --------------------------------------------------
     * JS
     * --------------------------------------------------
     *
     * Loops over the set JS files and loads
     * each of them.
     *
     * @author  Luke Watts
     * @package Affinity4
     * @since   0.0.1
     */
    public function js()
    {
        foreach ($this->getJS() as $id => $property) {
            wp_enqueue_script($id, $this->getAssetUrl($property['src']), $property['deps'], $property['ver'], $property['in_footer']);
        }
    }
}
