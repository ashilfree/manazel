<table class="table table-bordered">
    <thead>
    <tr role="row">
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">{{ __('main.username') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.full_name') }}</span>
        </th>
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">تعديل</span>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($admins as $admin)
        <tr role="row">
            <td style="text-align: center;" class="">
                <span>{{ $admin->username }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $admin->full_name }}</span>
            </td>
            <td style="text-align: center;" class="">
                <div class="btn-group">
                    <a class="btn btn-primary btn-sm" href="{{ route('modify_admin_permissions', $admin->id) }}" title="{{ __('main.change_perm') }}"><i class="fas fa-lock no-margin"></i></a>
                    <a class="btn btn-primary btn-sm" href="{{ route('modify_admin', $admin->id) }}" title="{{ __('main.edit_admin') }}"><i class="fas fa-edit no-margin"></i></a>
                    <form action="{{ route('delete_admin') }}" method="POST" class="delete_admin_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="admin_id" value="{{ $admin->id }}">
                        <button class="btn btn-primary btn-sm delete_admin_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_acc') }}"></i></button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $admins->links() }}

<script>
    $('.delete_admin_form').on('click','.delete_admin_btn', function (event)
    {
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: "هل أنت متأكد؟",
                text: "سيتم حذف الادمن من قاعدة البيانات!",
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