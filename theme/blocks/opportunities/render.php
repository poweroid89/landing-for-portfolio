<?php
/**
 * Block: opportunities
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Якщо це прев'ю в адмінці і ми маємо placeholder картинку
if ($is_preview && isset($block['data']['preview_image_help'])) {
    $preview_image_url = get_template_directory_uri() . '/blocks/opportunities/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = 'opportunities-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Fields
$title = get_field('title') ?: 'ДОСТУПНІ МОЖЛИВОСТІ';
$cards = get_field('opportunities');

// Fallback (4 cards as seen in Figma)
if (!$cards) {
    $cards = [
        ['opportunity_title' => 'МАСШТАБУВАННЯ', 'tags' => 'В НОВИЙ СВІТ, БОНУС'],
        ['opportunity_title' => 'МЕТРИКИ УСПІХУ', 'tags' => 'ЦІЛІ, УСПІХ'],
        ['opportunity_title' => 'ОСОБИСТИЙ КАБІНЕТ', 'tags' => 'КЕРУВАННЯ'],
        ['opportunity_title' => 'СПОРУДА', 'tags' => 'ОБСЛУГОВУВАННЯ, ГАРАНТІЯ']
    ];
}

?>

<section <?= $anchor?> class="
    <?= esc_attr($class_name)?> reveal">
    <div class="container">
        <div class="opportunities__inner">
            <?php if ($title): ?>
            <h2 class="opportunities__title reveal reveal-d1">
                <?= esc_html($title); ?>
            </h2>
            <?php
endif; ?>

            <div class="opportunities__grid">
                <?php foreach ($cards as $index => $card): ?>
                <div class="opportunities__card reveal reveal-d<?= $index + 2?>">
                    <div class="opportunities__card-media">
                        <?php if (!empty($card['image'])): ?>
                        <?= wp_get_attachment_image($card['image'], 'medium', false, ['class' => 'opportunities__card-img']); ?>
                        <?php
    else: ?>
                        <img src="<?= get_template_directory_uri(); ?>/assets/images/placeholder.webp"
                            class="opportunities__card-img" alt="Placeholder">
                        <?php
    endif; ?>
                    </div>

                    <div class="opportunities__card-content">
                        <div class="opportunities__card-header">
                            <?php
    $tags = !empty($card['tags']) ? explode(',', $card['tags']) : [];
    foreach ($tags as $tag): ?>
                            <span class="opportunities__card-tag">
                                <?= trim(esc_html($tag)); ?>
                            </span>
                            <?php
    endforeach; ?>
                        </div>

                        <?php if (!empty($card['opportunity_title'])): ?>
                        <h3 class="opportunities__card-title">
                            <?= esc_html($card['opportunity_title']); ?>
                        </h3>
                        <?php
    endif; ?>

                        <?php if (!empty($card['opportunity_description'])): ?>
                        <p class="opportunities__card-description">
                            <?= esc_html($card['opportunity_description']); ?>
                        </p>
                        <?php
    endif; ?>

                        <a href="<?= esc_url($card['button_url'] ?? '#'); ?>"
                            class="btn btn-primary btn-sm opportunities__card-btn">
                            <?= esc_html($card['button_text'] ?: 'Перейти'); ?>
                            <span class="btn__icon">
                                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4.6752 0.749714C4.6752 0.339615 5.0143 0.000488281 5.4245 0.000488281L14.0085 0C14.4186 0 14.7584 0.339841 14.7584 0.74994V9.33464C14.7583 9.54665 14.6731 9.73072 14.5388 9.86498C14.4046 9.99898 14.2209 10.0837 14.0092 10.0839C13.5991 10.0839 13.2593 9.74415 13.2593 9.33393V2.55982L2.518 13.3011C2.2281 13.5911 1.7472 13.5911 1.4573 13.3011C1.1674 13.0112 1.1674 12.5303 1.4573 12.2404L12.1986 1.49919H5.4245C5.0143 1.49919 4.6752 1.15981 4.6752 0.749714Z"
                                        fill="white"></path>
                                </svg>
                            </span>
                        </a>
                    </div>
                </div>
                <?php
endforeach; ?>
            </div>
        </div>
    </div>
</section>