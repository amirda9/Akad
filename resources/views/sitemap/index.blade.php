<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>

<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    @if($product)
        <sitemap>
            <loc>{{ route('sitemap.products') }}</loc>
            <lastmod>{{ $product->updated_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </sitemap>
        <sitemap>
            <loc>{{ route('sitemap.images') }}</loc>
            <lastmod>{{ $product->updated_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </sitemap>
    @endif
    @if($category)
        <sitemap>
            <loc>{{ route('sitemap.categories') }}</loc>
            <lastmod>{{ $category->updated_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </sitemap>
    @endif
    @if($page)
        <sitemap>
            <loc>{{ route('sitemap.pages') }}</loc>
            <lastmod>{{ $page->updated_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </sitemap>
    @endif
    @if($tag)
        <sitemap>
            <loc>{{ route('sitemap.tags') }}</loc>
            <lastmod>{{ $tag->updated_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </sitemap>
    @endif
    @if($latest_branded_product)
        <sitemap>
            <loc>{{ route('sitemap.brands') }}</loc>
            <lastmod>{{ $latest_branded_product->updated_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </sitemap>
    @endif
    @if($latest_article_category)
        <sitemap>
            <loc>{{ route('sitemap.articleCategories') }}</loc>
            <lastmod>{{ $latest_article_category->updated_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </sitemap>
    @endif
    @if($latest_article)
        <sitemap>
            <loc>{{ route('sitemap.articles') }}</loc>
            <lastmod>{{ $latest_article->updated_at->tz('Asia/Tehran')->toAtomString() }}</lastmod>
        </sitemap>
    @endif
</sitemapindex>
