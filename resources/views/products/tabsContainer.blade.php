<div class="shadow-sm">
    <nav class="bg-light border product-tabs-container">
        <div class="nav nav-tabs border-bottom-0" id="nav-tab" role="tablist">
            @if(!empty($product->full_description))
                <a class="tab-button p-3 border-left active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true">
                    <h5 class="m-0"><i class="fal fa-file-alt ml-2"></i> <span class="d-none d-md-inline tab-title">توضیحات کامل</span></h5>
                </a>
            @endif

            <a class="tab-button p-3 border-left {{ empty($product->full_description) ? 'active' : '' }}" id="nav-attributes-tab" data-toggle="tab" href="#nav-attributes" role="tab" aria-controls="nav-attributes" aria-selected="true">
                <h5 class="m-0"><i class="fal fa-list-alt ml-2"></i> <span class="d-none d-md-inline tab-title">مشخصات محصول</span></h5>
            </a>

        </div>
    </nav>
    <div class="tab-content p-3 p-md-5 border border-top-0 mb-4 bg-white" id="nav-tabContent">
        @if(!empty($product->full_description))
            <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                @include('products.fullDescriptionTab',['product' => $product ?? false])
            </div>
        @endif
        <div class="tab-pane fade show {{ empty($product->full_description) ? 'active' : '' }}" id="nav-attributes" role="tabpanel" aria-labelledby="nav-attributes-tab">
            @include('products.productAttributes',['attribute_groups' => $attribute_groups ?? false])
        </div>
    </div>
</div>
