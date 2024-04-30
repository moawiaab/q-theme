<?php

namespace Moawiaab\QTheme\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;
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
        $name = ucfirst(strtolower($request->controller));
        $controller = app_path('Http/Controllers/' . $name . 'Controller.php');
        $model = app_path('Models/' . $name . '.php');
        $resource = app_path('Http/Resources/' . $name . 'Resource.php');
        $storeR = app_path('Http/Requests/Store' . $name . 'Request.php');
        $updateR = app_path('Http/Requests/Update' . $name . 'Request.php');
        $view = resource_path('js/Pages/' . $name . 's/');
        $col = fopen(resource_path('js/types/columns.ts'), 'a');

        $router = base_path('routes/web.php');


        $colName = $name . 'Column';

        $text = "\n".'export const ' . $colName . ' = [
        { name: "name", required: true, label: "input.role.name", align: "left", field: "title" },
        { name: "created_at", label: "g.created_at", field: "created_at", align: "left", sortable: true },
        { name: "options", label: "g.options", field: "options" }
        ]';

        copy(__DIR__ . '/BasicController.php', $controller);
        copy(__DIR__ . '/../../Models/Basic.php', $model);
        copy(__DIR__ . '/../Resources/BasicResource.php', $resource);
        copy(__DIR__ . '/../Requests/StoreBasicRequest.php', $storeR);
        copy(__DIR__ . '/../Requests/UpdateBasicRequest.php', $updateR);

        if (file_exists($controller)) {
            //model
            FileService::replaceInFile('Basic', $name, $model);
            //resource
            FileService::replaceInFile('BasicResource', $name . "Resource", $resource);
            //request
            FileService::replaceInFile('StoreBasicRequest', 'Store' . $name . "Request", $storeR);
            FileService::replaceInFile('UpdateBasicRequest', 'Update' . $name . "Request", $updateR);
            //controller
            FileService::replaceInFile('BasicController', $name . "Controller", $controller);
            FileService::replaceInFile('Basics/', $name . 's/', $controller);
            FileService::replaceInFile('basics', strtolower($name . 's/'), $controller);
            FileService::replaceInFile('$basic', '$' . strtolower($name), $controller);
            FileService::replaceInFile('Basic', $name, $controller);
            // copy resources files
            (new Filesystem)->copyDirectory(__DIR__ . '/../../Resources/Basic', $view);
            // index file

            FileService::replaceInFile('UsersColumn', $colName, $view . '/Index.vue');
            FileService::replaceInFile('user', strtolower($name), $view . '/Index.vue');
            FileService::replaceInFile('user', strtolower($name), $view . '/Create.vue');
            FileService::replaceInFile('user', strtolower($name), $view . '/Edit.vue');
            FileService::replaceInFile('user', strtolower($name), $view . '/Show.vue');


            $route = $name . 's';
            $co = 'Route::resource("'.$route.'", App\Http\Controllers\\'.$name.'Controller::class); '."\n".' //don`t remove this lint';
            FileService::replaceInFile('//don`t remove this lint',$co, $router);
            fwrite($col, $text);
            fclose($col);
        }
        // dd($name);
    }
}
