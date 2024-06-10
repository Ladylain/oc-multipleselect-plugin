<?php namespace LadyLain\MultipleSelect;

use System\Classes\PluginBase;

/**
 * MultipleSelect Plugin Information File
 */
class Plugin extends PluginBase
{

    /**
     * pluginDetails about this plugin.
     */
    public function pluginDetails()
    {
        return [
            'name' => 'MultipleSelect',
            'description' => 'Multiple Select Form Widget for OctoberCMS',
            'author' => 'LadyLain',
            'icon' => 'icon-list-ul'
        ];
    }
    /**
     * register registers the plugin
     */
    public function register(): void
    {
    }

    /**
     * registerComponents registers components
     */
    public function registerComponents(): array
    {
        /*return [];*/
    }

    /**
     * registerFormWidgets registers form widgets
     */
    public function registerFormWidgets(): array
    {
        return [
            'LadyLain\MultipleSelect\FormWidgets\MultipleSelect' => 'multipleSelect',
        ];
    }


}