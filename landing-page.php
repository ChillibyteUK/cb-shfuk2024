<?php
/* Template Name: Landing (no nav) */
// Exit if accessed directly.
defined('ABSPATH') || exit;
get_header('landing');
?>
<main id="main">
    <?php
    the_post();
the_content();
?>
</main>
<?php
get_footer('landing');
?>