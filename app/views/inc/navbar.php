<header>
    <!--Logo -->
    <div class="logo">
        <h1>
            <a id="logo" href="<?php echo URLROOT; ?>">Books reviews</a>
        </h1>
    </div>

    <?php if (isset($_SESSION['user_id'])) : ?>
        <div class="login">
            <form action="<?php echo URLROOT; ?>/users/logout">
                <button id="login-button" class="login-button">Logout</button>
            </form>
        </div>
    <?php else : ?>
        <div class="login">
            <form action="<?php echo URLROOT; ?>/users/login">
                <button id="login-button" class="login-button">Login</button>
            </form>
        </div>
    <?php endif; ?>
</header>