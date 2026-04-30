<?php

/**
 * Универсальная функция для получения всех версий изображения по ID или URL
 * @param mixed $image Может быть: ID вложения, URL изображения, массив ACF
 * @param string $size Размер WordPress (thumbnail, medium, large, full и т.д.)
 * @param string|bool $size_suffix Суффикс для ретины (например: '@2x', false - без 2x версий)
 * @return array Массив с путями ко всем версиям изображения
 */
function get_image_versions($image, $size = 'full', $size_suffix = '@2x') {
    // Получаем URL изображения в зависимости от типа входных данных
    $image_url = '';
    $image_id = 0;
    
    if (is_numeric($image)) {
        // Если передан ID
        $image_id = intval($image);
        $image_url = wp_get_attachment_image_url($image_id, $size);
    } elseif (is_array($image) && isset($image['url'])) {
        // Если передан массив ACF
        $image_url = $image['url'];
        $image_id = $image['ID'] ?? 0;
        
        // Если нужен конкретный размер и он есть в массиве ACF
        if ($size !== 'full' && isset($image['sizes'][$size])) {
            $image_url = $image['sizes'][$size];
        }
    } elseif (is_string($image)) {
        // Если передан URL
        $image_url = $image;
    }
    
    if (empty($image_url)) {
        return [];
    }
    
    // Базовое имя файла без расширения
    $pathinfo = pathinfo($image_url);
    $filename = $pathinfo['filename'];
    $extension = strtolower($pathinfo['extension'] ?? 'jpg');
    $directory = $pathinfo['dirname'];
    
    // Поддерживаемые форматы
    $supported_formats = ['jpg', 'jpeg', 'png', 'webp', 'avif'];
    
    // Проверяем формат
    if (!in_array($extension, $supported_formats)) {
        return [
            'original_1x' => $image_url,
            'webp_1x' => '',
            'avif_1x' => '',
            'original_2x' => '',
            'webp_2x' => '',
            'avif_2x' => '',
            'alt' => '',
            'format' => $extension,
            'id' => $image_id
        ];
    }
    
    // MIME-типы для разных форматов
    $mime_types = [
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'png' => 'image/png',
        'webp' => 'image/webp',
        'avif' => 'image/avif'
    ];
    
    // Определяем, нужно ли конвертировать в WebP/AVIF
    $can_convert_to_webp = in_array($extension, ['jpg', 'jpeg', 'png']);
    $is_webp = $extension === 'webp';
    $is_avif = $extension === 'avif';
    
    // 1x версии
    $original_1x = $image_url;
    $webp_1x = '';
    $avif_1x = '';
    
    // WebP версия (только для JPG/PNG, не для WebP/AVIF)
    if ($can_convert_to_webp) {
        // Для плагинов типа WebP Converter for Media
        $webp_1x = str_replace('/uploads/', '/uploads-webpc/uploads/', $directory) . '/' . $filename . '.' . $extension . '.webp';
        // Альтернативный путь (для других плагинов)
        $webp_1x_alt = $directory . '/' . $filename . '.webp';
    } elseif ($is_webp) {
        // Если уже WebP, используем оригинал
        $webp_1x = $image_url;
    }
    
    // AVIF версия (опционально, для новых браузеров)
    if ($can_convert_to_webp) {
        $avif_1x = $directory . '/' . $filename . '.avif';
    }
    
    // 2x версии (только если указан суффикс)
    $original_2x = '';
    $webp_2x = '';
    $avif_2x = '';
    
    if (!empty($size_suffix)) {
        $original_2x = $directory . '/' . $filename . $size_suffix . '.' . $extension;
        
        if ($can_convert_to_webp) {
            $webp_2x = str_replace('/uploads/', '/uploads-webpc/uploads/', $directory) . '/' . $filename . $size_suffix . '.' . $extension . '.webp';
        } elseif ($is_webp) {
            $webp_2x = $directory . '/' . $filename . $size_suffix . '.' . $extension;
        }
        
        if ($can_convert_to_webp) {
            $avif_2x = $directory . '/' . $filename . $size_suffix . '.avif';
        }
    }
    
    // Получаем alt текст если есть ID
    $alt_text = '';
    if ($image_id) {
        $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
    } elseif (is_array($image) && isset($image['alt'])) {
        $alt_text = $image['alt'];
    }
    
    // Получаем размеры изображения (если есть ID)
    $width = '';
    $height = '';
    if ($image_id) {
        $meta = wp_get_attachment_metadata($image_id);
        if ($meta) {
            if ($size === 'full' || !isset($meta['sizes'][$size])) {
                $width = $meta['width'] ?? '';
                $height = $meta['height'] ?? '';
            } else {
                $width = $meta['sizes'][$size]['width'] ?? '';
                $height = $meta['sizes'][$size]['height'] ?? '';
            }
        }
    }
    
    return [
        'original_1x' => $original_1x,
        'webp_1x' => $webp_1x,
        'avif_1x' => $avif_1x,
        'original_2x' => $original_2x,
        'webp_2x' => $webp_2x,
        'avif_2x' => $avif_2x,
        'alt' => $alt_text,
        'format' => $extension,
        'mime_type' => $mime_types[$extension] ?? 'application/octet-stream',
        'id' => $image_id,
        'width' => $width,
        'height' => $height
    ];
}

