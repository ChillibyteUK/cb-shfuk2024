<div class="container-xl py-5">
<?php
$sessionData = getSessionData();

foreach ($sessionData as $key => $value) {
    echo $key . ': ' . htmlspecialchars($value) . '<br>';
}

?>
</div>