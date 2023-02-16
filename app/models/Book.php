<?php

/**
 * Book model for accessing books from DB
 */
class Book
{
    /**
     * @var Database
     */
    private $db;

    /**
     * Init Database class
     */
    public function __construct()
    {
        $this->db = new Database;
    }

    /**
     * Get all books from database
     * @return Array
     */
    public function getBooks()
    {
        $this->db->query('SELECT * FROM books
                        ');
        // Return more than one row
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Get single book by its id
     * @param $id
     * @return Array
     */
    public function getBookById($id)
    {
        $this->db->query('SELECT * FROM books WHERE id = :id');
        $this->db->bind(':id', $id);

        $row = $this->db->single();
        return $row;
    }

    /**
     * Add review to a book
     * @param $data
     * @return bool
     */
    public function addReview($data)
    {
        $this->db->query('INSERT INTO reviews (name, review, bookId, userId) VALUES(:name, :review, :bookId, :userId)');
        // Bind values
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':review', $data['review']);
        $this->db->bind(':bookId', $data['bookId']);
        $this->db->bind(':userId', $data['userId']);

        // Execute
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get all reviews by book id
     * @param $id
     * @return Array
     */
    public function getReviews($id)
    {
        $this->db->query('SELECT * FROM reviews WHERE bookId = :bookId
        ');
        $this->db->bind(':bookId', $id);
        // Return more than one row
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Get limited review by its number pagination
     * @param $this_page_first_result
     * @param $results_per_page
     * @param $id
     * @return Array
     */
    public function getLimitedReviews($this_page_first_result, $results_per_page, $id)
    {
        $this->db->query('SELECT * FROM reviews WHERE bookId = :bookId LIMIT ' . $this_page_first_result . ',' .  $results_per_page);
        $this->db->bind(':bookId', $id);
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Get limited books for current number pagination
     * @param $this_page_first_result
     * @param $books_per_page
     * @return Array
     */
    public function getLimitedBooks($this_page_first_result, $books_per_page)
    {
        $this->db->query('SELECT * FROM books LIMIT ' . $this_page_first_result . ',' .  $books_per_page);
        $result = $this->db->resultSet();
        return $result;
    }

    /**
     * Check if user has a review for this book
     * @param $userId
     * @param $bookId
     * @return bool|void
     */
    public function hasReviewByid($userId, $bookId)
    {
        $this->db->query('SELECT * FROM reviews WHERE userId = :userId');
        $this->db->bind(':userId', $userId);

        $row = $this->db->single();
        if (isset($row->userId) && isset($row->bookId)) {
            if ($row->userId == $userId && $row->bookId == $bookId) {
                return true;
            }
            return false;
        }
    }

    public function doesBookExist($id)
    {
        $this->db->query('SELECT * FROM books WHERE id = :id');
        $this->db->bind('id', $id);

        $row = $this->db->single();
        // echo "Printing a row: ";
        // echo count((array)$row);
        if (count((array)$row) == 1) {
            return false;
        }
        return true;
    }
}
