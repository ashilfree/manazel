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
            <span class="wc-image tips">{{ __('main.country') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.birthday') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.quran_parts') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.level') }}</span>
        </th>
        <th scope="col" id="thumb" class="d-none d-md-table-cell text-center">
            <span class="wc-image tips">{{ __('main.student_group') }}</span>
        </th>
        <th scope="col" id="thumb" class="text-center">
            <span class="wc-image tips">{{ __('main.edit') }}</span>
        </th>
    </tr>
    </thead>
    <tbody>
    @php
        $counter = 0;
    @endphp
    @foreach($students as $student)
        <tr role="row">
            <td style="text-align: center;" class="">
                <span>{{ $student->username }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $student->email }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $student->phone }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $student->country ? \App\Helper\MyHelper::ReturnValueByLang($student->country->phone_code." - ".$student->country->name , $student->country->phone_code." - ".$student->country->en_name) : "" }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $student->birthday }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $student->quran_parts }}</span>
            </td>
            @php
                $student_group = \App\Users_group::where('user_id', $student->id)->first();
                $student_group_data = null;
                if(!empty($student_group))
                {
                    $student_group_data = \App\Sub_group::where('id', $student_group->sub_group_id)->first();
                }

                $student_level = \App\Level::where('id', $student->level_id)->first();
                $level = null;
                if(empty($student_level))
                {
                    $level =  __('main.notـspecified');
                }
                else
                {
                    $level = $student_level->name."-".$student_level->level;
                }

                $counter++;
            @endphp
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $level }}</span>
            </td>
            <td style="text-align: center;" class="d-none d-md-table-cell">
                <span>{{ $student_group_data ? \App\Helper\MyHelper::ReturnValueByLang($student_group_data->name, $student_group_data->en_name) : "" }}</span>
            </td>
            <td style="text-align: center;" class="">
                <div class="btn-group">
                    @if(auth('admins')->user()->permissions->students[4] == 1)
                        <button class="btn btn-primary btn-sm delete_sub_group_btn" data-toggle="modal" data-target="#change_group{{ $counter }}" title="{{ __('main.change_student_group') }}"><i class="fas fa-plus no-margin"></i></button>
                    @endif
                    @if(auth('admins')->user()->permissions->students[3] == 1)
                        <a class="btn btn-primary btn-sm" href="{{ route('change_student_level', $student->id) }}" title="{{ __('main.select_student_level') }}"><i class="fas fa-sort-numeric-up no-margin"></i></a>
                    @endif
                    @if(auth('admins')->user()->permissions->students[7] == 1)
                        <a class="btn btn-primary btn-sm" href="{{ route('notify_student', $student->id) }}" title="{{ __('main.send_student_notification') }}"><i class="fas fa-bell no-margin"></i></a>
                    @endif
                    @if(auth('admins')->user()->permissions->students[1] == 1)
                        <a class="btn btn-primary btn-sm" href="{{ route('modify_student', $student->id) }}" title="{{ __('main.edit_student') }}"><i class="fas fa-edit no-margin"></i></a>
                    @endif
                    @if(auth('admins')->user()->permissions->students[2] == 1)
                        <form action="{{ route('delete_student') }}" method="POST" class="delete_student_form">
                            {{ csrf_field() }}
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            <button class="btn btn-primary btn-sm delete_student_btn btn-border-red" type="submit"><i class="far fa-trash-alt no-margin" title="{{ __('main.delete_acc') }}"></i></button>
                        </form>
                    @endif
                </div>
            </td>
        </tr>
        @if(auth('admins')->user()->permissions->students[4] == 1)
            <!-- Modal -->
            @php
                $groups = [];
                if($student->sub_level_id != null)
                {
                    $main_group = \App\Group::where('sub_level_id', $student->sub_level_id)->first();
                    $student_group = \App\Users_group::where('user_id', $student->id)->first();
                    $student_sub_group_id = null;

                    if(!empty($student_group))
                    {
                       $student_sub_group_id = $student_group->sub_group_id;
                    }
                    $groups = array();
                    if(!empty($main_group))
                    {
                        $groups = \App\Sub_group::where('group_id', $main_group->id)->get();
                    }
                }
            @endphp
            <div class="modal fade" id="change_group{{ $counter }}" tabindex="-1" role="dialog" aria-labelledby="select_teacher_model" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLongTitle">{{ __('main.change_student_group') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form action="{{ route('change_student_group') }}" method="post" enctype="application/x-www-form-urlencoded">
                            <input type="hidden" name="student_id" value="{{ $student->id }}">
                            {{ csrf_field() }}
                            <div class="modal-body">
                                <div class="form-group">
                                    <select class="chosen-select form-control" name="group_id" data-placeholder="{{ __('main.select_group') }}">
                                        <option value=""></option>
                                        @foreach($groups as $group)
                                            @if($group->id == $student_sub_group_id)
                                                <option value="{{ $group->id }}" selected>{{ \App\Helper\MyHelper::ReturnValueByLang($group->name, $group->en_name) }}</option>
                                            @else
                                                <option value="{{ $group->id }}">{{ \App\Helper\MyHelper::ReturnValueByLang($group->name, $group->en_name) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer" style="direction: ltr;">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('main.close') }}</button>
                                <button type="submit" class="btn btn-primary">{{ __('main.change') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    </tbody>
</table>
{{ $students->links() }}
