<?php require APPROOT . '/views/inc/header.php'; ?>
<main>
    <div class="single-book">
        <div class="single-book-photo">
            <img src="<?php echo URLROOT . '/' . $data['book']->path_to_image ?>" alt=" bookName" width="315" height="496">
        </div>
        <div class="single-book-info">
            <h1><strong><?php echo $data['book']->title ?></strong></h1>
            <h3>Author: <?php echo $data['book']->author ?></h3>
            <h3>Rating: <span class="green"><?php echo $data['book']->rating ?></span> </h3>
            <h3>Overview:</h3>
            <p>
                <?php echo $data['book']->overview ?>
            </p>
        </div>
    </div>
    <div class="reviews">
        <div class="all-reviews">
            <h3>Reviews:</h3>
            <?php if (isset($_SESSION['user_id']) and $data['hasReview'] == false) : ?>
                <div class="review-form">
                    <div class="login">
                        <form action="<?php echo URLROOT; ?>/books/addReview/<?php echo $data['book']->id; ?>">
                            <button class="login-button">Add review </button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            <br>
            <?php foreach ($data['reviews'] as $review) : ?>
                <div class="review">
                    <div class="review-name"><?php echo $review->name; ?></div>
                    <div class="review-date">30.01.2022</div>
                    <div class="review-text">
                        <?php echo $review->review; ?>
                    </div>
                </div>
            <?php endforeach ?>
            <div class="pagination">
                <?php
                for ($data['page'] = 1; $data['page'] <= $data['number_of_pages']; $data['page']++) {
                    echo '<a href="' .  URLROOT . '/books/show/' .  $data['book']->id . '?page=' . $data['page'] . '">' . $data['page'] . '</a> ';
                }
                ?>
            </div>
        </div>
    </div>
</main>
<?php require APPROOT . '/views/inc/footer.php'; ?>