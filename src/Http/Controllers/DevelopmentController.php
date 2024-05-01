<?php

namespace Moawiaab\QTheme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Moawiaab\QTheme\Models\Permission;
use Moawiaab\QTheme\Models\Role;
use Moawiaab\QTheme\Services\DefaultText;
use Moawiaab\QTheme\Services\FileService;

class DevelopmentController extends Controller
{
    public function index()
    {

        $controllers = app_path('Http/Controllers');
        $resources = app_path('Http/Resources');
        $requests = app_path('Http/Requests');
        $models = app_path('Models');

        return Inertia::render('Development/Index', [
            'controllers'  => FileService::allFiles($controllers, "Controller"),
            'models'  => FileService::allFiles($models, "Controller"),
            'resources'  => FileService::allFiles($resources, "Controller"),
            'requests'  => FileService::allFiles($requests, "Controller"),
        ]);
    }

    public function store(Request $request)
    {
        // small name
        $smallName = str_replace(' ', '', trim(strtolower($request->controller)));
        DefaultText::items($request->items, $smallName);
        $name = ucfirst($smallName);

        $controller = app_path('Http/Controllers/' . $name . 'Controller.php');
        $model = app_path('Models/' . $name . '.php');
        $resource = app_path('Http/Resources/' . $name . 'Resource.php');
        $storeR = app_path('Http/Requests/Store' . $name . 'Request.php');
        $updateR = app_path('Http/Requests/Update' . $name . 'Request.php');
        $view = resource_path('js/Pages/' . $name . 's/');
        $menu = resource_path('js/Components/menu/ListMenu.vue');
        $col = resource_path('js/types/columns.ts');
        $ar = resource_path('js/i18n/ar/index.ts');
        $en = resource_path('js/i18n/en-US/index.ts');
        $router = base_path('routes/web.php');
        $colName = $name . 'Column';
        //migrations
        $m_name = date("Y-m-d") . "_" . time() . "_" . "create_" . $smallName . "_table.php";
        $migrate = database_path("migrations/" . $m_name);

        copy(__DIR__ . '/../../Resources/database/basic.php', $migrate);

        $this->setPermission(strtolower($name));
        // dd("done");

        // copy files from basic to new directory
        copy(__DIR__ . '/BasicController.php', $controller);
        copy(__DIR__ . '/../../Models/Basic.php', $model);
        copy(__DIR__ . '/../Resources/BasicResource.php', $resource);
        copy(__DIR__ . '/../Requests/StoreBasicRequest.php', $storeR);
        copy(__DIR__ . '/../Requests/UpdateBasicRequest.php', $updateR);

        if (file_exists($controller)) {
            //replace model name
            FileService::replaceInFile('Basic', $name, $model);
            FileService::replaceInFile('tablesName', $smallName . "s", $model);
            FileService::replaceInFile("'name',", DefaultText::$filedModel, $model);

            //replace resource name
            FileService::replaceInFile('BasicResource', $name . "Resource", $resource);
            //replace request name
            FileService::replaceInFile('StoreBasicRequest', 'Store' . $name . "Request", $storeR);
            FileService::replaceInFile("'name' => [],", DefaultText::$filedRequire, $storeR);
            FileService::replaceInFile('UpdateBasicRequest', 'Update' . $name . "Request", $updateR);
            FileService::replaceInFile("'name' => [],", DefaultText::$filedRequire, $updateR);

            //replace controller name and method names
            FileService::replaceInFile('BasicController', $name . "Controller", $controller);
            FileService::replaceInFile('Basics/', $name . 's/', $controller);
            FileService::replaceInFile('basics', $smallName . 's', $controller);
            FileService::replaceInFile('$basic', '$' . $smallName, $controller);
            FileService::replaceInFile('Basic', $name, $controller);
            // copy resources files in vue folder
            (new Filesystem)->copyDirectory(__DIR__ . '/../../Resources/Basic', $view);
            // views files index , create, update, show
            FileService::replaceInFile('UsersColumn', $colName, $view . '/Index.vue');
            FileService::replaceInFile('user', $smallName, $view . '/Index.vue');
            FileService::replaceInFile('user', $smallName, $view . '/Create.vue');
            FileService::replaceInFile('user', $smallName, $view . '/Edit.vue');
            FileService::replaceInFile('user', $smallName, $view . '/Show.vue');
            //set input to create and edit files
            FileService::replaceInFile('inputsItem', DefaultText::$inputItems, $view . '/Create.vue');
            FileService::replaceInFile('name: "",', DefaultText::$formInput, $view . '/Create.vue');
            FileService::replaceInFile('inputsItem', DefaultText::$inputItems, $view . '/Edit.vue');

            // add route to web page
            FileService::replaceInFile('//don`t remove this lint', DefaultText::route($name), $router);
            // add column to columns.ts
            FileService::editFile($col, DefaultText::column($colName));
            //add item to menu items
            FileService::replaceInFile('//don`t remove this lint', DefaultText::menu($smallName), $menu);

            // add lang to ar and en

            FileService::replaceInFile('//don`t remove this item', DefaultText::langItem($name), $ar);
            FileService::replaceInFile('//don`t remove this lint', DefaultText::lang($name), $ar);
            FileService::replaceInFile('//don`t remove this item', DefaultText::langItem($name), $en);
            FileService::replaceInFile('//don`t remove this lint', DefaultText::lang($name), $en);

            // replace table name
            FileService::replaceInFile('basics', $smallName . "s", $migrate);
            // set filed items
            FileService::replaceInFile('$table->string("name");', DefaultText::$filedTable, $migrate);
        }
        // dd($name);
    }


    private function setPermission($name)
    {
        $data = [
            ['details' => " access " .   $name, 'title' => $name . "_access"],
            ['details' => " create " .  $name, 'title' => $name . "_create"],
            ['details' => " edit " .  $name, 'title' => $name . "_edit"],
            ['details' => " delete " .    $name, 'title' => $name . "_delete"]
        ];
        $role = Role::find(1);
        $permission = Permission::insert($data);
        if ($permission) {
            $permissions = Permission::orderBy('id', 'desc')->take(4)->get(['id', 'title']);
            foreach ($permissions as $key) {
                $role->permissions()->syncWithoutDetaching($key->id);
            }
        }
    }
}
