<?php
/**
 * Block: cta-final
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Якщо це прев'ю в адмінці і ми маємо placeholder картинку
if ($is_preview && isset($block['data']['preview_image_help'])) {
    $preview_image_url = get_template_directory_uri() . '/blocks/cta-final/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = 'cta-final-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Fields
$title = get_field('title') ?: 'ПРАГНЕШ ЗМІНИТИ СВОЄ ЖИТТЯ НА КРАЩЕ?';
$subtitle = get_field('subtitle') ?: 'Залишився всього один маленький крок... Готовий зробити його?';
$btn_text = get_field('button_text') ?: 'ТАК, ПОЧАТИ ЗМІНИ!';
$btn_url = get_field('button_url') ?: '#';
?>

<section <?= $anchor ?> class="<?= esc_attr($class_name) ?>">
    <div class="container">
        <div class="cta-final__inner">
            <?php if ($title): ?>
                <h2 class="cta-final__title"><?= esc_html($title); ?></h2>
            <?php endif; ?>

            <?php if ($subtitle): ?>
                <p class="cta-final__subtitle"><?= esc_html($subtitle); ?></p>
            <?php endif; ?>

            <div class="cta-final__action">
                <div class="cta-final__glow" aria-hidden="true"></div>
                <a href="<?= esc_url($btn_url); ?>" class="btn btn-primary btn-lg cta-final__btn">
                    <?= esc_html($btn_text); ?>
                    <span class="btn__icon">
                        <svg width="20" height="15" viewBox="0 0 20 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4.6752 0.749714C4.6752 0.339615 5.0143 0.000488281 5.4245 0.000488281L14.0085 0C14.4186 0 14.7584 0.339841 14.7584 0.74994V9.33464C14.7583 9.54665 14.6731 9.73072 14.5388 9.86498C14.4046 9.99898 14.2209 10.0837 14.0092 10.0839C13.5991 10.0839 13.2593 9.74415 13.2593 9.33393V2.55982L2.518 13.3011C2.2281 13.5911 1.7472 13.5911 1.4573 13.3011C1.1674 13.0112 1.1674 12.5303 1.4573 12.2404L12.1986 1.49919H5.4245C5.0143 1.49919 4.6752 1.15981 4.6752 0.749714Z"
                                fill="white" />
                        </svg>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>