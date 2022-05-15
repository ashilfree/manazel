<table class="table table-bordered">
    <thead>
    <tr role="row">
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">{{ __('main.level_name') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.the_level') }}</span>
        </th>
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">تعديل</span>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($levels as $level)
        <tr role="row">
            <td style="text-align: center;" class="">
                <span>{{ $level->name }} - {{ $level->en_name }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $level->level }} - {{ $level->en_level }}</span>
            </td>
            <td style="text-align: center;" class="">
                <div class="btn-group">
                    @if(auth('admins')->user()->permissions->levels[1] == 1)
                        <a class="btn btn-primary btn-sm" href="{{ route('modify_level', $level->id) }}" title="{{ __('main.edit_level') }}"><i class="fas fa-edit no-margin"></i></a>
                    @endif
                    @if(auth('admins')->user()->permissions->levels[2] == 1)
                        <form action="{{ route('delete_level') }}" method="POST" class="delete_level_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="level_id" value="{{ $level->id }}">
                            <button class="btn btn-primary btn-sm delete_level_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_level') }}"></i></button>
                        </form>
                    @endif
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $levels->links() }}

<script>
    $('.delete_level_form').on('click','.delete_level_btn', function (event)
    {
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: "هل أنت متأكد؟",
                text: "سيتم حذف المستوي من قاعدة البيانات!",
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