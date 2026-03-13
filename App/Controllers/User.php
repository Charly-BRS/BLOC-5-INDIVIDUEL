<?php

namespace App\Controllers;

use App\Config;
use App\Model\UserRegister;
use App\Models\Articles;
use App\Utility\Hash;
use App\Utility\Session;
use \Core\View;
use Exception;
use http\Env\Request;
use http\Exception\InvalidArgumentException;

/**
 * User controller
 */
class User extends \Core\Controller
{
    /**
     * Affiche la page de login
     */
    public function loginAction()
    {
        if (isset($_POST['submit'])) {
            $f = $_POST;

            if ($this->login($f)) {
                header('Location: /account');
                exit;
            }

            View::renderTemplate('User/login.html', [
                'error' => 'Identifiants invalides.',
                'formData' => $f
            ]);
            return;
        }

        View::renderTemplate('User/login.html');
    }

    /**
     * Page de création de compte
     */
    public function registerAction()
    {
        if (isset($_POST['submit'])) {
            $f = $_POST;

            try {
                if ($f['password'] !== $f['password-check']) {
                    throw new \Exception("Les mots de passe ne correspondent pas.");
                }

                $this->register($f);
                $this->login($f);

                header('Location: /account');
                exit;
            } catch (\Exception $e) {
                View::renderTemplate('User/register.html', [
                    'error' => $e->getMessage(),
                    'formData' => $f
                ]);
                return;
            }
        }

        View::renderTemplate('User/register.html');
    }

    /**
     * Affiche la page du compte
     */
    public function accountAction()
    {
        if (!isset($_SESSION['user']) && isset($_COOKIE['remember_user'])) {
            $user = \App\Models\User::getById($_COOKIE['remember_user']);

            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                ];
            }
        }

        if (!isset($_SESSION['user'])) {
            header('Location: /login');
            exit;
        }

        $articles = Articles::getByUser($_SESSION['user']['id']);

        View::renderTemplate('User/account.html', [
            'articles' => $articles
        ]);
    }

    /*
     * Fonction privée pour enregistrer un utilisateur
     */
    private function register($data)
    {
        try {
            $salt = Hash::generateSalt(32);

            $userID = \App\Models\User::createUser([
                "email" => $data['email'],
                "username" => $data['username'],
                "password" => Hash::generate($data['password'], $salt),
                "salt" => $salt
            ]);

            return $userID;
        } catch (Exception $ex) {
            // TODO : Set flash if error
        }
    }

    private function login($data)
    {
        try {
            if (!isset($data['email'])) {
                throw new Exception('Email manquant');
            }

            $user = \App\Models\User::getByLogin($data['email']);

            if (!$user) {
                return false;
            }

            if (Hash::generate($data['password'], $user['salt']) !== $user['password']) {
                return false;
            }

            $_SESSION['user'] = array(
                'id' => $user['id'],
                'username' => $user['username'],
            );

            if (isset($data['remember']) && $data['remember'] == '1') {
                setcookie(
                    'remember_user',
                    $user['id'],
                    time() + (86400 * 30),
                    "/"
                );
            }

            return true;
        } catch (Exception $ex) {
            return false;
        }
    }

    /**
     * Logout: Delete cookie and session.
     */
    public function logoutAction()
    {
        if (isset($_COOKIE['remember_user'])) {
            setcookie('remember_user', '', time() - 3600, '/');
        }

        $_SESSION = array();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();

        header("Location: /");
        exit;
    }
}