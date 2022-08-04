<div class="row">
    <input type="hidden" id="userPreferencesTags" value="{{ json_encode($userPreferencesTags) }}" >
    @php $i=0; @endphp
    @foreach($userPreferencesGroups as $item)
        <aside class="col-md-6 userPreferencesBox">
        <article class="SettingBox">
            <div class="d-flex bd-highlight justify-content-between align-items-center SettingBoxHead">
            <h5 class="user-preferences-group p-2 flex-grow-1 bd-highlight"><a href="javascript:void(0);">#{{$i+1}} {{Str::limit(ucwords($item->name), 30)}}:</a></h5>
            @if($i != 0)
                <div class="custom-control custom-switch p-2 bd-highlight">
                    @php $status = $item->status == 1 ? 'checked' : ''; @endphp
                    <input name="subscribe" type="checkbox" class="custom-control-input condition-trigger groupStatusToggle" data-group-id="{{$item->id}}" id="customSwitch{{$item->id}}" {{$status}}>
                    <label class="custom-control-label" for="customSwitch{{$item->id}}"></label>
                    <span class="" id="valueOfSwitch{{$item->id}}"> {{$item->status ? 'On' : 'Off'}}</span>
                </div>
            @endif
            <div class="SettingBoxHeadLast p-2 bd-highlight">
                <ul>
                <li><a href="javascript:void(0);" data-group-id="{{$item->id}}" class="btn btn-dark btn-sm rounded-5 addNewTag" id="addNewTag{{$item->id}}">Add #</a></li>
                @if($i > 0)
                    <li><a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="far fa-ellipsis-v"></i></a>
                        <ul class="dropdown-menu dropdown-menu-right">
                        <li class="nav-item"> <a class="nav-link editNewUserPreferencesGroup" data-group-id="{{$item->id}}" data-group-name="{{$item->name}}" href="javascript:void(0);"><i class="fal fa-edit"></i> Edit</a> </li>
                        <li class="nav-item"> <a class="nav-link deleteUserPreferencesGroup" data-group-id="{{$item->id}}" href="javascript:void(0);"><i class="fal fa-trash-alt"></i> Delete</a> </li>
                        </ul>
                    </li>
                @endif
                </ul>
            </div>
            </div>
            <div class="card mt-2 py-2 px-3 rounded-lg tagsinput-box" id="tagsinput-box-{{$item->id}}" data-group-id="{{$item->id}}" >
                <div class="detail-tag">
                    <span id="user-tags-box-{{$item->id}}">
                        @if($item->tags()->count())
                            @foreach ($item->tags as $tag)
                                <span class="label-info-tag label-tag-{{base64_encode($tag->name)}}"><a href="javascript:void(0);">#{{$tag->name}}</a></span>
                            @endforeach
                        @else
                            <span class="label-info-tag no-tags">No tags found</span>
                        @endif
                    </span>
                    @php $tags = $item->tags()->get()->pluck('name')->toArray(); @endphp
                    <input style="display:none;" type="text" name="tags" class="user-tags-input" data-group-id="{{$item->id}}" id="user-tags-input-{{$item->id}}" value="{{implode(',', $tags)}}" />
                </div>
            </div>
        </article>
        </aside>
        @php $i++; @endphp
    @endforeach

  </div>