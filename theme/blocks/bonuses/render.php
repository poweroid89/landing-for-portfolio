<?php
/**
 * Block: bonuses
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Previews
if ($is_preview && isset($block['data']['preview_image_help'])) {
    $preview_image_url = get_template_directory_uri() . '/blocks/bonuses/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = 'bonuses-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Fields
$title = get_field('bonuses_title') ?: 'КРУТІ БОНУСИ!';
$description = get_field('bonuses_description');
$image = get_field('bonuses_image');
$btn_text = get_field('bonuses_button_text') ?: 'ПЕРЕЙТИ ДО ПРОДУКТІВ';
$btn_url = get_field('bonuses_button_url') ?: '#';
$old_price = get_field('bonuses_old_price') ?: '$65';
$new_price = get_field('bonuses_new_price') ?: '$0';
$bonuses_list = get_field('bonuses_list');

// Fallback for preview
if ($is_preview && empty($bonuses_list)) {
    $description = "Ми реально запарились над тим, щоб створити по-справжньому корисні бонусні продукти.\n\nКожен із них 100% стане у нагоді для наших учасників, достатньо придбати 1 продукт і бонуси твої назавжди!";
    $bonuses_list = [
        [
            'bonus_icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M5 20H19M7 16V8M12 16V4M17 16V10" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>',
            'bonus_title' => 'Відстеження витрат',
            'bonus_old_price' => '$10.00',
            'bonus_new_price' => '$0.00'
        ],
        [
            'bonus_icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M14 2H6C4.89543 2 4 2.89543 4 4V20C4 21.1046 4.89543 22 6 22H18C19.1046 22 20 21.1046 20 20V8L14 2Z" stroke="white" stroke-width="2" stroke-linejoin="round"/><path d="M14 2V8H20" stroke="white" stroke-width="2" stroke-linejoin="round"/><path d="M16 13H8M16 17H8M10 9H8" stroke="white" stroke-width="2" stroke-linecap="round"/></svg>',
            'bonus_title' => 'Базовий курс по Notion',
            'bonus_old_price' => '$30.00',
            'bonus_new_price' => '$0.00'
        ],
        [
            'bonus_icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none"><path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" stroke="white" stroke-width="2" stroke-linejoin="round"/></svg>',
            'bonus_title' => 'Підвищення продуктивності',
            'bonus_old_price' => '$25.00',
            'bonus_new_price' => '$0.00'
        ]
    ];
}
?>

<section <?= $anchor ?> class="<?= esc_attr($class_name) ?>">
    <div class="container">
        <div class="bonuses__inner">
            <div class="bonuses__header">
                <div class="bonuses__price-badge reveal reveal-d1">
                    <span class="bonuses__old-price"><?= esc_html($old_price); ?></span>
                    <span class="bonuses__new-price"><?= esc_html($new_price); ?></span>
                </div>
                <h2 class="bonuses__title reveal"><?= esc_html($title); ?></h2>
            </div>

            <div class="bonuses__content">
                <!-- Left side -->
                <div class="bonuses__left reveal reveal-d1">
                    <?php if ($description): ?>
                        <div class="bonuses__description">
                            <?= nl2br(esc_html($description)); ?>
                        </div>
                    <?php endif; ?>

                    <div class="bonuses__image desktop-image">
                        <?php if (!empty($image) && isset($image['url'])): ?>
                            <img src="<?= esc_url(isset($image['sizes']['large']) ? $image['sizes']['large'] : $image['url']); ?>"
                                alt="<?= esc_attr(isset($image['alt']) ? $image['alt'] : ''); ?>" loading="lazy">
                        <?php else: ?>
                            <div class="bonuses__placeholder-img">Зображення</div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Right side -->
                <div class="bonuses__right">
                    <?php if ($bonuses_list): ?>
                        <div class="bonuses__list">
                            <?php foreach ($bonuses_list as $index => $item): ?>
                                <?php $delay = ($index % 3) + 2; ?>
                                <div class="bonuses__item reveal reveal-d<?= $delay; ?>">
                                    <div class="bonuses__item-left">
                                        <div class="bonuses__item-icon">
                                            <?= $item['bonus_icon'] ? $item['bonus_icon'] : ''; ?>
                                        </div>
                                        <h3 class="bonuses__item-title"><?= esc_html($item['bonus_title']); ?></h3>
                                    </div>
                                    <div class="bonuses__item-price">
                                        <span class="bonuses__item-old-price"><?= esc_html($item['bonus_old_price']); ?></span>
                                        <span class="bonuses__item-new-price"><?= esc_html($item['bonus_new_price']); ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <div class="bonuses__cta reveal reveal-d4">
                        <a href="<?= esc_url($btn_url); ?>" class="btn btn-primary btn-lg bonuses__btn">
                            <?= esc_html($btn_text); ?>
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

                <!-- Mobile Image appended below -->
                <div class="bonuses__image mobile-image reveal reveal-d5">
                    <?php if (!empty($image) && isset($image['url'])): ?>
                        <img src="<?= esc_url(isset($image['sizes']['large']) ? $image['sizes']['large'] : $image['url']); ?>"
                            alt="<?= esc_attr(isset($image['alt']) ? $image['alt'] : ''); ?>" loading="lazy">
                    <?php else: ?>
                        <div class="bonuses__placeholder-img">Зображення</div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</section>