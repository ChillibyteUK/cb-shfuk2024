<?php
$width = 'Narrow' === get_field( 'width' ) ? 'w-lg-75' : '';

$hp = is_front_page() ? 'three_col_usp__content--hide' : '';

$usp1 = get_field( 'usp_1' ) ? get_field( 'usp_1' ) : get_field( 'usp_1', 'option' );
$usp2 = get_field( 'usp_2' ) ? get_field( 'usp_2' ) : get_field( 'usp_2', 'option' );
$usp3 = get_field( 'usp_3' ) ? get_field( 'usp_3' ) : get_field( 'usp_3', 'option' );

if ( is_front_page() ) {
    $usp1 = wrap_non_strong_content( $usp1 );
    $usp2 = wrap_non_strong_content( $usp2 );
    $usp3 = wrap_non_strong_content( $usp3 );
}

?>
<section class="three_col_usp pb-4">
    <div class="container-xl">
        <div class="row gx-4 gy-3 <?= esc_attr( $width ); ?> mx-auto">
            <div class="col-md-4 three_col_usp__item px-0 px-md-2">
                <div class="three_col_usp__icon"></div>
                <div class="three_col_usp__content <?= esc_attr( $hp ); ?>">
                    <?= wp_kses_post( $usp1 ); ?>
                </div>
            </div>
            <div class="col-md-4 three_col_usp__item px-0 px-md-2">
                <div class="three_col_usp__icon"></div>
                <div class="three_col_usp__content <?= esc_attr( $hp ); ?>">
                    <?= wp_kses_post( $usp2 ); ?>
                </div>
            </div>
            <div class="col-md-4 three_col_usp__item px-0 px-md-2">
                <div class="three_col_usp__icon"></div>
                <div class="three_col_usp__content <?= esc_attr( $hp ); ?>">
                    <?= wp_kses_post( $usp3 ); ?>
                </div>
            </div>
        </div>
    </div>
</section>