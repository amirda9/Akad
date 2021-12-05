@if($latest_contacts ?? false)
    <div class="bg-white rounded shadow-sm p-3 mb-4">
        <h4 class="mb-4 border-bottom pb-3 text-secondary">
            <i class="fal fa-envelope ml-2"></i>
            آخرین پیام ها
        </h4>
        @if($latest_contacts->count())
            <div class="table-responsive">
                <table class="table table-sm m-0">
                    <thead class="bg-light">
                    <tr>
                        <th>کاربر</th>
                        <th>وضعیت</th>
                        <th class="text-center">تاریخ</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="fa-num">
                    @foreach($latest_contacts as $latest_contact)
                        <tr>
                            <td>{{ $latest_contact->name }}</td>
                            <td>
                                @if($latest_contact->seen)
                                    <span class="badge badge-success">خوانده شده</span>
                                @else
                                    <span class="badge badge-secondary">خوانده شده</span>
                                @endif
                            </td>
                            <td class="text-center">{{ jd($latest_contact->created_at) }}</td>
                            <td class="text-left">
                                <a href="{{ route('panel.contacts.show',$latest_contact) }}" class="btn btn-sm btn-light">
                                    مشاهده
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if($latest_contacts->count() > 9)
                <a class="btn btn-light btn-block" href="{{ route('panel.contacts.index') }}">
                    مشاهده همه پیامها
                </a>
            @endif
        @else
            @include('components.empty')
        @endif
    </div>
@endif
