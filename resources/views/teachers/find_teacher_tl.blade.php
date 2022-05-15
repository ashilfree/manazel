<table class="table table-bordered">
    <thead>
    <tr role="row">
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">{{ __('main.username') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.email') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.phone') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.birthday') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.quran_parts') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.spare_time') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.workـhours') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.level') }}</span>
        </th>
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">تعديل</span>
        </th>
    </tr>
    </thead>
    <tbody>
    @foreach($teachers as $teacher)
        <tr role="row">
            <td style="text-align: center;" class="">
                <span>{{ $teacher->username }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $teacher->email }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $teacher->phone }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $teacher->birthday }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $teacher->quran_parts }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $teacher->spare_time }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $teacher->workـhours }}</span>
            </td>
            @php
                $teacher_level = \App\Level::where('id', $teacher->level)->first();
                $level = null;
                if(empty($teacher_level))
                {
                    $level =  __('main.notـspecified');
                }
                else
                {
                    $level = $teacher_level->name."-".$teacher_level->level;
                }
            @endphp
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $level }}</span>
            </td>
            <td style="text-align: center;" class="">
                <div class="btn-group">
                    <a class="btn btn-primary btn-sm" href="{{ route('modify_teacher', $teacher->id) }}" title="تعديل بيانات المعلم"><i class="fas fa-edit no-margin"></i></a>
                    <form action="{{ route('delete_teacher') }}" method="POST" class="delete_teacher_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                        <button class="btn btn-primary btn-sm delete_teacher_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="حذف حساب"></i></button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $teachers->links() }}

<script>
    $('.delete_teacher_form').on('click','.delete_teacher_btn', function (event)
    {
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: "هل أنت متأكد؟",
                text: "سيتم حذف المعلم من قاعدة البيانات!",
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