@extends('layouts.app')

@section('template_title')
	{{ $user->full_name }}'s Profile
@endsection

@section('template_fastload_css')

	#map-canvas{
		min-height: 300px;
		height: 100%;
		width: 100%;
	}

@endsection

@section('template_linked_css')
    <style>

    </style>
@endsection
@section('content')
	<div class="">
        <div class="prof-header" style="background: url({{ $user->profile->cover }}) no-repeat; background-size: cover">
			<div id="coverZone" class="cover-drpzone is-hidden">
				<form name="coverDropzone" method="post" action="{{ route('cover.upload', $user->id) }}"
					  enctype="multipart/form-data" class="dropzone" id="my-dropzone" style="background: transparent; padding: 0; width: 100%; height: 300px; position:absolute;">
					{{ csrf_field() }}
					<div class="dz-message">
						<div class="message">
							<p>Drop files here or Click to Upload</p>
						</div>
					</div>
					<div class="fallback">
						<input type="file" name="file" multiple>
					</div>
				</form>

				{{--Dropzone Preview Template--}}
				<div id="preview" style="display: none;">

					<div class="dz-preview dz-file-preview">
						<div class="dz-image"><img data-dz-thumbnail /></div>

						<div class="dz-details">
							<div class="dz-size"><span data-dz-size></span></div>
							<div class="dz-filename"><span data-dz-name></span></div>
						</div>
						<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
						<div class="dz-error-message"><span data-dz-errormessage></span></div>



						<div class="dz-success-mark">

							<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
								<!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
								<title>Check</title>
								<desc>Created with Sketch.</desc>
								<defs></defs>
								<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
									<path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>
								</g>
							</svg>

						</div>
						<div class="dz-error-mark">

							<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
								<!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->
								<title>error</title>
								<desc>Created with Sketch.</desc>
								<defs></defs>
								<g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
									<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">
										<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>
									</g>
								</g>
							</svg>
						</div>
					</div>
				</div>
			</div>
			<div class="avatar">
				<img src="@if ($user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" class="prof-img">
				<a id="editAvatar" class="button link-noUnderline is-hidden">Edit</a>
			</div>
			<div id="avatarZone" class="avatarZone is-hidden">
				<div class="dz-preview"></div>

				{!! Form::open(array('route' => 'avatar.upload', 'method' => 'POST', 'name' => 'avatarDropzone','id' => 'avatarDropzone', 'class' => 'form single-dropzone dropzone single', 'files' => true)) !!}

				<img id="user_selected_avatar" class="user-avatar" src="@if ($user->profile->avatar != NULL) {{ $user->profile->avatar }} @endif" alt="{{ $user->name }}">

				{!! Form::close() !!}
			</div>
			<a id="editCover" class="button link-noUnderline is-hidden">Change Cover</a>
        </div>
        <div class="container">
            <div class="prof-info" @role('user')style="margin: 0.5% 0 6% 6%;" @else style="margin: 0.5% 5% 6% 14%;" @endrole>
                <div class="pull-left">
                    <h3 class="store-name">
                        {{ $user->full_name }}
                    </h3>
                    <p>Created : {{ $created }}</p>
                </div>
                <div class="pull-right">
					@if ($user->profile)
						@if (Auth::user()->id == $user->id)

							{{--{!! HTML::icon_link(URL::to('/profile/'.Auth::user()->name.'/edit'), 'fa fa-fw fa-cog', trans('titles.editProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}--}}

							{{--<a href="{{ url('/profile/'.Auth::user()->name.'/edit') }}" class="button is-info">Edit Profile</a>--}}
							<a id="editProfile" class="button is-info link-noUnderline">Edit Profile</a>
							<a id="editDone" class="button is-primary link-noUnderline is-hidden">Done</a>
						@endif
					@else

						<p>{{ trans('profile.noProfileYet') }}</p>
						{!! HTML::icon_link(URL::to('/profile/'.Auth::user()->name.'/edit'), 'fa fa-fw fa-plus ', trans('titles.createProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}

					@endif

                </div>
            </div>
        </div>

    </div>
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">

						{{ trans('profile.showProfileTitle',['username' => $user->name]) }}

					</div>
					<div class="panel-body">

    					<img src="@if ($user->profile->avatar_status == 1) {{ $user->profile->avatar }} @else {{ Gravatar::get($user->email) }} @endif" alt="{{ $user->name }}" class="user-avatar">

						<dl class="user-info">

							<dt>
								{{ trans('profile.showProfileUsername') }}
							</dt>
							<dd>
								{{ $user->name }}
							</dd>

							<dt>
								{{ trans('profile.showProfileFirstName') }}
							</dt>
							<dd>
								{{ $user->first_name }}
							</dd>

							@if ($user->last_name)
								<dt>
									{{ trans('profile.showProfileLastName') }}
								</dt>
								<dd>
									{{ $user->last_name }}
								</dd>
							@endif

							<dt>
								{{ trans('profile.showProfileEmail') }}
							</dt>
							<dd>
								{{ $user->email }}
							</dd>

							@if ($user->profile)

								@if ($user->profile->theme_id)
									<dt>
										{{ trans('profile.showProfileTheme') }}
									</dt>
									<dd>
										{{ $currentTheme->name }}
									</dd>
								@endif

								@if ($user->profile->location)
									<dt>
										{{ trans('profile.showProfileLocation') }}
									</dt>
									<dd>
										{{ $user->profile->location }} <br />

										@if(config('settings.googleMapsAPIStatus'))
											Latitude: <span id="latitude"></span> / Longitude: <span id="longitude"></span> <br />

											<div id="map-canvas"></div>
										@endif
									</dd>
								@endif

								@if ($user->profile->bio)
									<dt>
										{{ trans('profile.showProfileBio') }}
									</dt>
									<dd>
										{{ $user->profile->bio }}
									</dd>
								@endif

								@if ($user->profile->twitter_username)
									<dt>
										{{ trans('profile.showProfileTwitterUsername') }}
									</dt>
									<dd>
										{!! HTML::link('https://twitter.com/'.$user->profile->twitter_username, $user->profile->twitter_username, array('class' => 'twitter-link', 'target' => '_blank')) !!}
									</dd>
								@endif

								@if ($user->profile->github_username)
									<dt>
										{{ trans('profile.showProfileGitHubUsername') }}
									</dt>
									<dd>
										{!! HTML::link('https://github.com/'.$user->profile->github_username, $user->profile->github_username, array('class' => 'github-link', 'target' => '_blank')) !!}
									</dd>
								@endif
							@endif

						</dl>

						@if ($user->profile)
							@if (Auth::user()->id == $user->id)

								{!! HTML::icon_link(URL::to('/profile/'.Auth::user()->name.'/edit'), 'fa fa-fw fa-cog', trans('titles.editProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}

							@endif
						@else

							<p>{{ trans('profile.noProfileYet') }}</p>
							{!! HTML::icon_link(URL::to('/profile/'.Auth::user()->name.'/edit'), 'fa fa-fw fa-plus ', trans('titles.createProfile'), array('class' => 'btn btn-small btn-info btn-block')) !!}

						@endif

					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('footer_scripts')

	@if(config('settings.googleMapsAPIStatus'))
		@include('scripts.google-maps-geocode-and-map')
	@endif

	<script src="{{ asset('js/dropzone.js') }}"></script>
	<script>
//		$(document).ready(function () {
//            Dropzone.autoDiscover = false;
//            var coverDropzone = new Dropzone('#my-dropzone');
//            coverDropzone.options.coverDropzone = {
//                paramName : "file",
//                maxFiles: 1,
//                addRemoveLinks: true,
//                uploadMultiple: false,
//                thumbnailWidth: 600,
//                thumbnailHeight: 150
//            };
//        });
	</script>

	<script>
		$(document).ready(function () {
		    $('#editProfile').on('click', function (e) {
				e.preventDefault();
				var editCoverBtn = document.getElementById('editCover');
				var editAvatarBtn = document.getElementById('editAvatar');
				var editDoneBtn = document.getElementById('editDone');
				editAvatarBtn.classList.toggle('is-hidden');
				editCoverBtn.classList.toggle('is-hidden');
				editDoneBtn.classList.toggle('is-hidden');
				$(this).hide();
            });
		    $('#editCover').on('click', function (e) {
				e.preventDefault();
				var coverZone = document.getElementById('coverZone');
                $(this).hide();
                coverZone.classList.toggle('is-hidden');
            });
		    $('#editAvatar').on('click', function (e) {
				e.preventDefault();
				var avatarZone = document.getElementById('avatarZone');
                $(this).hide();
                avatarZone.classList.toggle('is-hidden');
            });
		    $('#editDone').on('click', function (e) {
				e.preventDefault();
                window.location.reload();
//                var coverZone = document.getElementById('coverZone');
//                coverZone.classList.toggle('is-hidden');
//                $('#editCover').show();
            })
        });
	</script>

@endsection
