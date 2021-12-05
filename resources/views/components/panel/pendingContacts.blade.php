@if($pending_contacts ?? false)
    <div class="bg-white rounded shadow-sm p-3 mb-4">
        <h4 class="mb-4 border-bottom pb-3 text-secondary">
            <i class="fal fa-envelope ml-2"></i>
            پیام های مشاهده نشده
        </h4>
        @if($pending_contacts->count())
            <div class="table-responsive">
                <table class="table table-sm m-0">
                    <thead class="bg-light">
                    <tr>
                        <th>کاربر</th>
                        <th class="text-center">تاریخ</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody class="fa-num">
                    @foreach($pending_contacts as $pending_contact)
                        <tr>
                            <td>{{ $pending_contact->name }}</td>
                            <td class="text-center">{{ jd($pending_contact->created_at) }}</td>
                            <td class="text-left">
                                <a href="{{ route('panel.contacts.show',$pending_contact) }}" class="btn btn-sm btn-light">
                                    مشاهده
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            @if($pending_contacts->count() > 9)
                <a class="btn btn-light btn-block" href="{{ route('panel.contacts.index') }}">
                    مشاهده همه پیامها
                </a>
            @endif
        @else
            @include('components.empty')
        @endif
    </div>
@endif