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
            $javascriptsHtml[] = '<script type="text/javascript" src="'.$javascript.'"></script>';
        }
        $stylesheetsHtml = array();
        foreach ($stylesheets as $stylesheet) {
            $stylesheetsHtml[] = '<link rel="stylesheet" type="text/css" href="'.$stylesheet.'"/>';
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
}

