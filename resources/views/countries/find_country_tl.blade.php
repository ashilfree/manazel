<table class="table table-bordered">
    <thead>
    <tr role="row">
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">{{ __('main.country_ar_name') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.country_en_name') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.country_phone_code') }}</span>
        </th>
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">تعديل</span>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($countries as $country)
        <tr role="row">
            <td style="text-align: center;" class="">
                <span>{{ $country->name }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $country->en_name }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $country->phone_code }}</span>
            </td>
            <td style="text-align: center;" class="">
                <div class="btn-group">
                    <a class="btn btn-primary btn-sm" href="{{ route('modify_country', $country->id) }}" title="{{ __('main.edit_country') }}"><i class="fas fa-edit no-margin"></i></a>
                    <form action="{{ route('delete_country') }}" method="POST" class="delete_country_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="country_id" value="{{ $country->id }}">
                        <button class="btn btn-primary btn-sm delete_country_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_country') }}"></i></button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $countries->links() }}

<script>
    $('.delete_country_form').on('click','.delete_country_btn', function (event)
    {
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: "هل أنت متأكد؟",
                text: "سيتم حذف الدولة من قاعدة البيانات!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: "نعم, أحذف",
                cancelButtonText: "لا, إلغاء",
                closeOnConfirm: true,
                closeOnCancel: true
            },
            function (isConfirm)
            {
                if (isConfirm)
                {
                    form.submit();
                }
                else
                {

                }
            });
    });
</script>