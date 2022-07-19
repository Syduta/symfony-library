<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;


class AdminAuthorsController extends AbstractController
{
    /**
     * @Route("/admin/authors",name="admin-authors")
     */

    public function authors(AuthorRepository $authorRepository){
        $authors=$authorRepository->findAll();
        return $this->render('admin/authors.html.twig',['authors'=>$authors]);
//        dd("coucou");
    }

    /**
     * @Route("/admin/author/{id}",name="admin-author")
     */

    public function author(AuthorRepository$authorRepository, $id){
        $author = $authorRepository->find($id);
        return $this->render('admin/author.html.twig',['author'=>$author]);
    }

    /**
     * @Route("/admin/authors/delete/{id}",name="admin-delete-author")
     */

    public function deleteAuthor($id,AuthorRepository $authorRepository, EntityManagerInterface $entityManager){
        $author = $authorRepository->find($id);
        if(!is_null($author)){
            $entityManager->remove($author);
            $entityManager->flush();
            $this->addFlash('success','auteur supprimé de la base de données');
            return$this->redirectToRoute('admin-authors');
        }else{
            $this->addFlash('success','auteur déjà supprimé');
            return $this->redirectToRoute('admin-authors');
        }
    }

    /**
     * @Route("/admin/authors/update/{id}",name="admin-update-author")
     */

    public function updateAuthor($id,AuthorRepository$authorRepository, EntityManagerInterface $entityManager, Request $request, SluggerInterface$slugger){
        $author = $authorRepository->find($id);
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $image=$form->get('image')->getData();
            $originalFilename = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
            $safeFilename=$slugger->slug($originalFilename);
            $newFilename=$safeFilename.'-'.uniqid().'.'.$image->guessExtension();
            $image->move(
                $this->getParameter('images_directory'),$newFilename
            );
            $author->setImage($newFilename);




            $entityManager->persist($author);
            $entityManager->flush();
            $this->addFlash('success','auteur mis à jour');
        }
        return$this->render("admin/update-author.html.twig",
            ['form'=>$form->createView(),
                'author'=>$author]);
    }

    /**
     * @Route("/admin/new-author",name="new-author")
     */

    public function newAuthor(EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger){
        $author = new Author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            //pour image

            //je récupère l'image dans le formulaire qu est en mapped false donc faut gérer nous même l'upload
            $image=$form->get('image')->getData();
            //on récup le nom du fichier original
            $originalFilename = pathinfo($image->getClientOriginalName(),PATHINFO_FILENAME);
            //j'utilise une instance de la classe slugger et sa méthode slug pour suppr caractères spéciaux
            // espaces etc
            $safeFilename=$slugger->slug($originalFilename);
            //je rajoute au nom de l'image un identifiant unique au cas ou l'image soit ajoutée un autre fois
            $newFilename=$safeFilename.'-'.uniqid().'.'.$image->guessExtension();
            //je déplace l'image et lui donne un nouveau nom
            $image->move(
                $this->getParameter('images_directory'),$newFilename
            );
            $author->setImage($newFilename);

            //fin image
            $entityManager->persist($author);
            $entityManager->flush();
            $this->addFlash('success','auteur ajouté');

        }
        return $this->render("/admin/new-author.html.twig",['form'=>$form->createView()]);
//        dd("coucou");
    }

    /**
     * @Route("/admin/authors/search", name="admin-authors-search")
     */

    public function searchAuthors(Request $request, AuthorRepository $authorRepository, BookRepository $bookRepository){
        // je récupère les valeurs du formulaire dans ma route
        $search = $request->query->get('search');

        // je vais créer une méthode dans l'ArticleRepository
        // qui trouve un article en fonction d'un mot dans son titre ou son contenu
        $authors = $authorRepository->searchByWord($search);
        $books = $bookRepository->searchByWord($search);


        if((!empty($authors))||(!empty($books))){

            // je renvoie un fichier twig en lui passant les articles trouvé
            // et je les affiche

            return $this->render('admin/authors-search.html.twig', [
                'authors' => $authors,
                'books' => $books
            ]);
        }else{
            //sinon message d'erreur on redirige vers home
            $this->addFlash('error', 'Votre recherche n\'a rien donné');
            return $this->redirectToRoute('home');
        }

    }

}