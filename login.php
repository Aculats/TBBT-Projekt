<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */
?>
<form action="<?php WEB_DIR ?>" method="post">
    <label for="username">Username</label>
    <input type="text" id="username" name="username" required><br>
    <label for="password">Password</label>
    <input type="password" id="password" name="password" required><br>
    <input type="submit" name="login" value="Login">
</form>
