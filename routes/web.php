<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () {
    return 'auth-service';
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'v1'], function () use ($router) {
        $router->group(['prefix' => 'auth'], function () use ($router) {
            $router->post('login', 'AuthController@login');
            $router->post('picker/login', 'AuthController@loginPicker');
            $router->post('boss/login', 'AuthController@loginBoss');
            $router->post('partner/login', 'AuthController@loginPartner');
        });

        //password-service
        $router->group(['prefix' => 'password'], function () use ($router) {
            $router->post('forgot', 'PasswordController@forgotPassword');
            $router->post('reset', 'PasswordController@resetPassword');
        });

        //JWT
        $router->group(['middleware' => 'jwt'], function ($router) {
            $router->group(['prefix' => 'auth'], function () use ($router) {
                $router->post('refresh', 'AuthController@refresh');
                $router->post('logout', 'AuthController@logout');
                $router->post('register', 'AuthController@register');
            });

            //user-service
            $router->group(['prefix' => 'users'], function () use ($router) {
                $router->post('/update/avatar', ['uses' => 'UsersController@updateAvatar']);

                //ADMIN SCOPE
                $router->group(['middleware' => 'role:admin'], function ($router) {
                    $router->get('/', ['uses' => 'UsersController@index']);
                    $router->get('/paginate', ['uses' => 'UsersController@paginate']);
                    $router->post('/update/{id}', ['uses' => 'UsersController@update']);
                    $router->get('/detail/{id}', ['uses' => 'UsersController@detail']);
                    $router->delete('/delete/{id}', ['uses' => 'UsersController@delete']);
                    $router->post('/create', ['uses' => 'UsersController@create']);

                    $router->post('register', 'AuthController@register');
                    $router->get('show', 'UsersController@show');
                });
            });

            //roles-service
            $router->group(['prefix' => 'roles'], function ($router) {
                //ADMIN SCOPE
                $router->group(['middleware' => 'role:admin'], function ($router) {
                    $router->get('/', ['uses' => 'RoleController@index']);
                    $router->get('/paginate', ['uses' => 'RoleController@paginate']);
                });
            });
        });
    });
});
