<?php
/**
 * Block: why-it-works
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Якщо це прев'ю в адмінці і ми маємо placeholder картинку
if ($is_preview && isset($block['data']['preview_image_help'])) {
    $preview_image_url = get_template_directory_uri() . '/blocks/why-it-works/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = 'why-it-works-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Fields
$title = get_field('title') ?: 'ЧОМУ ЦЕ ПРАЦЮЄ?';
$cards = get_field('cards');

// Fallback content (на випадок якщо блок щойно створений)
if (!$cards) {
    $cards = [
        [
            'card_title' => 'Практичність',
            'card_text' => 'Акцент на реальних змінах у вашому житті через системний підхід.',
            'icon' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>'
        ],
        [
            'card_title' => 'Ефективність',
            'card_text' => '96% учасників відзначають позитивні зміни вже після першого місяця.',
            'icon' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 8l4 4-4 4M8 12h8"/></svg>'
        ],
        [
            'card_title' => 'Ком’юніті',
            'card_text' => 'Підтримка від сотень однодумців, які рухаються разом у спільному напрямку.',
            'icon' => '<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
        ]
    ];
}

?>

<section <?=$anchor?> class="
    <?= esc_attr($class_name)?>">
    <div class="container">
        <div class="why-it-works__inner reveal">
            <?php if ($title): ?>
            <h2 class="why-it-works__title reveal reveal-d1">
                <?= esc_html($title); ?>
            </h2>
            <?php
endif; ?>

            <?php if ($cards): ?>
            <div class="why-it-works__grid">
                <?php foreach ($cards as $index => $card): ?>
                <div class="why-it-works__card reveal reveal-d<?= $index + 2?>">
                    <?php if ($card['icon']): ?>
                    <div class="why-it-works__card-icon">
                        <?= $card['icon']; ?>
                    </div>
                    <?php
        endif; ?>

                    <?php if ($card['card_title']): ?>
                    <h3 class="why-it-works__card-title">
                        <?= esc_html($card['card_title']); ?>
                    </h3>
                    <?php
        endif; ?>

                    <?php if ($card['card_text']): ?>
                    <p class="why-it-works__card-text">
                        <?= esc_html($card['card_text']); ?>
                    </p>
                    <?php
        endif; ?>
                </div>
                <?php
    endforeach; ?>
            </div>
            <?php
endif; ?>
        </div>
    </div>
</section>