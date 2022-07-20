<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class FrontAuthorsController extends AbstractController
{

    /**
     * @Route("/authors",name="authors")
     */

    public function authors(AuthorRepository $authorRepository)
    {
        $authors = $authorRepository->findAll();
        return $this->render('front/authors.html.twig', ['authors' => $authors]);
//        dd("coucou");
    }

    /**
     * @Route("/author/{id}",name="author")
     */

    public function author(AuthorRepository $authorRepository, $id)
    {
        $author = $authorRepository->find($id);
        return $this->render('front/author.html.twig', ['author' => $author]);
    }

    /**
     * @Route("/authors/search", name="authors-search")
     */

    public function searchAuthors(Request $request, AuthorRepository $authorRepository, BookRepository $bookRepository)
    {
        // je récupère les valeurs du formulaire dans ma route
        $search = $request->query->get('search');

        // je vais créer une méthode dans l'ArticleRepository
        // qui trouve un article en fonction d'un mot dans son titre ou son contenu
        $authors = $authorRepository->searchByWord($search);
        $books = $bookRepository->searchByWord($search);


        if ((!empty($authors)) || (!empty($books))) {

            // je renvoie un fichier twig en lui passant les articles trouvé
            // et je les affiche

            return $this->render('front/authors-search.html.twig', [
                'authors' => $authors,
                'books' => $books
            ]);
        } else {
            //sinon message d'erreur on redirige vers home
            $this->addFlash('error', 'Votre recherche n\'a rien donné');
            return $this->redirectToRoute('home');
        }

    }

}
