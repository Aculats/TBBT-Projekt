<?php
/**
 * @since 1.0.0
 * @author Luca
 * @licence MIT
 */

if ( isset( $_SESSION['failMessage'] ) ) {
    echo $_SESSION['failMessage'];
    unset( $_SESSION['failMessage'] );
}
?>

<div class="headline">
    <h1>Home</h1>
</div>