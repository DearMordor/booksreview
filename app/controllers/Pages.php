<?php

/**
 * Provides functionality for main index pages
 */
class Pages extends Controller
{

    /**
     * @var Book
     */
    private $bookModel;

    /**
     * Init Book model
     */
    public function __construct()
    {
        $this->bookModel = $this->model('Book');
    }

    /**
     * Shows main page
     * @return void
     */
    public function index()
    {
        // Get books
        $books = $this->bookModel->getBooks();
        $books_per_page = 4;
        // determine which page number visitor is currently on
        if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }
        echo $page;
        $number_of_pages = ceil(count($books) / $books_per_page);

        if ($page > $number_of_pages || $page < 1) {
            $page = 1;
        }

        // determine the sql LIMIT starting number for the results on the displaying page
        $this_page_first_result = ($page - 1) * $books_per_page;

        $books = $this->bookModel->getLimitedBooks($this_page_first_result, $books_per_page);
        $data = [
            'books' => $books,
            'page' => $page,
            'number_of_pages' => $number_of_pages
        ];

        $this->view('pages/index', $data);
    }

    /**
     * Shows about us page
     * @return void
     */
    public function aboutUs()
    {
        $this->view('pages/aboutUs');
    }
}
