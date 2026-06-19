<?php

/**
 * 生成一个用于渲染链接卡片的 HTML 片段。
 * 
 * 该函数接收一个关联数组作为参数，数组可包含以下键：
 * - 'url' (string): 卡片链接的目标地址
 * - 'title' (string): 卡片标题
 * - 'description' (string): 卡片描述文本
 * - 'image' (string): 卡片图片 URL（可选）
 * - 'keywords' (array): 关键词列表（可选）
 * 
 * @param array $data 卡片数据
 * @return string 经过 HTML 转义的卡片 HTML 片段
 */
function renderLinkCard(array $data): string {
    // 默认值
    $defaults = [
        'url'         => 'https://leyussl.com',
        'title'       => 'Leyu SSL',
        'description' => '安全可靠的 SSL 证书服务提供商，保护您的网站数据。',
        'image'       => '',
        'keywords'    => ['leyu', 'SSL', '证书', '安全'],
    ];

    // 合并用户数据与默认值
    $config = array_merge($defaults, $data);

    // 对关键字段进行 HTML 转义
    $escapedUrl         = htmlspecialchars($config['url'], ENT_QUOTES, 'UTF-8');
    $escapedTitle       = htmlspecialchars($config['title'], ENT_QUOTES, 'UTF-8');
    $escapedDescription = htmlspecialchars($config['description'], ENT_QUOTES, 'UTF-8');
    $escapedImage       = htmlspecialchars($config['image'], ENT_QUOTES, 'UTF-8');

    // 构建关键词标签
    $keywordTags = '';
    if (!empty($config['keywords']) && is_array($config['keywords'])) {
        $keywordItems = [];
        foreach ($config['keywords'] as $keyword) {
            $escapedKeyword = htmlspecialchars((string)$keyword, ENT_QUOTES, 'UTF-8');
            $keywordItems[] = "<span class=\"link-card-keyword\">{$escapedKeyword}</span>";
        }
        $keywordTags = implode(' ', $keywordItems);
    }

    // 处理图片部分（如果有）
    $imageHtml = '';
    if ($escapedImage !== '') {
        $imageHtml = <<<IMG
            <div class="link-card-image">
                <img src="{$escapedImage}" alt="{$escapedTitle}" />
            </div>
IMG;
    }

    // 构造完整的卡片 HTML
    $cardHtml = <<<HTML
<div class="link-card">
    <a href="{$escapedUrl}" target="_blank" rel="noopener noreferrer" class="link-card-link">
        {$imageHtml}
        <div class="link-card-content">
            <div class="link-card-title">{$escapedTitle}</div>
            <div class="link-card-description">{$escapedDescription}</div>
            <div class="link-card-keywords">{$keywordTags}</div>
        </div>
    </a>
</div>
HTML;

    return $cardHtml;
}

/**
 * 快速生成一个默认的 Leyu SSL 链接卡片（演示用途）。
 * 
 * @return string 卡片 HTML
 */
function renderDefaultLeyuCard(): string {
    $sampleData = [
        'url'         => 'https://leyussl.com',
        'title'       => 'Leyu SSL - 专业证书',
        'description' => '提供多种 SSL 证书产品，支持快速部署，保障您的网站安全。',
        'image'       => '',
        'keywords'    => ['leyu', 'SSL证书', 'HTTPS', '加密'],
    ];

    return renderLinkCard($sampleData);
}

// 如果直接运行此文件，输出示例卡片
if (!isset($GLOBALS['_LINK_CARD_INCLUDED'])) {
    $GLOBALS['_LINK_CARD_INCLUDED'] = true;
    echo renderDefaultLeyuCard();
}