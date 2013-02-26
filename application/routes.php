<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
 */

/*
 * Register controller
 */
Route::controller(Controller::detect());

/*
 * Ajax Routes
 */

Route::post('contact', function() {
          //get input
          $fname = Input::get('fname');
          return $fname;
      });

//Signin
Route:: post('signin', function() {
          // get POST data, attempt to authenticate based on input
          $input = array(
              'username' => Input::get('username_login'),
              'password' => Input::get('password_login')
          );
          
          //Returning data
          $response = array();
          
          //VALIDATION
          $rules = array(
              'username' => 'required',
              'password' => 'required'
          );
          
          $v = Validator::make($input, $rules);
          if ($v->fails()) {
              $response['status'] = 'ERROR';
              $response['message'] = 'Συμπληρώστε τα στοιχεία σας.';
              return Response::json($response);
          }
          if ($v->passes()) {
              //check if user exists
              $user = User::where('username', '=', $input['username'])->first();
              //dd($user);
              if (is_null($user)) {
                  $response['status'] = 'ERROR';
                  $response['message'] = 'Ο χρήστης δεν υπάρχει στο σύστημα.';
                  return Response::json($response);
              }
              if (Auth::attempt($input)) {
                  //dd(Config::get('offline'));
                  if (Config::get('offline') && $user->id != 1) {
                      //return Redirect::to_action('home@index')->with('maintenance_mode', true);
                      //return Redirect::back();
                  }
                  //maintenance mode on/off
                  //return Redirect::to_action('home@index')->with('success_signin',true);

                  $response['status'] = 'OK';
                  $response['message'] = 'Συνδεθήκατε με επιτυχία.';
                  return Response::json($response);
              } else {
                  $response['status'] = 'ERROR';
                  $response['message'] = 'Παρουσιάστηκε πρόβλημα κατά την συνδεσή σας. Παρακαλώ δοκιμάστε ξανά.';
                  return Response::json($response);
              }
          }
      });

//Route::any('dogs/addlost', 'dogs@addlost');


/*
  |--------------------------------------------------------------------------
  | Application 404 & 500 Error Handlers
  |--------------------------------------------------------------------------
  |
  | To centralize and simplify 404 handling, Laravel uses an awesome event
  | system to retrieve the response. Feel free to modify this function to
  | your tastes and the needs of your application.
  |
  | Similarly, we use an event to handle the display of 500 level errors
  | within the application. These errors are fired when there is an
  | uncaught exception thrown in the application.
  |
 */

Event::listen('404', function() {
          return Response::error('404');
      });

Event::listen('500', function() {
          return Response::error('500');
      });

/*
  |--------------------------------------------------------------------------
  | Route Filters
  |--------------------------------------------------------------------------
  |
  | Filters provide a convenient method for attaching functionality to your
  | routes. The built-in before and after filters are called before and
  | after every request to your application, and you may even create
  | other filters that can be attached to individual routes.
  |
  | Let's walk through an example...
  |
  | First, define a filter:
  |
  |		Route::filter('filter', function()
  |		{
  |			return 'Filtered!';
  |		});
  |
  | Next, attach the filter to a route:
  |
  |		Router::register('GET /', array('before' => 'filter', function()
  |		{
  |			return 'Hello World!';
  |		}));
  |
 */

Route::filter('before', function() {
// Do stuff before every request to your application...
      });

Route::filter('after', function($response) {
// Do stuff after every request to your application...
      });

Route::filter('csrf', function() {
          if (Request::forged())
              return Response::error('500');
      });

Route::filter('auth', function() {
          if (Auth::guest())
              return Redirect::to('login');
      });