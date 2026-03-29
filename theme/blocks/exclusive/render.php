<?php
/**
 * Block: exclusive
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Previews
if ($is_preview && isset($block['data']['preview_image_help'])) {
    $preview_image_url = get_template_directory_uri() . '/blocks/exclusive/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = 'exclusive-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

$title = get_field('exclusive_title') ?: 'ЕКСКЛЮЗИВНО ДЛЯ УЧАСНИКІВ';
$cards = get_field('exclusive_cards');
$btn_text = get_field('exclusive_button_text') ?: 'ПЕРЕЙТИ ДО ПРОДУКТІВ';
$btn_url = get_field('exclusive_button_url') ?: '#';

// Якщо ми в Гутенбергу (режим превью) і карток ще немає, додаємо заглушки для наочності:
if ($is_preview && empty($cards)) {
    $cards = [
        [
            'image' => false, // картинки немає
            'feature_title' => '“ХОЧУ” = “МОЖУ”',
            'feature_description' => 'Заглушка тексту: Ми перетворюємо "хочу" на "можу" через практичні інструменти...'
        ],
        [
            'image' => false,
            'feature_title' => 'РОЗУМНА СВОБОДА',
            'feature_description' => 'Заглушка тексту: Ми не продаємо ілюзії...'
        ],
        [
            'image' => false,
            'feature_title' => 'КОМ’ЮНІТІ ОДНОДУМЦІВ',
            'feature_description' => 'Заглушка тексту: Тут не тільки люди зі схожими цілями...'
        ],
        [
            'image' => false,
            'feature_title' => 'ВИНЯТКОВІ ПРОПОЗИЦІЇ',
            'feature_description' => 'Заглушка тексту: Від готових працюючих бізнес-ідей...'
        ]
    ];
}
?>

<section <?= $anchor ?> class="<?= esc_attr($class_name) ?>">
    <div class="container">
        <div class="exclusive__inner">
            <?php if ($title): ?>
                <h2 class="exclusive__title reveal">
                    <?= esc_html($title); ?>
                </h2>
            <?php endif; ?>

            <?php if ($cards): ?>
                <div class="exclusive__grid">
                    <?php foreach ($cards as $index => $item): 
                        $delay = ($index % 4) + 1;
                    ?>
                        <div class="exclusive__card reveal reveal-d<?= $delay; ?>">
                            <div class="exclusive__card-glow" aria-hidden="true"></div>
                            <div class="exclusive__card-image">
                                <?php if (!empty($item['image']) && isset($item['image']['url'])): ?>
                                    <img src="<?= esc_url(isset($item['image']['sizes']['large']) ? $item['image']['sizes']['large'] : $item['image']['url']); ?>" alt="<?= esc_attr(isset($item['image']['alt']) ? $item['image']['alt'] : ''); ?>" loading="lazy">
                                <?php else: ?>
                                    <div class="exclusive__placeholder">No Image</div>
                                <?php endif; ?>
                            </div>
                            <div class="exclusive__card-content">
                                <h3 class="exclusive__card-title"><?= esc_html($item['feature_title']); ?></h3>
                                <p class="exclusive__card-desc"><?= esc_html($item['feature_description']); ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <div class="exclusive__footer reveal">
                <a href="<?= esc_url($btn_url); ?>" class="btn btn-primary btn-lg">
                    <?= esc_html($btn_text); ?>
                    <span class="btn__icon">
                        <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M4.6752 0.749714C4.6752 0.339615 5.0143 0.000488281 5.4245 0.000488281L14.0085 0C14.4186 0 14.7584 0.339841 14.7584 0.74994V9.33464C14.7583 9.54665 14.6731 9.73072 14.5388 9.86498C14.4046 9.99898 14.2209 10.0837 14.0092 10.0839C13.5991 10.0839 13.2593 9.74415 13.2593 9.33393V2.55982L2.518 13.3011C2.2281 13.5911 1.7472 13.5911 1.4573 13.3011C1.1674 13.0112 1.1674 12.5303 1.4573 12.2404L12.1986 1.49919H5.4245C5.0143 1.49919 4.6752 1.15981 4.6752 0.749714Z" fill="white" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
