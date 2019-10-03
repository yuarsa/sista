<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;
use Blade;

class ComponentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Form::component('inputText', 'components.form.input_text', [
            'name', 'text', 'icon', 'id' ,'attributes' => [], 'value' => null, 'col' => 'col-md-10 col-sm-10 col-xs-12',
        ]);

        Form::component('inputEmail', 'components.form.input_email', [
            'name', 'text', 'icon', 'id' ,'attributes' => [], 'value' => null, 'col' => 'col-md-10 col-sm-10 col-xs-12',
        ]);

        Form::component('inputPassword', 'components.form.input_password', [
            'name', 'text', 'icon', 'id' ,'attributes' => [], 'value' => null, 'col' => 'col-md-10 col-sm-10 col-xs-12',
        ]);

        Form::component('inputSelect', 'components.form.input_select', [
            'name', 'text', 'icon', 'id','values', 'attributes' => [], 'selected' => null, 'col' => 'col-md-10 col-sm-10 col-xs-12',
        ]);

        Form::component('inputCheckbox', 'components.form.input_checkbox', [
            'name', 'text', 'items' => [], 'value' => 'name', 'id' => 'id', 'attributes' => ['required' => 'required'], 'col' => 'col-md-10 col-sm-10 col-xs-12',
        ]);

        Form::component('inputTextarea', 'components.form.input_textarea', [
            'name', 'text', 'id', 'attributes' => [], 'value' => null, 'col' => 'col-md-10',
        ]);

        Form::component('btnSave', 'components.button.button_save', [
            'cancel', 'col' => 'col-md-12',
        ]);

        Form::component('delete', 'components.button.button_delete', [
            'row', 'url', 'text' => '', 'value' => 'name', 'id' => 'id',
        ]);
    }
}
