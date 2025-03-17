<section class="contact py-5">
    <div class="container-xl">
        <div class="row g-4">
            <div class="col-md-6">
                <h2>Get in touch</h2>
                <?php
                if (get_field('intro') ?? null) {
                    ?>
                <div class="mb-4"><?=get_field('intro')?></div>
                    <?php
                }
                ?>
                <ul class="fa-ul">
                    <li class="mb-2"><span class="fa-li"><i class="fa-solid fa-phone has-blue-400-color"></i></span> <?=contact_phone()?></li>
                    <li class="mb-2"><span class="fa-li"><i class="fa-solid fa-paper-plane has-blue-400-color"></i></span> <?=contact_email()?></li>
                    <li><span class="fa-li"><i class="fa-solid fa-map-marker-alt has-blue-400-color"></i></span> <?=contact_address()?></li>
                </ul>
            </div>
            <div class="col-md-6">
                <h2>Send us a message</h2>
                <?=do_shortcode('[gravityform id="' . get_field('form_id') . '" title="false"]')?>
            </div>
        </div>
    </div>
</section>