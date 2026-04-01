<?php
/**
 * Block: testimonials
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Якщо це прев'ю в адмінці і ми маємо placeholder картинку
if ($is_preview && isset($block['data']['preview_image_help'])) {
    $preview_image_url = get_template_directory_uri() . '/blocks/testimonials/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = 'testimonials-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Fields
$title = get_field('title') ?: 'ВІДГУКИ УЧАСНИКІВ';
$testimonials = get_field('testimonials_items');

// Mock data для прев'ю (коли ще нема ACF-даних)
if (empty($testimonials)) {
    $testimonials = [
        [
            'avatar' => '',
            'name' => 'Олена Ковальчук',
            'rating' => 5,
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Умовний рибний текст застосовується для демонстрації структури документа, заповнення шаблонів та перевірки візуального стилю.',
            'button_text' => 'БІЛЬШЕ ПРО HUSTLEHUB',
            'button_url' => '#',
        ],
        [
            'avatar' => '',
            'name' => 'Марина Палай',
            'rating' => 5,
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Умовний рибний текст застосовується для демонстрації структури документа, заповнення шаблонів та перевірки візуального стилю.',
            'button_text' => 'БІЛЬШЕ ПРО HUSTLEHUB',
            'button_url' => '#',
        ],
        [
            'avatar' => '',
            'name' => 'Петро Головій',
            'rating' => 5,
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Умовний рибний текст застосовується для демонстрації структури документа, заповнення шаблонів та перевірки візуального стилю.',
            'button_text' => 'БІЛЬШЕ ПРО HUSTLEHUB',
            'button_url' => '#',
        ],
        [
            'avatar' => '',
            'name' => 'Світлана Діденко',
            'rating' => 4,
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Умовний рибний текст застосовується для демонстрації структури документа, заповнення шаблонів та перевірки візуального стилю.',
            'button_text' => 'БІЛЬШЕ ПРО HUSTLEHUB',
            'button_url' => '#',
        ],
        [
            'avatar' => '',
            'name' => 'Андрій Мельник',
            'rating' => 5,
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Умовний рибний текст застосовується для демонстрації структури документа, заповнення шаблонів та перевірки візуального стилю.',
            'button_text' => 'БІЛЬШЕ ПРО HUSTLEHUB',
            'button_url' => '#',
        ],
        [
            'avatar' => '',
            'name' => 'Ірина Козак',
            'rating' => 5,
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Умовний рибний текст застосовується для демонстрації структури документа, заповнення шаблонів та перевірки візуального стилю.',
            'button_text' => 'БІЛЬШЕ ПРО HUSTLEHUB',
            'button_url' => '#',
        ],
    ];
}
?>

<section <?= $anchor ?> class="<?= esc_attr($class_name) ?>">
    <div class="container">
        <?php if ($title): ?>
            <h2 class="testimonials__title"><?= esc_html($title); ?></h2>
        <?php endif; ?>
    </div>

    <?php if ($testimonials): ?>
        <div class="testimonials__slider-wrapper">
            <div class="swiper testimonials__swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($testimonials as $item): ?>
                        <div class="swiper-slide testimonials__slide">
                            <div class="testimonials__card">
                                <!-- Header: Avatar + Name + Rating -->
                                <div class="testimonials__card-header">
                                    <div class="testimonials__avatar">
                                        <?php if (!empty($item['avatar'])): ?>
                                            <?= wp_get_attachment_image($item['avatar'], 'thumbnail', false, ['class' => 'testimonials__avatar-img']); ?>
                                        <?php else: ?>
                                            <div class="testimonials__avatar-placeholder">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                                        stroke="white" stroke-opacity="0.5" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                    <path
                                                        d="M20.5899 22C20.5899 18.13 16.7399 15 11.9999 15C7.25991 15 3.40991 18.13 3.40991 22"
                                                        stroke="white" stroke-opacity="0.5" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="testimonials__meta">
                                        <span class="testimonials__name"><?= esc_html($item['name']); ?></span>
                                        <div class="testimonials__rating">
                                            <?php
                                            $rating = intval($item['rating'] ?? 5);
                                            for ($i = 1; $i <= 5; $i++):
                                                ?>
                                                <svg class="testimonials__star <?= $i <= $rating ? 'is-filled' : '' ?>" width="16"
                                                    height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M8 1.33337L10.06 5.50671L14.6667 6.18004L11.3333 9.42671L12.12 14.0134L8 11.8467L3.88 14.0134L4.66667 9.42671L1.33333 6.18004L5.94 5.50671L8 1.33337Z"
                                                        fill="<?= $i <= $rating ? '#4E63FF' : 'rgba(255,255,255,0.1)' ?>"
                                                        stroke="<?= $i <= $rating ? '#4E63FF' : 'rgba(255,255,255,0.1)' ?>"
                                                        stroke-width="1" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <!-- Body: Review Text -->
                                <div class="testimonials__card-body">
                                    <p class="testimonials__text"><?= esc_html($item['text']); ?></p>
                                </div>

                                <!-- Footer: Button -->
                                <?php
                                $btn_url = !empty($item['button_url']) ? $item['button_url'] : '#';
                                $btn_text = !empty($item['button_text']) ? $item['button_text'] : 'БІЛЬШЕ ПРО HUSTLEHUB';
                                ?>
                                <div class="testimonials__card-footer">
                                    <a href="<?= esc_url($btn_url); ?>" class="btn btn-secondary btn-sm testimonials__btn">
                                        <?= esc_html($btn_text); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div> <!-- /.swiper-wrapper -->
            </div> <!-- /.swiper -->

            <!-- Navigation -->
            <div class="testimonials__slider-nav">
                <button class="swiper-button-prev testimonials__swiper-prev" aria-label="Попередній відгук">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15 18.6004L9.56667 13.1671C8.925 12.5254 8.925 11.4754 9.56667 10.8337L15 5.40039"
                            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
                <button class="swiper-button-next testimonials__swiper-next" aria-label="Наступний відгук">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M9.08496 18.6004L14.5183 13.1671C15.16 12.5254 15.16 11.4754 14.5183 10.8337L9.08496 5.40039"
                            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </button>
            </div>
        </div> <!-- /.testimonials__slider-wrapper -->
    <?php endif; ?>
</section>