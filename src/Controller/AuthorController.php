<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    // "authors" est passé en tant qu'attribut pour faciliter l'accès de chaque méthode à la liste.
    public   $authors = array(
        array('id' => 1, 'picture' =>'/images/victor-hugo.jpg', 'username' => 'Victor Hugo', 'email' =>'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' =>'/images/william-shakespeare.jpg', 'username' => ' William Shakespeare', 'email' =>' william.shakespeare@gmail.com', 'nb_books' => 200),
        array('id' => 3, 'picture' =>'/images/Taha_Hussein.jpg', 'username' => 'Taha Hussein', 'email' =>'taha.hussein@gmail.com', 'nb_books' => 300),
    );

    
    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }


    


    #[Route('/list', name: 'app_list')]
    public function list(): Response
    {
        return $this->render('admin/list.html.twig', [
            'authors' => $this->authors,
        ]);
    }


    #[Route('/authorDetails/{id}', name: 'showbyid')]
    public function authorDetails($id):Response
    {   
        return $this->render('admin/showAuthor.html.twig', [
            'id'=>$id,'authors'=>$this->authors,
        ]);
    }
    //*************************************************client**************************************************************** */
    #[Route('/show', name: 'app_showAuthor')]
    public function showAuthor(): Response
    {

        return $this->render('client/show.html.twig');
    }
}
