<!DOCTYPE html>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <?php do_action( 'flatsome_after_body_open' ); ?>
    <?php wp_body_open(); ?>

    <a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'flatsome' ); ?></a>

    <div id="wrapper">

        <?php do_action( 'flatsome_before_header' ); ?>

        <header id="header" class="header <?php flatsome_header_classes(); ?>">
            <div class="header-wrapper">
                <?php get_template_part( 'template-parts/header/header', 'wrapper' ); ?>
            </div>
        </header>

        <?php do_action( 'flatsome_after_header' ); ?>

        <main id="main" class="<?php flatsome_main_classes(); ?>">