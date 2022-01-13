<?php

namespace App\Controllers;

use \Core\View;
use \App\Models\User;
use \App\Modules\Auth;
use App\Modules\Flashmessage;

/**
 * Home controller
 *
 * PHP version 7.0
 */
class Login extends \Core\Controller
{
   
    public function newAction()
    {
        $this->redirectWhenUserLoggedIn('/');
        View::renderTemplate('Login/index.html');
    }

    public function createAction()
    {
        $this->redirectIfNotRequestMethod('POST', '/');

        $user = User::authenticate($_POST['email'], $_POST['password']);

       if ($user) {

           Auth::login($user);

           $this->redirect(Auth::getLastPage());

       } else {

        View::renderTemplate('Login/index.html', [
            'email' => $_POST['email'],
        ]);
       }
    }

    public function destroyAction()
    {
        Auth::logout();
        $this->redirect('/login/showLogOutMessage');
    }

    public function showLogOutMessageAction()
    {
        Flashmessage::set('See you soon');
        $this->redirect('/');
    }
}
