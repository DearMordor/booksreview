<?php require APPROOT . '/views/inc/header.php'; ?>
<?php require APPROOT . '/helpers/csrf_token_helper.php' ?>
<?php if (!isset($_SESSION['user_id'])) : ?>

    <main id="login-main">
        <div class="container">
            <h1>Sign up</h1>

            <form action="<?php echo URLROOT; ?>/users/register" method="POST" id="register-form" onsubmit="return checkRegistration();">
                <div class="form-control">
                    <label for="name">Name:</label>
                    <input type="text" name="name" id="name" value="<?php echo $data['name']; ?>" required>
                    <span id="pass-name-control"><?php if (isset($data['name_err'])) echo $data['name_err']; ?></span>
                </div>
                <div class="form-control">
                    <label for="email">Email:</label>
                    <input type="email" name="email" id="email" value="<?php echo $data['email']; ?>" required>
                    <!--TODO: Make js control or server-->
                    <span id="pass-email-control"><?php if (isset($data['email_err'])) echo $data['email_err']; ?></span>
                </div>

                <div class="form-control">
                    <label for="password">Password:</label>
                    <input type="password" name="password" id="password" value="" required>
                    <span id="pass-password-control"><?php if (isset($data['password_err'])) echo $data['password_err']; ?></span>
                </div>

                <div class="form-control">
                    <label for="confirm-password">Repeat password:</label>
                    <input type="password" name="confirm_password" value="" id="confirm-password" required>
                    <span id="pass-confirm-password"><?php if (isset($data['confirm_password_err'])) echo $data['confirm_password_err']; ?></span>
                </div>

                <div class="form-control">
                    <label for="birthday">Birthday:</label>
                    <input type="date" name="birthday" id="birthday" value="<?php if (isset($data['birthday'])) echo $data['birthday']; ?>" min="1920-01-01" max="2021-03-27" required>
                    <span id="pass-birthday-password"><?php if (isset($data['birthday_err'])) echo $data['birthday_err']; ?></span>
                </div>
                <input type="hidden" name="token" value="<?php echo $_SESSION["token"]; ?>">
                <span id="token-error"><?php if (isset($data['token_err'])) echo $data['token_err']; ?></span>
                <button class="btn">Sign up</button>

            </form>
        </div>
    <?php else : header('location: ' . URLROOT); ?>
    <?php endif; ?>
    </main>
    <?php require APPROOT . '/views/inc/footer.php'; ?>