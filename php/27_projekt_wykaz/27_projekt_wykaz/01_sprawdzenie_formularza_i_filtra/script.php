<?php
// [ZOBACZ W README: SEC-1]
if (isset($_POST['szukaj'])) {
    // [ZOBACZ W README: SEC-2]
    $miasto = $_POST['miasto'];

    // [ZOBACZ W README: SEC-3]
    echo "<p>$miasto</p>";
}
