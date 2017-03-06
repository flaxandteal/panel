<?php
namespace Serverfireteam\Panel\libs;


class dashboard
{

    public static $dashboardItems;

    public static $urls;

    public static function getItems()
    {
        if(!self::$dashboardItems) {
            self::$dashboardItems = self::create();
        }

        return self::$dashboardItems;
    }

    public static function create()
    {
        self::$urls = \Config::get('panel.panelControllers');

        $config    = \Serverfireteam\Panel\Link::allCached();
        $dashboard = array();

        $appHelper = new AppHelper();

        // Make Dashboard Items
        foreach ($config as $value) {

    	    $modelName = $value['url'];
            /*
            if ( in_array($modelName, self::$urls)) {
               $model = "Serverfireteam\\Panel\\".$modelName;
            } else {
               $model = $appHelper->getNameSpace() . $modelName;
            }
            */
            $model = $appHelper->getModel($modelName);

            //if (class_exists($value)) {
            if($value['show_menu'])
            {
                $user = \Auth::user();
                if (! $user->hasRole('admin'))
                    if (! \Auth::user()->hasPermissionTo('view /' . $modelName . '/all'))
                        continue;
                    
                $modelObject = \App::make($model);
                if ($modelObject->dashboardCount !== null) {
                    $count = $modelObject->dashboardCount;
                } else {
                    $count = $modelObject->count();
                }

                $dashboard[] = array(
                    'modelName' => $modelName,
                    'title'   => $value['display'],
                    'count'   => $count,
                    'showListUrl' => 'panel/' . $modelName . '/all',
                    'addUrl'      => 'panel/' . $modelName . '/edit',
                );
            }
            
        }

       return $dashboard;
    }
}
