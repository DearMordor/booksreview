<?php

/**
 * Provides functionality for books. Show single book, add review to the book
 */
class Books extends Controller
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
     * Shows a single book
     * @param $id
     * @return void
     */
    public function show($id)
    {
	// Check if book exists. If not, redirect to main page
	if (!$this->bookModel->doesBookExist($id)) {
		header('Location: ' . URLROOT);
		return;
	}

        // Get books from DB
        $book = $this->bookModel->getBookById($id);

        // Get users reviews from DB
        $reviews = $this->bookModel->getReviews($id);

        // Check if user has already left a review
        if (isset($_SESSION['user_id'])) {
            $hasReview = $this->bookModel->hasReviewById($_SESSION['user_id'], $id);
        } else {
            $hasReview = false;
        }

        $reviews_per_page = 3;

        // determine which page number visitor is currently on
        if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
            $page = 1;
        } else {
            $page = $_GET['page'];
        }

        if ($page > $reviews_per_page || $page < 1) {
            $page = 1;
        }

        $number_of_pages = ceil(count($reviews) / $reviews_per_page);
        // determine the sql LIMIT starting number for the results on the displaying page
        $this_page_first_result = ($page - 1) * $reviews_per_page;

        $reviews = $this->bookModel->getLimitedReviews($this_page_first_result, $reviews_per_page, $id);

        $user_id = '';

        if (isset($_SESSION['user_id'])) {
            $user_id = $_SESSION['user_id'];
        }

        $data = [
            'book' => $book,
            'reviews' => $reviews,
            'hasReview' => $hasReview,
            'bookId' => $id,
            'userId' => $user_id,
            'page' => $page,
            'number_of_pages' => $number_of_pages,
            'name_err' => '',
            'review_err' => ''
        ];

        $this->view('books/show', $data);
    }

    /**
     * Add single review from user to the $id book
     * @param $id
     * @return void
     */
    public function addReview($id)
    {
        $book = $this->bookModel->getBookById($id);
        $reviews = $this->bookModel->getReviews($id);

        // Check if user has already a review on this book
        if (isset($_SESSION['user_id'])) {
            $hasReview = $this->bookModel->hasReviewById($_SESSION['user_id'], $id);
        } else {
            $hasReview = false;
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            // Init data 
            $data = [
                'book' => $book,
                'reviews' => $reviews,
                'hasReview' => $hasReview,
                'bookId' => $id,
                'userId' => $_SESSION['user_id'],
                'name' => trim($_POST['name']),
                'review' => trim($_POST['review']),
                'token' => trim($_POST['token']),
                'name_err' => '',
                'review_err' => '',
                'token_err' => ''
            ];

            // Validate Name
            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            } else if (strlen($data['name']) > 40) {
                $data['name_err'] = 'Full name is too long!';
            } else if (!preg_match("/^[a-zA-Z-' ]*$/", $data['name'])) {
                $data['name_err'] = 'Only letters and whitespaces allowed!';
            } else {
                $data['name_err'] = '';
            }

            // Validate token
            if (!empty($_POST['token'])) {
                if (!hash_equals($_SESSION['token'], $_POST['token'])) {
                    $data['token_err'] = 'Detected CSRF ATTACK. Please resubmit.';
                }
            }

            if (empty($data['name_err']) && empty($data['review_err']) && empty($data['token_err'])) {
                // TODO - Pop up success
                if ($this->bookModel->addReview($data)) {
                    header('location: ' . URLROOT);
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->view('books/addReview', $data);
            }
        } else {
            $data = [
                'book' => $book,
                'reviews' => $reviews,
                'hasReview' => $hasReview,
                'bookId' => "",
                'userId' => "",
                'name' => "",
                'review' => "",
                'name_err' => '',
                'review_err' => ''
            ];
            $this->view('books/addReview', $data);
        }
    }
}
