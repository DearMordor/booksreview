<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/helpers/csrf_token_helper.php' ?>

<?php if (!isset($_SESSION['user_id'])) : ?>
    <main id="login-main">
        <div class="container">
            <h1>Please Login</h1>
            <form id="login-form" action="<?php echo URLROOT; ?>/users/login" method="POST" onsubmit="return checkLoginForm()">
                <div class="form-control">
                    <label for="email">Email</label>
                    <input type="email" name="email" value="<?php echo $data['email'] ?>" id="email" required>
                    <span id="pass-email-control"><?php if (isset($data['email_err'])) echo $data['email_err']; ?></span>
                </div>

                <div class="form-control">
                    <label for="password">Password</label>
                    <input type="password" name="password" value="" id="password" required>
                    <span id="pass-password-control"><?php if (isset($data['password_err'])) echo $data['password_err']; ?></span>
                </div>
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"]; ?>">
                <span id="token-error"><?php if (isset($data['token_err'])) echo $data['token_err']; ?></span>

                <button class="btn">Login</button>

                <a href="<?php echo URLROOT; ?>/users/register">
                    <p class="text">Don't have an account?</p>
                </a>
            </form>
        </div>
    <?php else : header('location: ' . URLROOT); ?>
    <?php endif; ?>
    </main>
    <?php require APPROOT . '/views/inc/footer.php'; ?>