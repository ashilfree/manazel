@extends('layout.layout')
@section('title',  __('main.add_teacher') )

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fas fa-chalkboard-teacher"></i> {{ __('main.teachers') }}</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fas fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.c_panel') }}</a></li>
            <li class="breadcrumb-item"><a href="#">{{ __('main.add_teacher') }}</a></li>
        </ul>
    </div>
    <div class="row justify-content-center">
        <div class="col-xs-12 col-md-9">
            <div class="tile">
                <h3 class="tile-title text-center">{{ __('main.add_teacher') }}</h3>
                <form action="{{ route('set_teacher') }}" role="form" method="post" enctype="application/x-www-form-urlencoded" id="add_std_tec">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label>{{ __('main.username') }}</label>
                        <input class="form-control" type="text" name="username" value="{{ old('username') }}" required autofocus>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.email') }}</label>
                        <input class="form-control" type="text" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.password') }}</label>
                        <input class="form-control" type="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.c_password') }}</label>
                        <input class="form-control" type="password" name="password_confirmation"  required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.phone') }}</label>
                        <input class="form-control" type="tel" countries-data="{{ $countries_data }}" id="phone" name="phone" value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.birthday') }}</label>
                        <input class="form-control birthday_select" type="text" placeholder="{{ __('main.pick_birthday') }}" name="birthday" value="{{ old('birthday') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.quran_parts') }}</label>
                        <input class="form-control" type="number" name="quran_parts" value="{{ old('quran_parts') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.spare_time') }}</label>
                        <input class="form-control" type="number" name="spare_time" value="{{ old('spare_time') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.workـhours') }}</label>
                        <input class="form-control" type="number" name="workـhours" value="{{ old('workـhours') }}" required>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.level') }}</label>
                        <select class="form-control f-size-090 mb-1" name="level" id="slide_section_select">
                            <option value="null">{{ __('main.notـspecified') }}</option>
                            @foreach($levels as $level)
                                <option value="{{ $level->id }}">{{ $level->name }} - {{ $level->level }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.mogazh') }}</label>
                        <select class="form-control f-size-090 mb-1" name="mogazh" id="slide_section_select">
                            <option value="yes">{{ __('main.yes') }}</option>
                            <option value="no">{{ __('main.no') }}</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>{{ __('main.mastery_certificates_num') }}</label>
                        <input class="form-control" type="number" name="mastery_certificates_num" value="0" required>
                    </div>
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-responsive btn-primary">{{ __('main.add') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
