<?php require APPROOT . '/views/inc/header.php'; ?>
<main id="main">
    <?php foreach ($data['books'] as $book) : ?>
        <div class="book">
            <a href="<?php echo URLROOT; ?>/books/show/<?php echo $book->id; ?>">
                <div class="book-image">
                    <img src="<?php echo URLROOT . '/' .  $book->path_to_image ?>" alt="book1">
                </div>
                <div class="book-info">
                    <h3><?php echo $book->title; ?></h3>
                    <span class="green"><?php echo $book->rating; ?></span>
                </div>
            </a>
        </div>

    <?php endforeach ?>
</main>

<div class="pagination">
    <?php
    for ($data['page'] = 1; $data['page'] <= $data['number_of_pages']; $data['page']++) {
        echo '<a href="' .  URLROOT . '?page=' . $data['page'] . '">' . $data['page'] . '</a> ';
    }
    ?>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>