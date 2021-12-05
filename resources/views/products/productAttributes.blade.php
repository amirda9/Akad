@if($attribute_groups ?? false)
    <div class="">
        <h2 class="text-secondary">مشخصات محصول :</h2>
        <h5 class="text-gray-600">{{ $product->title }}</h5>
        <br/>
        <br/>
        <br/>
        <table class="table table-sm table-borderless text-secondary">
            <tbody>
            @foreach($attribute_groups as $attribute_group)
                @if($attribute_group->attributes->count())
                    <tr>
                        <th colspan="2" class="text-right p-2">
                            <h4 class="m-0 d-inline text-gray-700"><i class="fa fa-caret-left text-primary ml-1"></i> {{ $attribute_group->title }}</h4>
                        </th>
                    </tr>
                    @foreach($attribute_group->attributes as $attribute)
                        @if($attribute->items->count())
                            <tr>
                                <td>
                                    <div class="bg-light p-2">{{ $attribute->title }}</div>
                                </td>
                                <td>
                                    <div class="bg-light p-2">
                                        @foreach($attribute->items as $item)
                                            @if(!$loop->first)
                                                <span class="mx-1">|</span>
                                            @endif
                                            <span>{{ $item->title }}</span>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    <tr>
                        <th colspan="2" class="p-4"></th>
                    </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
@endif
