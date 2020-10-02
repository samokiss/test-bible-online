<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Chapter;
use App\Entity\Testament;
use App\Repository\BookRepository;
use App\Repository\ChapterRepository;
use App\Repository\TestamentRepository;
use App\Repository\VerseRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class BibleController extends AbstractController
{
    /**
     * @Route("/", name="bible")
     */
    public function index(TestamentRepository $testamentRepository)
    {
        $testaments = $testamentRepository->findAll();
        return $this->render('bible/index.html.twig', [
            'testaments' => $testaments,
        ]);
    }

    /**
     * @Route("/testament/{id}", name="bookIndex")
     */
    public function bookIndex(Testament $testament, BookRepository $bookRepository)
    {
        $books = $bookRepository->findBy(['testament' => $testament]);
        return $this->render('bible/books.html.twig', [
            'testament' => $testament,
            'books' => $books,
        ]);
    }

    /**
     * @Route("/book/{id}", name="chapterIndex")
     */
    public function chapterIndex(Book $book, ChapterRepository $chapterRepository)
    {
        $chapters = $chapterRepository->findBy(['book' => $book]);
        return $this->render('bible/chapters.html.twig', [
            'book' => $book,
            'chapters' => $chapters,
        ]);
    }

    /**
     * @Route("/chapter/{id}", name="verseIndex")
     */
    public function verseIndex(Chapter $chapter, VerseRepository $verseRepository)
    {
        $verses = $verseRepository->findBy(['chapterr' => $chapter]);
        return $this->render('bible/verses.html.twig', [
            'chapter' => $chapter,
            'verses' => $verses,
        ]);
    }
}
