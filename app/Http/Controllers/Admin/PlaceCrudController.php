<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PlaceRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PlaceCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PlaceCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Place::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/place');
        CRUD::setEntityNameStrings('place', 'places');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('name');
        $this->crud->addColumn([
            // 1-n relationship
            'label' => "categorie", // Table column heading
            'type' => "select",
            'name' => 'id_cat', // the column that contains the ID of that connected entity;
            'entity' => 'cat', // the method that defines the relationship in your Model
            'attribute' => "categorie", // foreign key attribute that is shown to user
            'model' => "App/Models/Cat", // foreign key model
        ]);

        /**
         * Columns can be defined using the fluent syntax or array syntax:
         * - CRUD::column('price')->type('number');
         * - CRUD::addColumn(['name' => 'price', 'type' => 'number']); 
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PlaceRequest::class);

        CRUD::field('name');
        //CRUD::field('id_cat');
        $this->crud->addField([
            'name' => 'id_cat',//name="id_cat"
            'label' => 'Categorie',
            'type' => 'select',
            'entity' => 'cat',//method relation entre deux models
            'attribute' => 'categorie',//attribut du model a affiche
            'model' => "App\Models\Cat",
        ]);
        

        /**
         * Fields can be defined using the fluent syntax or array syntax:
         * - CRUD::field('price')->type('number');
         * - CRUD::addField(['name' => 'price', 'type' => 'number'])); 
         */
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
