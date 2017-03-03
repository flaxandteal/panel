<?php
namespace Serverfireteam\Panel;

use Illuminate\Routing\Controller;

class CrudController extends Controller
{
    const ID_COLUMN = 'id';

    public    $grid;
    public    $entity;
    public    $set;
    public    $edit;
    public    $filter;
    protected $lang;
    public    $helper_message;

    /**
     * Check which features of the view should be included
     */
    protected $features = [
        'all' => [
            'import-button' => true,
            'export-button' => true,
            'return-button' => null
        ],
        'edit' => [
        ]
    ];

    public function __construct(\Lang $lang)
    {
       // $this->entity = $params['entity'];
        $route = \App::make('route');
        $this->lang = $lang;
        $this->route = $route;
        if($route = $route::current())
        {
            $routeParamters = $route->parameters();
            if(isset($routeParamters['entity']))
                $this->setEntity($routeParamters['entity']);
        }
    }

    /**
    * @param string $entity name of the entity
    */
    public function all($entity)
    {
        //$this->addStylesToGrid();
    }

    /**
    * @param string $entity name of the entity
    */
    public function edit($entity)
    {

    }

    public function getEntity() {
        return $this->entity;
    }

    public function setEntity($entity) {
        $this->entity = $entity;
    }

    public function getEntityModel() {

        $entity = $this->getEntity();

        $appHelper = new libs\AppHelper;

        $modelClass = $appHelper->getModel($entity);

        return new $modelClass;
    }

    public function addStylesToGrid($orderByColumn = self::ID_COLUMN, $paginateCount = 10)
    {
        $this->grid->edit('edit', trans('panel::fields.edit'), 'show|modify|delete');


        if ($orderByColumn === self::ID_COLUMN) {
            $orderByColumn = $this->getEntityModel()->getKeyName();
        }

        $this->grid->orderBy($orderByColumn, 'desc');
        $this->grid->paginate($paginateCount);
    }

    public function addHelperMessage($message)
    {
        $this->helper_message = $message;
    }

    public function returnView($viewname='panelViews::all', $array=[])
    {
        $configs = \Serverfireteam\Panel\Link::returnUrls();

        if (!isset($configs) || $configs == null) {
            throw new \Exception('NO URL is set yet !');
        } else if (!in_array($this->entity, $configs)) {
            throw new \Exception('This url is not set yet!');
        } else {
            $array = array_merge([
                'grid'           => $this->grid,
                'filter'         => $this->filter,
                'title'          => $this->entity ,
                'current_entity' => $this->entity,
                'import_message' => (\Session::has('import_message')) ? \Session::get('import_message') : '',
                'features'       => $this->features['all']
            ], $array);
            return \View::make($viewname, $array);
        }
    }

    public function returnEditView($viewname='panelViews::edit', $array=[])
    {
        $configs = \Serverfireteam\Panel\Link::returnUrls();

        if (!isset($configs) || $configs == null) {
            throw new \Exception('NO URL is set yet !');
        } else if (!in_array($this->entity, $configs)) {
            throw new \Exception('This url is not set yet !');
        } else {
            if ($this->edit) {
                $array = array_merge([
                    'title' => $this->entity,
                    'helper_message' => $this->helper_message
                ], $array);
                return $this->edit->view($viewname, $array);
            }
            $array = array_merge([
                'title'          => $this->entity,
                'edit'           => $this->edit,
                'features'       => $this->features['edit'],
                'helper_message' => $this->helper_message
            ], $array);
            return \View::make($viewname, $array);
        }
    }

    public function finalizeFilter() {
        $lang = \App::make('lang');
        $this->filter->submit($this->lang->get('panel::fields.search'));
        $this->filter->reset($this->lang->get('panel::fields.reset'));
    }
}
