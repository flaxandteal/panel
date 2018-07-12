<?php

namespace Serverfireteam\Panel\libs;


use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Serverfireteam\Panel\LinkRepository;

class dashboard
{

    /**
     * Dashboard items cache
     * @var array
     */
    public static $dashboardItems;

    /**
     * Either retrieve the dashboard items from cache or from the config/DB if they were not yet cached
     * @return array
     */
    public static function getItems ()
    {
        if (!self::$dashboardItems) {
            self::$dashboardItems = \App::call(self::class . '@create');
        }

        return self::$dashboardItems;
    }

    /**
     * Determine whether to show the given entity type in the panel
     * @param $link
     * @return bool
     */
    private function showLink ($link)
    {
        if (!$link['show_menu']) return false;

        $user = \Auth::user();
        return $user->hasRole('admin') ||
            $user->hasPermissionTo('view /' . $modelName . '/all');
    }

    /**
     * Return the array of entity types (models / links)
     * to show CRUD interfaces for in the panel
     *
     * @param AppHelper      $appHelper
     * @param LinkRepository $linkRepository
     *
     * @return array
     */
    public function create (AppHelper $appHelper, LinkRepository $linkRepository)
    {
        // @TODO cache

        return $linkRepository->all()

            ->filter(function ($link) {
                return $this->showLink($link);
            })

            ->map(function ($link) use ($appHelper) {

                $modelName = $link['url'];

                $modelObject = $appHelper->getModel($modelName);
                if ($modelObject->dashboardCount !== null) {
                    $count = $modelObject->dashboardCount;
                } else {
                    $count = $modelObject->count();
                }

                return [
                    'modelName'   => $modelName,
                    'title'       => $link['display'],
                    'count'       => $count,
                    'showListUrl' => 'panel/' . $modelName . '/all',
                    'addUrl'      => 'panel/' . $modelName . '/edit',
                ];
            })

            ->toArray();
    }
}
