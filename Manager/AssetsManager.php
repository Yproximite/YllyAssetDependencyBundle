<?php

namespace Ylly\AssetDependencyBundle\Manager;

class AssetsManager
{
    protected $dependencies = array();
    protected $kernel;
    protected $pathAliases = array(
        'stylesheet' => array(),
        'javascript' => array(),
    );

    public function addPathAlias($type, $alias, $path)
    {
        if (isset($this->pathAliases[$type][$alias])) {
            throw new \InvalidArgumentException(sprintf('Alias with name "%s" already registered', $alias));
        }

        $this->pathAliases[$type][$alias] = $path;
    }

    public function register($type, $resource)
    {
        if (substr($resource, 0 ,1) == '@') {
            $alias = substr($resource, 1);
            if (isset($this->pathAliases[$type][$alias])) {
                $resource = $this->pathAliases[$type][$alias];
            } else {
                throw new \InvalidArgumentException(sprintf('"%s" alias "@%s" specified but has not been configured. Configured aliases: %s', $type, $alias, implode(',', array_keys($this->pathAliases[$type]))));
            }
        }

        $this->dependencies[$type][$resource] = $resource;
    }

    public function registerStylesheet($stylesheets)
    {
        if (is_array($stylesheets)) {
            foreach ($stylesheets as $stylesheet) {
                $this->register('stylesheet', $stylesheet);
            }
        } else {
            $this->register('stylesheet', $stylesheets);
        }
    }

    public function registerJavascript($javascripts)
    {
        if (is_array($javascripts)) {
            foreach ($javascripts as $javascript) {
                $this->register('javascript', $javascript);
            }
        } else {
            $this->register('javascript', $javascripts);
        }
    }

    public function getDependencies($type)
    {
        if (isset($this->dependencies[$type])) {
            return $this->dependencies[$type];
        }

        return array();
    }
}
