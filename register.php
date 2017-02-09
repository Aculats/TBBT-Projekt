<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */
?>
<h1>Register</h1>
<form action="<?php WEB_DIR; ?>" method="post">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required><br>
    <label for="passwordCheck">Password again</label>
    <input type="password" id="passwordCheck" name="passwordCheck" required><br>
    <input type="submit" name="register" value="Register"></button>
</form>
