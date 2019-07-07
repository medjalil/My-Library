<?php

namespace App\Controller;


use App\Entity\Book;
use Knp\Component\Pager\PaginatorInterface;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{

    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/bookmark/{id}", name="add_bookmark")
     */
    public function addBookmark($id, BookRepository $bookRepository)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $book = $bookRepository->find($id);
        $user = $this->getUser();
        $book->addUser($user);
        $entityManager->persist($book);
        $entityManager->flush();
        $this->get('session')->getFlashBag()->add(
            'notice', array(
            'alert' => 'success',
            'title' => '',
            'message' => 'Fav Added.'
        ));
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }
    /**
     * @Route("/bookmarks", name="bookmarks")
     */
    public function bookmarks(BookRepository $bookRepository)
    {
        //$entityManager = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        //var_dump($user);
        $books = $bookRepository->findAll(array($user));
        return $this->render('book/bookmarks.html.twig', [
            'books' => $books,
        ]);
    }
    /**
     * @Route("/list", name="book_list", methods={"GET"})
     */
    public function list(PaginatorInterface $paginator, Request $request, BookRepository $bookRepository ): Response
    {



        $books = $paginator->paginate(
            $bookRepository->findAll(),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('book/list.html.twig', [
            'current_menu' => 'books',
            'books'   => $books,

        ]);
    }






}
