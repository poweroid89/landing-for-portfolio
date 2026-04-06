<?php
/**
 * Block: hero
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Якщо це прев'ю в адмінці і ми маємо placeholder картинку
if ($is_preview && isset($block['data']['preview_image_help'])) {
    $preview_image_url = get_template_directory_uri() . '/blocks/hero/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = 'hero-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Fields
$title = get_field('hero_title') ?: 'СПIЛЬНОТА ТВОГО РОЗВИТКУ';
$subtitle = get_field('hero_subtitle') ?: 'практичний підхід, який викликає реальні зміни';
$btn_primary_txt = get_field('hero_cta_primary_text') ?: 'ПЕРЕЙТИ ДО ПРОДУКТІВ';
$btn_primary_url = get_field('hero_cta_primary_link') ?: '#';
$stats = get_field('hero_stats') ?: [
    ['hero_stat_number' => '85%', 'hero_stat_label' => 'Успішних кейсів'],
    ['hero_stat_number' => '10 000+', 'hero_stat_label' => 'Учасників'],
    ['hero_stat_number' => '200+', 'hero_stat_label' => 'Матеріалів'],
];
// Helper: розумний парсинг для поля зображення (приймає масив, URL, або відносний рядок)
if (!function_exists('hero_get_image_url')) {
    function hero_get_image_url($field_name)
    {
        $val = get_field($field_name);
        if (!$val)
            return '';
        // 1: Якщо юзер обрав "Image Array"
        if (is_array($val))
            return isset($val['url']) ? $val['url'] : '';
        // 2: Якщо це відносний текстовий шлях (наприклад "assets/images/X.webp")
        if (is_string($val) && !preg_match('/^https?:\/\//i', $val) && !str_starts_with($val, '/wp-content/')) {
            $val = ltrim($val, '/'); // забираємо зайвий слеш на початку, якщо є
            return get_template_directory_uri() . '/' . $val;
        }
        // 3: Якщо це вже готовий лінк
        return $val;
    }
}

$hero_image_desktop_1x = hero_get_image_url('hero_image_desktop_1x');
$hero_image_desktop_2x = hero_get_image_url('hero_image_desktop_2x');
$hero_image_mobile_1x = hero_get_image_url('hero_image_mobile_1x');
$hero_image_mobile_2x = hero_get_image_url('hero_image_mobile_2x');

?>

<section <?= $anchor?> class="
    <?= esc_attr($class_name)?>">
    <div class="container hero__inner">
        <?php if ($title): ?>
        <h1 class="hero__title reveal">
            <?= esc_html($title); ?>
        </h1>
        <?php
endif; ?>

        <div class="hero__content">
            <div class="hero__content__left">
                <p class="hero__subtitle reveal reveal-d1">
                    *&nbsp;<?= esc_html($subtitle); ?>
                </p>
                <div class="hero__actions reveal reveal-d2">
                    <a href="<?= esc_url($btn_primary_url); ?>" class="btn btn-primary btn-lg">
                        <?= esc_html($btn_primary_txt); ?>

                        <span class="btn__icon">
                            <svg width="20" height="15" viewBox="0 0 20 15" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4.6752 0.749714C4.6752 0.339615 5.0143 0.000488281 5.4245 0.000488281L14.0085 0C14.4186 0 14.7584 0.339841 14.7584 0.74994V9.33464C14.7583 9.54665 14.6731 9.73072 14.5388 9.86498C14.4046 9.99898 14.2209 10.0837 14.0092 10.0839C13.5991 10.0839 13.2593 9.74415 13.2593 9.33393V2.55982L2.518 13.3011C2.2281 13.5911 1.7472 13.5911 1.4573 13.3011C1.1674 13.0112 1.1674 12.5303 1.4573 12.2404L12.1986 1.49919H5.4245C5.0143 1.49919 4.6752 1.15981 4.6752 0.749714Z"
                                    fill="white" />
                            </svg>
                        </span>
                    </a>
                </div>
            </div>

            <div class="hero__content__right">
                <picture>
                    <?php if ($hero_image_desktop_1x): ?>
                    <img src="<?= esc_url($hero_image_desktop_1x)?>" class="hero__image" alt="Hero Background" fetchpriority="high" decoding="sync">
                    <?php else: ?>
                    <img src="<?= esc_url(get_template_directory_uri() . '/assets/images/photos/pill_1x.webp')?>"
                        class="hero__image" alt="Pill" fetchpriority="high" decoding="sync">
                    <?php endif; ?>
                </picture>

                <div class="hero__stats-wrapper">
                    <?php foreach ($stats as $index => $stat): ?>
                    <div class="hero__stat-card hero__stat-card--<?= $index + 1?>">
                        <div class="hero__stat-card-shimmer"></div>
                        <div class="hero__stat-num js-counter-trigger"
                            data-value="<?= esc_attr($stat['hero_stat_number'])?>">
                            0
                        </div>
                        <div class="hero__stat-label">
                            <?= nl2br(esc_html($stat['hero_stat_label']))?>
                        </div>
                    </div>
                    <?php
endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>