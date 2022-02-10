<?php

Route::get('/config-cache', function() { $exitCode = Artisan::call('config:clear');      return '<h1>Clear Config cleared</h1>';  });
Route::get('/clear-cache', function() { $exitCode = Artisan::call('cache:clear');  Artisan::call('config:clear');  return '<h1>Cache facade value cleared</h1>';  });
Route::get('/route-clear', function() { $exitCode = Artisan::call('route:clear');      return '<h1>Route cache cleared</h1>';  });
Route::get('/view-clear', function() { $exitCode = Artisan::call('view:clear');      return '<h1>View cache cleared</h1>';  });

Route::get('/', function () {
    return redirect("/prestamos");
});

Route::resource('/prestamos', 'PrestamosController');

Route::resource('/usuarios', 'UsuariosController');
Route::get('/listUsuarios', 'UsuariosController@listUsuarios');

Route::resource('/libros', 'LibrosController');
Route::get('/listLibros', 'LibrosController@listLibros');