<?php

namespace Ylly\AssetDependencyBundle\Tests\Manager;
use Ylly\AssetDependencyBundle\Manager\AssetsManager;

class AssetManagerTest extends \PHPUnit_Framework_Testcase
{
    public function setUp()
    {
        $this->assetManager = new AssetsManager;
    }

    public function testRegisterStylesheetSingle()
    {
        $this->assetManager->registerStylesheet('stylesheet1');
        $stylesheets = $this->assetManager->getDependencies('stylesheet');
        $this->assertEquals('stylesheet1', $stylesheets['stylesheet1']);
    }

    public function testRegisterStylesheetMultiple()
    {
        $this->assetManager->registerStylesheet(array('stylesheet1', 'stylesheet2'));
        $stylesheets = $this->assetManager->getDependencies('stylesheet');
        $this->assertEquals('stylesheet1', $stylesheets['stylesheet1']);
        $this->assertEquals('stylesheet2', $stylesheets['stylesheet2']);
    }

    public function testRegisterJavascriptSingle()
    {
        $this->assetManager->registerJavascript('javascript1');
        $javascripts = $this->assetManager->getDependencies('javascript');
        $this->assertEquals('javascript1', $javascripts['javascript1']);
    }

    public function testRegisterJavascriptMultiple()
    {
        $this->assetManager->registerJavascript(array('javascript1', 'javascript2'));
        $javascripts = $this->assetManager->getDependencies('javascript');
        $this->assertEquals('javascript1', $javascripts['javascript1']);
        $this->assertEquals('javascript2', $javascripts['javascript2']);
    }
}
