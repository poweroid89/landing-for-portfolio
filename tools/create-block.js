const fs = require("fs");
const path = require("path");

const blockName = process.argv[2];

if (!blockName) {
  console.log("\x1b[31mError: Provide a block name (example: npm run block hero)\x1b[0m");
  process.exit();
}

// Ensure the name is lowercase/kebab-case
const slug = blockName.toLowerCase().replace(/\s+/g, '-');
const blockDir = path.join(__dirname, "../theme/blocks", slug);

if (fs.existsSync(blockDir)) {
  console.log(`\x1b[33mBlock '${slug}' already exists.\x1b[0m`);
  process.exit();
}

fs.mkdirSync(blockDir, { recursive: true });

// 1. block.json
const blockJson = {
  "name": `acf/${slug}`,
  "title": slug.charAt(0).toUpperCase() + slug.slice(1).replace('-', ' '),
  "description": `Custom ${slug} block`,
  "category": "landing-for-portfolio",
  "icon": "layout",
  "keywords": [slug],
  // Шлях до скомпільованого CSS (залежить від Gulp)
  "style": `file:../../assets/css/${slug}/style.css`,
  "acf": {
      "mode": "preview",
      "renderTemplate": "render.php"
  },
  "supports": {
      "align": ["wide", "full"]
  },
  "example": {
      "attributes": {
          "mode": "preview",
          "data": {
              "preview_image_help": "preview_block.jpg"
          }
      }
  }
};

// 2. render.php
const renderPhp = `<?php
/**
 * Block: ${slug}
 */

$is_preview = isset($is_preview) ? $is_preview : false;

// Якщо це прев'ю в адмінці і ми маємо placeholder картинку
if ( $is_preview && isset($block['data']['preview_image_help']) ) {
    $preview_image_url = get_template_directory_uri() . '/blocks/${slug}/' . $block['data']['preview_image_help'];
    echo '<img src="' . esc_url($preview_image_url) . '" style="width:100%; height:auto; display:block;" alt="Block Preview">';
    return;
}

$anchor = '';
if (!empty($block['anchor'])) {
    $anchor = 'id="' . esc_attr($block['anchor']) . '" ';
}

// Block classes
$class_name = '${slug}-block';
if (!empty($block['className'])) {
    $class_name .= ' ' . $block['className'];
}

// Fields
$type = get_field('layout_type') ?: 'default';
$title = get_field('title');

?>

<section <?= $anchor ?> class="<?= esc_attr($class_name) ?> ${slug}--<?= esc_attr($type) ?>">
    <div class="container ${slug}__inner">
        <?php if ($title) : ?>
            <h2 class="${slug}__title"><?= esc_html($title); ?></h2>
        <?php endif; ?>

        <div class="${slug}__content">
            <?php // Block content goes here ?>
        </div>
    </div>
</section>
`;

// 3. style.scss
const scss = `@import "../../../src/scss/abstracts/variables";
@import "../../../src/scss/abstracts/mixins";

.${slug}-block {
  padding: 60px 0;

  @include media-up(lg) {
      padding: 100px 0;
  }

  &__title {
      margin-bottom: 30px;
  }
}

// Variations
.${slug}--dark {
  background: var(--color-dark, #000);
  color: #fff;
}
`;

// 4. script.js (optional)
const js = `/**
 * JS for block: ${slug}
 */
console.log('${slug} block initialized');
`;

// 5. preview_block.jpg заглушка (просто мінімальний валідний base64 JPG)
// Щоб ACF не видавав 404 помилку, ми створюємо файл заглушки
const placeholderJpgBase64 = "/9j/4AAQSkZJRgABAQEASABIAAD/2wBDAP//////////////////////////////////////////////////////////////////////////////////////wgALCAABAAEBAREA/8QAFBABAAAAAAAAAAAAAAAAAAAAAP/aAAgBAQABPxA=";

fs.writeFileSync(path.join(blockDir, "block.json"), JSON.stringify(blockJson, null, 2));
fs.writeFileSync(path.join(blockDir, "render.php"), renderPhp);
fs.writeFileSync(path.join(blockDir, "style.scss"), scss);
fs.writeFileSync(path.join(blockDir, "script.js"), js);
fs.writeFileSync(path.join(blockDir, "preview_block.jpg"), Buffer.from(placeholderJpgBase64, 'base64'));

console.log(`\x1b[32m✔ Block Created: theme/blocks/${slug}/\x1b[0m`);
