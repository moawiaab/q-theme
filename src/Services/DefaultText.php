<?php

namespace Moawiaab\QTheme\Services;

class DefaultText
{

    public static function column($column)
    {
        return "\n" . 'export const ' . $column . ' = [
            { name: "name", required: true, label: "input.role.name", align: "left", field: "title" },
            { name: "created_at", label: "g.created_at", field: "created_at", align: "left", sortable: true },
            { name: "options", label: "g.options", field: "options" }
            ]';
    }

    public static function menu($text)
    {
        return "\n" . '{
            text: "item.' . $text . '",
            icon: "list",
            to: "' . $text . 's.index",
            access: "' . $text . '",
            active: "' . $text . 's",
        },' . "\n" . ' //don`t remove this lint';
    }

    public static function route($name)
    {
        $route = strtolower($name . 's');
        return 'Route::resource("' . $route . '", App\Http\Controllers\\' . $name . 'Controller::class); ' . "\n" . ' //don`t remove this lint';
    }

    public static function lang($text)
    {
        $name = strtolower($text);
        return "\n" . '  ' . $name . ': {
        title: "' . $text . 's List",
        title_new: "Create New ' . $text . '",
        title_edit: "Edit This ' . $text . '",
        view: "View this ' . $text . '",
        name: "' . $text . ' Name",
    },' . "\n" . ' //don`t remove this lint';
    }

    public static function langItem($text)
    {
        $name = strtolower($text);
        return $name . ': "List ' . $text . 's",' . "\n" . ' //don`t remove this item';
    }
}
