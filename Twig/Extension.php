<?php

namespace Ylly\AssetDependencyBundle\Twig;
use Ylly\AssetDependencyBundle\Manager\AssetsManager;

class Extension extends \Twig_Extension
{
    protected $assetsManager;

    public function __construct(AssetsManager $assetsManager)
    {
        $this->assetsManager = $assetsManager;
    }

    public function initRuntime(\Twig_Environment $environment)
    {
    }

    public function getFunctions()
    {
        return array(
            'depends_on_stylesheet' => new \Twig_Function_Method($this, 'dependsOnStylesheets'),
            'depends_on_javascript' => new \Twig_Function_Method($this, 'dependsOnJavascripts'),

            'stylesheet_depenencies' => new \Twig_Function_Method($this, 'stylesheetDependencyUrls'),
            'javascript_depenencies' => new \Twig_Function_Method($this, 'javascriptDependencyUrls'),
        );
    }

    public function dependsOnStylesheets(array $stylesheetResources)
    {
        foreach ($stylesheetResources as $resource) {
            $this->assetsManager->register('stylesheet', $resource);
        }
    }

    public function dependsOnJavascripts(array $javascriptResources)
    {
        foreach ($javascriptResources as $resource) {
            $this->assetsManager->register('javascript', $resource);
        }
    }

    public function stylesheetDependencyUrls()
    {
        return $this->assetsManager->getDependencies('stylesheet');
    }

    public function javascriptDependencyUrls()
    {
        return $this->assetsManager->getDependencies('javascript');
    }

    public function getName()
    {
        return "ylly_asset_dependency";
    }
}
