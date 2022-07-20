<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class FrontBooksController extends AbstractController
{
    /**
     * @Route("/books",name="books")
     */

    public function books(BookRepository $bookRepository)
    {
        $books = $bookRepository->findAll();
        return $this->render('front/books.html.twig', ['books' => $books]);
//        dd("coucou");
    }

    /**
     * @Route("/book/{id}",name="book");
     */

    public function book($id, BookRepository $bookRepository)
    {
        $book = $bookRepository->find($id);
        return $this->render('front/book.html.twig', ['book' => $book]);
    }

}

