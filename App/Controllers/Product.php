<?php

namespace App\Controllers;

use App\Models\Articles;
use App\Utility\Upload;
use \Core\View;

/**
 * Product controller
 */
class Product extends \Core\Controller
{
    /**
     * Affiche la page d'ajout
     * @return void
     */
    public function indexAction()
    {
        if (isset($_POST['submit'])) {
            try {
                $f = $_POST;

                if (
                    !isset($_FILES['picture']) ||
                    !isset($_FILES['picture']['error']) ||
                    $_FILES['picture']['error'] === UPLOAD_ERR_NO_FILE
                ) {
                    throw new \Exception("Une photo est obligatoire pour déposer une annonce.");
                }

                $f['user_id'] = $_SESSION['user']['id'];
                $id = Articles::save($f);

                $pictureName = Upload::uploadFile($_FILES['picture'], $id);
                Articles::attachPicture($id, $pictureName);

                header('Location: /product/' . $id);
                exit;
            } catch (\Exception $e) {
                View::renderTemplate('Product/Add.html', [
                    'error' => $e->getMessage()
                ]);
                return;
            }
        }

        View::renderTemplate('Product/Add.html');
    }

    /**
     * Affiche la page d'un produit
     * @return void
     */
    public function showAction()
    {
        $id = $this->route_params['id'];

        try {
            Articles::addOneView($id);
            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);
        } catch (\Exception $e) {
            var_dump($e);
            return;
        }

        View::renderTemplate('Product/Show.html', [
            'article' => $article[0],
            'suggestions' => $suggestions
        ]);
    }

    /**
     * Gère le formulaire de contact d'un produit
     * @return void
     */
    public function contactAction()
    {
        $id = $this->route_params['id'];

        try {
            if (!isset($_POST['submit'])) {
                header('Location: /product/' . $id);
                exit;
            }

            $email = trim($_POST['email'] ?? '');
            $message = trim($_POST['message'] ?? '');

            if ($email === '' || $message === '') {
                throw new \Exception("Tous les champs sont obligatoires.");
            }

            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);

            View::renderTemplate('Product/Show.html', [
                'article' => $article[0],
                'suggestions' => $suggestions,
                'success' => 'Votre message a bien été envoyé.'
            ]);
            return;
        } catch (\Exception $e) {
            $suggestions = Articles::getSuggest();
            $article = Articles::getOne($id);

            View::renderTemplate('Product/Show.html', [
                'article' => $article[0],
                'suggestions' => $suggestions,
                'error' => $e->getMessage()
            ]);
            return;
        }
    }
}