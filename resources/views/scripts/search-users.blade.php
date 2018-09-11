<script>
    $(function() {
        var cardTitle = $('#card_title');
        var usersTable = $('#users_table');
        var resultsContainer = $('#search_results');
        var usersCount = $('#user_count');
        var clearSearchTrigger = $('.clear-search');
        var searchform = $('#search_users');
        var searchformInput = $('#user_search_box');
        var userPagination = $('#user_pagination');
        var searchSubmit = $('#search_trigger');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        searchform.submit(function(e) {
            e.preventDefault();
            resultsContainer.html('');
            usersTable.hide();
            clearSearchTrigger.show();
            let noResulsHtml = '<tr>' +
                                '<td>@lang("usersmanagement.search.no-results")</td>' +
                                '<td></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-xs"></td>' +
                                '<td class="hidden-sm hidden-xs"></td>' +
                                '<td class="hidden-sm hidden-xs hidden-md"></td>' +
                                '<td class="hidden-sm hidden-xs hidden-md"></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '<td></td>' +
                                '</tr>';

            $.ajax({
                type:'POST',
                url: "{{ route('search-users') }}",
                data: searchform.serialize(),
                success: function (result) {
                    let jsonData = JSON.parse(result);
                    if (jsonData.length != 0) {
                        $.each(jsonData, function(index, val) {
                            let rolesHtml = '';
                            let roleClass = '';
                            let showCellHtml = '<a class="button is-small is-success m-r-5" href="users/' + val.id + '" data-toggle="tooltip" title="@lang("usersmanagement.tooltips.show")">@lang("usersmanagement.buttons.show")</a>';
                            let editCellHtml = '<a class="button is-small is-info" href="users/' + val.id + '/edit" data-toggle="tooltip" title="@lang("usersmanagement.tooltips.edit")">@lang("usersmanagement.buttons.edit")</a>';
                            let deleteCellHtml = '<form method="POST" action="/users/'+ val.id +'" accept-charset="UTF-8" data-toggle="tooltip" title="Delete">' +
                                    '{!! Form::hidden("_method", "DELETE") !!}' +
                                    '{!! csrf_field() !!}' +
                                    '<button class="button is-danger is-small m-r-5" type="button" style="width: 100%;" data-toggle="modal" data-target="#confirmDelete" data-title="Delete User" data-message="@lang("usersmanagement.modals.delete_user_message", ["user" => "'+val.name+'"])">' +
                                        '@lang("usersmanagement.buttons.delete")' +
                                    '</button>' +
                                '</form>';

                            $.each(val.roles, function(roleIndex, role) {
                                if (role.name == "User") {
                                    roleClass = 'is-info';
                                } else if (role.name == "Admin") {
                                    roleClass = 'is-success';
                                } else if (role.name == "Unverified") {
                                    roleClass = 'is-danger';
                                } else {
                                    roleClass = 'is-light';
                                };
                                rolesHtml = '<span class="tag is-rounded ' + roleClass + '">' + role.name + '</span> ';
                            });
                            resultsContainer.append('<tr>' +
                                '<td>' + val.id + '</td>' +
                                '<td>' + val.name + '</td>' +
                                '<td class="hidden-xs">' + val.email + '</td>' +
                                '<td class="hidden-xs">' + val.user_type + '</td>' +
                                '<td class="hidden-xs">' + val.full_name + '</td>' +
                                '<td class="hidden-sm hidden-xs"> ' + rolesHtml  +'</td>' +
                                '<td class="hidden-sm hidden-xs hidden-md">' + val.created_at + '</td>' +
                                '<td class="hidden-sm hidden-xs hidden-md">' + val.updated_at + '</td>' +
                                '<td style="padding: 0;vertical-align: middle;"><div style="display: inline-flex;">' + deleteCellHtml + showCellHtml + editCellHtml +'</div></td>' +
//                                '<td>' + showCellHtml + '</td>' +
//                                '<td>' + editCellHtml + '</td>' +
                            '</tr>');
                        });
                    } else {
                        resultsContainer.append(noResulsHtml);
                    };
                    usersCount.html(jsonData.length + " @lang('usersmanagement.search.found-footer')");
                    userPagination.hide();
                    cardTitle.html("@lang('usersmanagement.search.title')");
                },
                error: function (response, status, error) {
                    if (response.status === 422) {
                        resultsContainer.append(noResulsHtml);
                        usersCount.html(0 + " @lang('usersmanagement.search.found-footer')");
                        userPagination.hide();
                        cardTitle.html("@lang('usersmanagement.search.title')");
                    };
                },
            });
        });
        searchSubmit.click(function(event) {
            event.preventDefault();
            searchform.submit();
        });
        searchformInput.keyup(function(event) {
            if ($('#user_search_box').val() != '') {
                clearSearchTrigger.show();
            } else {
                clearSearchTrigger.hide();
                resultsContainer.html('');
                usersTable.show();
                cardTitle.html("@lang('usersmanagement.showing-all-users')");
                userPagination.show();
                usersCount.html(" ");
            };
        });
        clearSearchTrigger.click(function(e) {
            e.preventDefault();
            clearSearchTrigger.hide();
            usersTable.show();
            resultsContainer.html('');
            searchformInput.val('');
            cardTitle.html("@lang('usersmanagement.showing-all-users')");
            userPagination.show();
            usersCount.html(" ");
        });
    });
</script>
