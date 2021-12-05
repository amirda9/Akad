<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($products as $product)
        @if($product->image || $product->images->count())
            <url>
                <loc>{{ $product->getRoute() }}</loc>
                @if($product->image)
                    <image:image>
                        <image:title>{{ $product->title }}</image:title>
                        <image:loc>{{ getImageSrc($product->image,'product_large') }}</image:loc>
                    </image:image>
                @endif
                @foreach($product->images as $image)
                    <image:image>
                        <image:title>{{ $product->title }}</image:title>
                        <image:loc>{{ getImageSrc($image->src,'product_large') }}</image:loc>
                    </image:image>
                @endforeach
            </url>
        @endif
    @endforeach
</urlset>
