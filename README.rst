Asset Dependency Bundle
=======================

This bundle enables TWIG templates to declare that they need stylesheets and javascripts.

Usage
-----

.. code::

    {{ depends_on_stylesheet(['bundles/foobar/css/style.css']) }}
    {{ depends_on_javascript(['bundles/foobar/js/jquery.js']) }}

Each dependency is then included once when the response is rendered.

The bundle also allows you to specify aliases in the configuration

.. code::

    // app/config.yml
    ylly_asset_dependency:
        javascript_alias_map:
            jquery: bundles/foobar/js/jquery.js
            jquery-ui: bundles/foobar/js/jquery-ui.js
        stylesheet_alias_map:
            style: bundles/foobar/css/style.css

.. code::

    {{ depends_on_stylesheet(['@style']) }}
    {{ depends_on_javascript(['@jquery']) }}

To include the dependencies in your layout insert the following placeholders

.. code::

    <!-- YLLY_ASSET_DEPENDENCY_STYLESHEETS !-->
    <!-- YLLY_ASSET_DEPENDENCY_JAVASCRIPTS !-->
