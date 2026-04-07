<?php
/**
 * Block: metrics
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Previews
if ($is_preview && isset($block['data']['preview_image_help'])) {
    $preview_image_url = get_template_directory_uri() . '/blocks/metrics/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = 'metrics-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Fields
$title = get_field('title') ?: 'РОЗГЛЯНЕМО МЕТРИКИ УСПІХУ';
$metrics_list = get_field('metrics_list');
$metrics_slider = get_field('metrics_slider');

?>

<section <?=$anchor?> class="
    <?= esc_attr($class_name)?>">
    <div class="container metrics__inner">
        <?php if ($title): ?>
        <h2 class="metrics__title reveal reveal-d1 visible">
            <?= esc_html($title); ?>
        </h2>
        <?php
endif; ?>

        <div class="metrics__grid">

            <!-- Left col: Metrics -->
            <div class="metrics__col metrics__col--list">
                <?php if ($metrics_list): ?>
                <div class="metrics__list">
                    <?php foreach ($metrics_list as $metric): ?>
                    <div class="metrics__item">
                        <span class="metrics__item-value">
                            <?= esc_html($metric['metric_value']); ?>
                        </span>
                        <span class="metrics__item-separator"></span>
                        <span class="metrics__item-desc">
                            <?= esc_html($metric['metric_description']); ?>
                        </span>
                    </div>
                    <?php
    endforeach; ?>
                </div>
                <?php
endif; ?>
            </div>

            <!-- Right col: Box Slider + Bottom Nav -->
            <div class="metrics__col-right">
                <?php if ($metrics_slider): ?>

                <div class="metrics__col metrics__col--slider">
                    <div class="swiper metrics__swiper">
                        <div class="swiper-wrapper">
                            <?php foreach ($metrics_slider as $slide): ?>
                            <div class="swiper-slide metrics__slide">
                                <div class="metrics__slide-card">
                                    <?php if (!empty($slide['image'])): ?>
                                    <div class="metrics__slide-img-wrapper">
                                        <?= wp_get_attachment_image($slide['image'], 'large', false, ['class' => 'metrics__slide-img', 'loading' => 'lazy']); ?>
                                    </div>
                                    <?php
        endif; ?>

                                    <div class="metrics__slide-content">
                                        <p class="metrics__slide-text">
                                            <?= esc_html($slide['text']); ?>
                                        </p>

                                        <?php
        // Fallback for button
        $btn_url = !empty($slide['button_url']) ? $slide['button_url'] : '#';
        $btn_text = !empty($slide['button_text']) ? $slide['button_text'] : 'ЧИТАТИ ПОВНІСТЮ';
?>
                                        <a href="<?= esc_url($btn_url); ?>"
                                            class="btn btn-primary btn-sm metrics__slide-btn">
                                            <?= esc_html($btn_text); ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <?php
    endforeach; ?>
                        </div> <!-- /.swiper-wrapper -->
                        <div class="metrics__pagination swiper-pagination"></div>
                    </div> <!-- /.swiper -->
                </div> <!-- /.metrics__col--slider -->

                <div class="metrics__slider-nav">
                    <button class="swiper-button-prev metrics__swiper-prev" aria-label="Попередній слайд">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M15 18.6004L9.56667 13.1671C8.925 12.5254 8.925 11.4754 9.56667 10.8337L15 5.40039"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                    <button class="swiper-button-next metrics__swiper-next" aria-label="Наступний слайд">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.08496 18.6004L14.5183 13.1671C15.16 12.5254 15.16 11.4754 14.5183 10.8337L9.08496 5.40039"
                                stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>

                <?php
endif; ?>
            </div> <!-- /.metrics__col-right -->

        </div> <!-- /.metrics__grid -->
    </div> <!-- /.metrics__inner -->
</section>