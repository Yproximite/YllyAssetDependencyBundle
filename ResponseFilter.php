<?php

namespace Ylly\AssetDependencyBundle;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Ylly\AssetDependencyBundle\Manager\AssetsManager;

class ResponseFilter
{
    protected $assetsManager;

    public function __construct(AssetsManager $assetsManager)
    {
        $this->assetsManager = $assetsManager;
    }

    public function onCoreResponse(FilterResponseEvent $event)
    {
        $content = $event->getResponse()->getContent();
        $javascripts = $this->assetsManager->getDependencies('javascript');
        $stylesheets = $this->assetsManager->getDependencies('stylesheet');

        $javascriptsHtml = array();
        foreach ($javascripts as $javascript) {
            $javascriptsHtml[] = '<script type="text/javascript" src="'.$this->makeAbsolute($javascript).'"></script>';
        }
        $stylesheetsHtml = array();
        foreach ($stylesheets as $stylesheet) {
            $stylesheetsHtml[] = '<link rel="stylesheet" type="text/css" href="'.$this->makeAbsolute($stylesheet).'"/>';
        }

        $content = str_replace(array(
            '<!-- YLLY_ASSET_DEPENDENCY_JAVASCRIPTS !-->',
            '<!-- YLLY_ASSET_DEPENDENCY_STYLESHEETS !-->',
        ), array(
            implode("\n", $javascriptsHtml),
            implode("\n", $stylesheetsHtml),
        ), $content);


        $event->getResponse()->setContent($content);
    }


    /**
     * Should use the assets helper to generate
     * the path, but this will do for now.
     */
    protected function makeAbsolute($path)
    {
        if (substr($path, 0, 7) == 'http://' || substr($path, 0,8) == 'https://') {
            return $path;
        }

        if (substr($path, 0, 1) != '/') {
            $path = '/'.$path;
        }

        return $path;
    }
}

