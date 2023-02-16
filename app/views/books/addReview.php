<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/helpers/csrf_token_helper.php' ?>
<?php if (isset($_SESSION['user_id'])) : ?>
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
                <div class="container">
                    <form action="<?php echo URLROOT . "/books/addReview/" . $data['book']->id; ?>" method="POST" onsubmit="return checkReviewForm();">
                        <div class="form-control">
                            <label for="name">Name:</label>
                            <input type="text" name="name" id="name" required>
                            <span id="pass-name-control"><?php if (isset($data['name_err'])) echo $data['name_err']; ?></span>
                            <textarea name="review" maxlength="700" cols="50" rows="10" required>Enter your review here...</textarea>
                            <span id="pass-review-control"><?php if (isset($data['review_err'])) echo $data['review_err']; ?></span>
                            <input type="hidden" name="token" value="<?php echo $_SESSION["token"]; ?>">
                            <span id="token-error"><?php if (isset($data['token_err'])) echo $data['token_err']; ?></span>
                        </div>

                        <div class="login">
                            <button class="login-button">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- header('location: ' . URLROOT); -->
    <?php else :  ?>
        <main>
            <div class="about-us">
                <h1>404 error. You must first <a href="<?php echo URLROOT; ?>/users/login">login</a> before leaving a review</h1>

            </div>
        <?php endif; ?>
        </main>
        <?php require APPROOT . '/views/inc/footer.php'; ?>