/**
 * Функция для вывода picture элемента
 * @param array $sources Массив с источниками изображения
 * @param array $attrs Атрибуты для тега img
 */
function the_picture_element($sources, $attrs = []) {
    if (empty($sources['original_1x'])) {
        return;
    }
    
    $default_attrs = [
        'width' => $sources['width'] ?? '',
        'height' => $sources['height'] ?? '',
        'alt' => $sources['alt'] ?? '',
        'loading' => 'lazy',
        'decoding' => 'async',
        'fetchpriority' => 'auto',
        'class' => ''
    ];
    
    $attrs = wp_parse_args($attrs, $default_attrs);
    
    // Автоматически добавляем дополнительные атрибуты для eager загрузки
    if ($attrs['loading'] === 'eager') {
        $attrs['decoding'] = 'async';
        $attrs['fetchpriority'] = 'high';
    } else {
        // Для lazy убираем лишние атрибуты
        unset($attrs['fetchpriority']);
        $attrs['decoding'] = 'async';
    }
    
    // Проверяем есть ли 2x версии
    $has_2x = !empty($sources['original_2x']);
    
    // Собираем доступные форматы для отображения
    $has_original = !empty($sources['original_1x']);
    $has_webp = !empty($sources['webp_1x']);
    $has_avif = !empty($sources['avif_1x']);
    
    // Определяем порядок форматов (от самого современного к базовому)
    $formats_order = [];
    if ($has_avif) $formats_order['avif'] = $sources;
    if ($has_webp) $formats_order['webp'] = $sources;
    if ($has_original) $formats_order['original'] = $sources;
    ?>
    
    <picture class="picture-element <?php echo esc_attr($attrs['class']); ?>">
        <?php if ($has_avif): ?>
            <!-- AVIF версии (наиболее сжатый формат) -->
            <source 
                srcset="<?php echo esc_url($sources['avif_1x']); ?><?php echo $has_2x && !empty($sources['avif_2x']) ? ', ' . esc_url($sources['avif_2x']) . ' 2x' : ''; ?>" 
                type="image/avif"
                <?php if (!empty($attrs['media'])): ?>media="<?php echo esc_attr($attrs['media']); ?>"<?php endif; ?>
            >
        <?php endif; ?>
        
        <?php if ($has_webp): ?>
            <!-- WebP версии -->
            <source 
                srcset="<?php echo esc_url($sources['webp_1x']); ?><?php echo $has_2x && !empty($sources['webp_2x']) ? ', ' . esc_url($sources['webp_2x']) . ' 2x' : ''; ?>" 
                type="image/webp"
                <?php if (!empty($attrs['media'])): ?>media="<?php echo esc_attr($attrs['media']); ?>"<?php endif; ?>
            >
        <?php endif; ?>
        
        <?php if ($has_original): ?>
            <!-- Оригинальные версии -->
            <source 
                srcset="<?php echo esc_url($sources['original_1x']); ?><?php echo $has_2x ? ', ' . esc_url($sources['original_2x']) . ' 2x' : ''; ?>" 
                type="<?php echo esc_attr($sources['mime_type']); ?>"
                <?php if (!empty($attrs['media'])): ?>media="<?php echo esc_attr($attrs['media']); ?>"<?php endif; ?>
            >
        <?php endif; ?>
        
        <!-- Fallback изображение -->
        <img 
            src="<?php echo esc_url($sources['original_1x']); ?>" 
            <?php if ($has_2x): ?>
            srcset="<?php echo esc_url($sources['original_2x']); ?> 2x"
            <?php endif; ?>
            <?php if (!empty($attrs['width'])): ?>
            width="<?php echo esc_attr($attrs['width']); ?>"
            <?php endif; ?>
            <?php if (!empty($attrs['height'])): ?>
            height="<?php echo esc_attr($attrs['height']); ?>"
            <?php endif; ?>
            alt="<?php echo esc_attr($attrs['alt']); ?>"
            loading="<?php echo esc_attr($attrs['loading']); ?>"
            <?php if ($attrs['loading'] === 'eager'): ?>
            decoding="<?php echo esc_attr($attrs['decoding']); ?>"
            fetchpriority="<?php echo esc_attr($attrs['fetchpriority']); ?>"
            <?php else: ?>
            decoding="<?php echo esc_attr($attrs['decoding']); ?>"
            <?php endif; ?>
            class="picture-img <?php echo esc_attr($attrs['class']); ?>"
        >
    </picture>
    <?php
}

/**
 * Упрощенная функция для быстрого вывода изображения
 * @param mixed $image ID, URL или массив ACF
 * @param string $size Размер изображения
 * @param array $attrs Дополнительные атрибуты
 * @param string|bool $size_suffix Суффикс для ретины
 */
function the_image($image, $size = 'full', $attrs = [], $size_suffix = '@2x') {
    $sources = get_image_versions($image, $size, $size_suffix);
    if (!empty($sources['original_1x'])) {
        the_picture_element($sources, $attrs);
    }
}

/**
 * Примеры использования:
 * 
 * // По ID
 * the_image(123, 'large', ['class' => 'my-image', 'loading' => 'eager']);
 * 
 * // По URL
 * the_image('https://example.com/image.jpg', 'medium', ['alt' => 'Description']);
 * 
 * // Из ACF
 * $image = get_field('photo');
 * the_image($image, 'full', ['class' => 'responsive-img']);
 */