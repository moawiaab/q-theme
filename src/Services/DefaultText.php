<?php

namespace Moawiaab\QTheme\Services;

class DefaultText
{

    public static $filedTable = "";
    public static $filedModel = "";
    public static $filedRequire = "";
    public static $langText = "";
    public static $inputItems = "";
    public static $formInput = "";

    protected static $string = array("string", "text", "tinyText", "longText");
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
        ' . self::$langText . '
    },' . "\n" . ' //don`t remove this lint';
    }

    public static function langItem($text)
    {
        $name = strtolower($text);
        return $name . ': "List ' . $text . 's",' . "\n" . ' //don`t remove this item';
    }

    public static function items($items, $name)
    {
        foreach ($items as $item) {
            $filed = str_replace(' ', '', trim(strtolower($item['filed'])));
            $type = "string";
            $inputType = "text";
            if (in_array($item['type'], self::$string)) {
                $type = "string";
                $inputType = "text";
            } elseif ($item['type'] == 'boolean') {
                $type = "boolean";
                $inputType = "";
            } elseif ($item['type'] == 'decimal') {
                $type = "numeric";
                $inputType = "number";
            } elseif ($item['type'] == 'date') {
                $type = "date";
                $inputType = "date";
            } else {
                $type = "integer";
                $inputType = "number";
            }
            $nullable = $item['require'] == false ? "->nullable();" : ";";
            $nullableReq = $item['require'] == false ? "nullable" : "required";
            self::$filedTable .= '$table->' . $item['type'] . '("' . $filed . '")' . $nullable . "\n";
            self::$filedModel .= "'" . $filed . "'," . "\n";
            self::$filedRequire .= "'" . $filed . "' => ['" . $type . "', '" . $nullableReq . "']," . "\n";
            self::$langText .= $filed . ': "' . ucfirst($item['name']) . '",' . "\n";
            self::$inputItems .= self::input($name, $filed, $item['require'], $inputType);
            //!TODO: set default value
            self::$formInput .= $filed . ": null,". "\n";
        }
    }

    public static function input($name, $filed, $bool, $type)
    {
        if ($bool == true) {
            $role = ' lazy-rules
            :rules="[(val) => !!val || $t(' . "'v.required'" . ')]"
            :error-message="form.errors.' . $filed . '"
            :error="form.errors.' . $filed . ' ? true : false"';
        } else {
            $role = '';
        }
        return '<q-input
        clearable
        type="' . $type . '"
        filled
        v-model="form.' . $filed . '"
        :label="$t(' . "'g." . $name . "." . $filed . "'" . ')"
       ' . $role . '
      />' . "\n";
    }
}
