(function () {
    "use strict";
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var appUrl = $('body').attr('url');
    console.log(appUrl);
    var treeviewMenu = $('.app-menu');

    // Toggle Sidebar
    $('[data-toggle="sidebar"]').click(function(event) {
        event.preventDefault();
        $('.app').toggleClass('sidenav-toggled');
    });

    // Activate sidebar treeview toggle
    $("[data-toggle='treeview']").click(function(event) {
        event.preventDefault();
        if(!$(this).parent().hasClass('is-expanded')) {
            treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
        }
        $(this).parent().toggleClass('is-expanded');
    });

    // Set initial active toggle
    $("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');

    //Activate bootstrip tooltips
    $("[data-toggle='tooltip']").tooltip();

    $('.inputfile').each( function()
    {
        var input	 = $( this ),
            label	 = input.next('label'),
            labelVal = label.html();
        //console.log(label);
        input.on('change', function( e )
        {

            var fileName = '';
            if( this.files && this.files.length > 1 )
                fileName = ( this.getAttribute( 'data-multiple-caption' ) || '' ).replace( '{count}', this.files.length );
            else if( e.target.value )
                fileName = e.target.value.split( '\\' ).pop();

            if( fileName )
            {
                console.log(fileName);
                label.find('span').html(fileName);
            }
            else
            {
                label.html( labelVal );
            }
        });

        // Firefox bug fix
        input
            .on( 'focus', function(){ input.addClass( 'has-focus' ); })
            .on( 'blur', function(){ input.removeClass( 'has-focus' ); });
    });

    $(".birthday_select").flatpickr();

    var theLanguage = $('html').attr('lang');
    var swal_title = "هل أنت متأكد؟";
    var swal_del = "نعم, أحذف";
    var swal_cancel = "لا, إلغاء";

    if(theLanguage === "en")
    {
        var swal_title = "Are you sure?";
        var swal_del = "Yes, Delete";
        var swal_cancel = "No, Cancel";
    }

    $('.delete_teacher_form').on('click','.delete_teacher_btn', function (event)
    {
        var swal_message = "سيتم حذف المعلم من قاعدة البيانات!";

        if(theLanguage === "en")
        {
            var swal_message = "The teacher will be deleted from the database!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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
    var FIND_TEACHER_MIN_LENGTH = 3;
    $("#find_teacher").keyup(function()
    {
        var keyword = $("#find_teacher").val();
        var search_by = $("input[name='search_by']:checked").val();
        if (keyword.length >= FIND_TEACHER_MIN_LENGTH)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/teachers/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'no', 'search_by' : search_by},
                    success: function (resp)
                    {
                        $('.teacher_tl_div').html('');
                        $('.teacher_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
        else if(keyword.length == 0)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/teachers/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'yes', 'search_by' : search_by},
                    success: function (resp)
                    {
                        $('.teacher_tl_div').html('');
                        $('.teacher_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
    });

    $('.delete_student_form').on('click','.delete_student_btn', function (event)
    {
        var swal_message = "سيتم حذف الطالب من قاعدة البيانات!";

        if(theLanguage === "en")
        {
            var swal_message = "The student will be deleted from the database!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    var FIND_STUDENT_MIN_LENGTH = 3;
    $("#find_student").keyup(function()
    {
        var keyword = $("#find_student").val();
        var search_by = $("input[name='search_by']:checked").val();
        if (keyword.length >= FIND_STUDENT_MIN_LENGTH)
        {
            $.ajax(
            {
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: appUrl + '/students/find',
                dataType: 'json',
                data: {'keyword' : keyword, 'all' : 'no', 'search_by' : search_by},
                success: function (resp)
                {
                    $('.student_tl_div').html('');
                    $('.student_tl_div').append(resp);
                },
                error: function ()
                {

                },
                complete: function ()
                 {

                 }
            });
        }
        else if(keyword.length == 0)
        {
            $.ajax(
            {
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: appUrl + '/students/find',
                dataType: 'json',
                data: {'keyword' : keyword, 'all' : 'yes', 'search_by' : search_by},
                success: function (resp)
                {
                    $('.student_tl_div').html('');
                    $('.student_tl_div').append(resp);
                },
                error: function ()
                {
                },
                complete: function ()
                {

                }
            });
        }
    });

    var FIND_ADMIN_MIN_LENGTH = 3;
    $("#find_admin").keyup(function()
    {
        var keyword = $("#find_admin").val();
        var search_by = $("input[name='search_by']:checked").val();
        if (keyword.length >= FIND_ADMIN_MIN_LENGTH)
        {
            $.ajax(
            {
                type: 'POST',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                url: appUrl + '/admins/find',
                dataType: 'json',
                data: {'keyword' : keyword, 'all' : 'no', 'search_by' : search_by},
                success: function (resp)
                {
                    $('.admin_tl_div').html('');
                    $('.admin_tl_div').append(resp);
                },
                error: function ()
                {

                },
                complete: function ()
                {

                }
            });
        }
        else if(keyword.length == 0)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/admins/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'yes', 'search_by' : search_by},
                    success: function (resp)
                    {
                        $('.admin_tl_div').html('');
                        $('.admin_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
    });

    $('.delete_admin_form').on('click','.delete_admin_btn', function (event)
    {
        var swal_message = "سيتم حذف الادمن من قاعدة البيانات!";

        if(theLanguage === "en")
        {
            var swal_message = "The admin will be deleted from the database!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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


    var FIND_COUNTRY_MIN_LENGTH = 3;
    $("#find_country").keyup(function()
    {
        var keyword = $("#find_country").val();
        if (keyword.length >= FIND_COUNTRY_MIN_LENGTH)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/countries/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'no'},
                    success: function (resp)
                    {
                        $('.country_tl_div').html('');
                        $('.country_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
        else if(keyword.length == 0)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/countries/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'yes'},
                    success: function (resp)
                    {
                        $('.country_tl_div').html('');
                        $('.country_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
    });



    $('.delete_country_form').on('click','.delete_country_btn', function (event)
    {
        var swal_message = "سيتم حذف الدولة من قاعدة البيانات!";

        if(theLanguage === "en")
        {
            var swal_message = "The country will be deleted from the database!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    var FIND_LEVEL_MIN_LENGTH = 3;
    $("#find_level").keyup(function()
    {
        var keyword = $("#find_level").val();
        if (keyword.length >= FIND_LEVEL_MIN_LENGTH)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/levels/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'no'},
                    success: function (resp)
                    {
                        $('.level_tl_div').html('');
                        $('.level_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
        else if(keyword.length == 0)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/levels/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'yes'},
                    success: function (resp)
                    {
                        $('.level_tl_div').html('');
                        $('.level_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
    });

    var FIND_LEVEL_MIN_LENGTH = 3;
    $("#find_sub_level").keyup(function()
    {
        var keyword = $("#find_sub_level").val();
        if (keyword.length >= FIND_LEVEL_MIN_LENGTH)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/sub_levels/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'no'},
                    success: function (resp)
                    {
                        $('.level_tl_div').html('');
                        $('.level_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
        else if(keyword.length == 0)
        {
            $.ajax(
                {
                    type: 'POST',
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                    url: appUrl + '/sub_levels/find',
                    dataType: 'json',
                    data: {'keyword' : keyword, 'all' : 'yes'},
                    success: function (resp)
                    {
                        $('.level_tl_div').html('');
                        $('.level_tl_div').append(resp);
                    },
                    error: function ()
                    {

                    },
                    complete: function ()
                    {

                    }
                });
        }
    });


    $('#submit_dates').on('click', function (event)
    {
        var form = $('#group_stop_form');
        form.submit();
    });

    $('.delete_level_form').on('click','.delete_level_btn', function (event)
    {
        var swal_message = "سيتم حذف المستوي من قاعدة البيانات!";

        if(theLanguage === "en")
        {
            var swal_message = "The level will be deleted from the database!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_homework_form').on('click','.delete_homework_btn', function (event)
    {
        var swal_message = "سيتم حذف الواجب و الملفات المرتبطة به!";

        if(theLanguage === "en")
        {
            var swal_message = "The homework and associated files will be deleted!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_week_form').on('click','.delete_week_btn', function (event)
    {
        var swal_message = "سيتم حذف الأسبوع و الملفات المرتبطة به!";

        if(theLanguage === "en")
        {
            var swal_message = "The week and associated files will be deleted!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_group_form').on('click','.delete_group_btn', function (event)
    {
        var swal_message = "سيتم حذف الجروب والجروبات الفرعية المرتبطة به!";

        if(theLanguage === "en")
        {
            var swal_message = "The group and its associated sub-groups will be deleted!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_sub_group_form').on('click','.delete_sub_group_btn', function (event)
    {
        var swal_message = "سيتم حذف الجروب والبيانات المرتبطة به!";

        if(theLanguage === "en")
        {
            var swal_message = "The group and associated data will be deleted!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_ayah_test_form').on('click','.delete_ayah_test_btn', function (event)
    {
        var swal_message = "سيتم حذف ملف الاختبار!";

        if(theLanguage === "en")
        {
            var swal_message = "The ayah test file will be deleted!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_app_guid_form').on('click','.delete_app_guid_btn', function (event)
    {
        var swal_message = "سيتم حذف الصفحة من دليل التطبيق!";

        if(theLanguage === "en")
        {
            var swal_message = "The page will be deleted from the app guide!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_contact_us_form').on('click','.delete_contact_us_btn', function (event)
    {
        var swal_message = "سيتم حذف الرسالة!";

        if(theLanguage === "en")
        {
            var swal_message = "The message will be deleted!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_support_form').on('click','.delete_support_btn', function (event)
    {
        var swal_message = "سيتم حذف الرسالة!";

        if(theLanguage === "en")
        {
            var swal_message = "The message will be deleted!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_g_teacher_form').on('click','.delete_g_teacher_btn', function (event)
    {
        var swal_message = "سيتم حذف المعلم من الجروب!";

        if(theLanguage === "en")
        {
            var swal_message = "The teacher will be deleted from the group!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('.delete_g_student_form').on('click','.delete_g_student_btn', function (event)
    {
        var swal_message = "سيتم حذف الطالب من الجروب!";

        if(theLanguage === "en")
        {
            var swal_message = "The student will be deleted from the group!";
        }
        var form = $(this).parent();
        event.preventDefault();
        swal({
                title: swal_title,
                text: swal_message,
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55  ",
                confirmButtonText: swal_del,
                cancelButtonText: swal_cancel,
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

    $('#main_level_select').on('change', function()
    {
        var theLanguage = $('html').attr('lang');
        var level_id = $(this).val();
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: appUrl + '/get_sub_levels',
            dataType: 'json',
            data: {'id' : level_id},
            success: function(resp)
            {
                $("#sub_level_select").empty();
                if (theLanguage === "ar")
                {
                    $('#sub_level_select').append("<option value>بدون مستوي فرعي</option>");
                }
                else if (theLanguage === "en")
                {
                    $('#sub_level_select').append("<option value>Without sub level</option>");
                }
                $.each(resp, function (index, element)
                {
                    console.log(element['name']);

                    if (theLanguage === "ar")
                    {
                        $('#sub_level_select').append("<option value='"+ element['id'] +"'>"+ element['name'] +"</option>");
                    }
                    else if (theLanguage === "en")
                    {
                        $('#sub_level_select').append("<option value='"+ element['id'] +"'>"+ element['en_name'] +"</option>");
                    }
                });
            }
        });
    });

    $('#group_select').on('change', function()
    {
        var theLanguage = $('html').attr('lang');
        var group_id = $(this).val();
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: appUrl + '/get_group_weeks',
            dataType: 'json',
            data: {'id' : group_id},
            success: function(resp)
            {
                $("#week_select").empty();
                if (theLanguage === "ar")
                {
                    $('#week_select').append("<option value>أختر لاحقا</option>");
                }
                else if (theLanguage === "en")
                {
                    $('#week_select').append("<option value>Select later</option>");
                }
                $.each(resp, function (index, element)
                {
                    console.log(element['name']);

                    if (theLanguage === "ar")
                    {
                        $('#week_select').append("<option value='"+ element['id'] +"'>"+ element['week_name'] +"</option>");
                    }
                    else if (theLanguage === "en")
                    {
                        $('#week_select').append("<option value='"+ element['id'] +"'>"+ element['week_en_name'] +"</option>");
                    }
                });
            }
        });
    });

    var sum_options =  {
        height: 300,
        lang: 'ar-AR',
        toolbar: [
            ['view', ['fullscreen']],
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link','picture', 'video', 'videoAttributes', 'hr']],
            ['para', ['style']],
        ]
    };
    var select_image = 'أختار الصورة';
    var video_link = 'أضف رابط الفيديو';
    var theLanguage = $('html').attr('lang');

    if (theLanguage === "en")
    {
        var sum_options =  {
            height: 300,
            lang: 'en-EN',
            toolbar: [
                ['view', ['fullscreen']],
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['insert', ['link','picture', 'video', 'videoAttributes', 'hr']],
                ['para', ['style']],
            ]
        };
        select_image = 'SELECT IMAGE';
        video_link = 'Add video link';
    }

    $('#summernote').summernote(sum_options);
    $('#summernote2').summernote(sum_options);


    function readURL(input)
    {
        var image = $(input).parent().siblings('div').find('.change_prod_image_img');
        console.log(image);
        if (input.files && input.files[0])
        {
            var reader = new FileReader();

            reader.onload = function (e)
            {
                $(image).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(".change_src_image").change(function(){
        readURL(this);
    });

    var image_crop_form = null;
    var images_crop_blobs = [];

    window.addEventListener('DOMContentLoaded', function ()
    {
        var crop_image_image = $('.crop_image_image');
        var crop_image_input;
        var crop_image_input_obj;
        var $crop_image_model = $('.crop_image_model');
        var cropper;

        $(document).on('change','.crop_image_input', function (e)
        {
            if (e.target.classList.contains('crop_image_input'))
            {
                crop_image_input = $(this);
                var files = e.target.files;
                var done = function (url)
                {
                    //crop_image_input.val('');
                    crop_image_image.attr("src", url);
                    $crop_image_model.modal({backdrop: 'static'}, 'show' );
                };
                var reader;
                var file;
                var url;

                if (files && files.length > 0)
                {
                    file = files[0];

                    if (URL)
                    {
                        done(URL.createObjectURL(file));
                    }
                    else if (FileReader)
                    {
                        reader = new FileReader();
                        reader.onload = function (e)
                        {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            }
        });

        $crop_image_model.on('shown.bs.modal', function ()
        {
            if(crop_image_input.attr('name') === "game_banner")
            {
                var minCroppedWidth = 320;
                var minCroppedHeight = 600;
                var maxCroppedWidth = 640;
                var maxCroppedHeight = 600;
                cropper = new Cropper(crop_image_image.get(0), {
                    viewMode: 3,

                    data: {
                        height: (minCroppedHeight + maxCroppedHeight) / 2,
                    },

                    crop: function (event) {
                        var height = event.detail.height;

                        if
                        (
                            height < minCroppedHeight || height > maxCroppedHeight
                        ) {
                            cropper.setData({
                                height: Math.max(minCroppedHeight, Math.min(maxCroppedHeight, height)),
                            });
                        }
                    },
                });


            }
            else
            {
                cropper = new Cropper(crop_image_image.get(0),
                    {
                        aspectRatio: 1.7777777777777777,
                        viewMode: 3,
                    });
            }

            $('input[type=radio][name=aspectRatio]').on('change', function()
            {
                cropper.setAspectRatio($(this).val());
            });
        }).on('hidden.bs.modal', function ()
        {
            cropper.destroy();
            cropper = null;
        });

        $('.icp').iconpicker();


        $(document).on('click','.iconpicker-item', function (e)
        {
            e.preventDefault();
        });

        document.getElementById('crop').addEventListener('click', function ()
        {
            var canvas;
            var cropper_data;
            var input_name;
            $crop_image_model.modal('hide');

            if (cropper)
            {
                cropper_data = cropper.getData();
                var last_crop_data = cropper_data.x + "," + cropper_data.y + "," + cropper_data.width + "," + cropper_data.height;
                input_name = crop_image_input.attr('name');
                image_crop_form = crop_image_input.parents('.image_crop_form');

                image_crop_form.append('<input type="hidden" name="image_data" value="'+ last_crop_data +'" />');
            }
        });
    });



    var elems = Array.prototype.slice.call(document.querySelectorAll('.js-switch'));

    elems.forEach(function(html) {
        var switchery = new Switchery(html);
    });

    if(theLanguage === "ar")
    {
        $(".chosen-select").chosen({width: '100%', rtl: true, no_results_text: 'لا توجد نتائج مطابقة'});
    }
    else
    {
        $(".chosen-select").chosen({width: '100%', no_results_text: 'No results match'});
    }


    var input = document.querySelector("#phone");
    var countries = input.getAttribute('countries-data');
    countries = countries.split(',');
    console.log(countries);
    var iti = window.intlTelInput(input, {
        onlyCountries: countries,
        preferredCountries: [],
        separateDialCode: true,
        hiddenInput: "full_phone",
        utilsScript: "/resources/intl-tel-input/js/utils.js?1537727621611" // just for formatting/placeholders etc
    });

    $("#add_std_tec").submit( function(eventObj)
    {
        var country_iso = iti.getSelectedCountryData().iso2;
        $('<input />').attr('type', 'hidden')
            .attr('name', "country_iso")
            .attr('value', country_iso)
            .appendTo(this);
        return true;
    });

})();
