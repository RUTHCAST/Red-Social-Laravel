<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\image;

Route::get('/', function () {

    // $images=Image::all();

    // foreach($images as $image){
    //     echo $image->image_path."<br>";
    //     echo $image->description."<br>";
    //     echo "<hr>";
    // }
    // die();

    return view('welcome');
});
// Rutas GENERALES
Auth::routes();
Route::get('/', 'HomeController@index')->name('home');

// Rutas Usuarios
Route::get('/configuracion', 'UserController@config')->name('config');
Route::post('/user/update', 'UserController@update')->name('user.update');
Route::get('/user/avatar/{filename}', 'UserController@getImagen')->name('user.avatar');
Route::get('/profile/{id}', 'UserController@profile')->name('user.profile');
Route::get('/user/index/{search?}', 'UserController@index')->name('user.index');

// Rutas Imagenes
Route::get('/subir-imagen', 'ImageController@create')->name('image.create');
Route::post('/image/save', 'ImageController@save')->name('image.save');
Route::get('/image/file/{filename}', 'ImageController@getImage')->name('image.file');
Route::get('/image/{id}', 'ImageController@detail')->name('image.detail');
Route::get('/image/delete/{id}', 'ImageController@delete')->name('image.delete');
Route::get('/image/edit/{image_id}', 'ImageController@edit')->name('image.edit');
Route::post('/image/update', 'ImageController@update')->name('image.update');

// Rutas Comentarios
Route::post('/comment/save', 'CommentController@save')->name('comment.save');
Route::get('/comment/delete/{id}', 'CommentController@delete')->name('comment.delete');

// Rutas Likes
Route::get('/like/{image_id}', 'LikeController@like')->name('like.save');
Route::get('/dislike/{image_id}', 'LikeController@dislike')->name('like.delete');
Route::get('/likes', 'LikeController@index')->name('likes.index');

