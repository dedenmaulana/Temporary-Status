<div class="ui segments status" data-id="{{$status->id}}" data-provider="{{$status->provider}}" style="border:none">
    <div class="ui attached message">
        <div class="header"><i class="{{$status->provider}} square icon"></i>{{$status->owner->name}}</div>
    </div>
    <div class="ui {{$status->status === 'live' ? 'red' : 'green'}} attached segment">
        <p>{{$status->message}}</p>

        @if(!empty($status->link))
        <p>{{$status->link}}</p>
        @endif

        <div class="ui divider" style="margin-bottom:4px;"></div>

        @if($status->status === 'live')
            <button class="ui right floated mini circular negative icon button delete-status" data-content="Delete Now">
                <i class="delete icon"></i>
            </button>
            <div>
                <span class="ui red label" data-content="Will be auto delete">
                    <i class="trash icon"></i> {{$status->will_delete_in}}
                </span>
            </div>
        @else
            <button class="ui right floated mini circular negative icon button delete-status" data-content="Cancel Post">
                <i class="delete icon"></i>
            </button>
            <button class="ui right floated mini circular green icon button post-status" data-content="Send Now">
                <i class="send icon"></i>
            </button>
            <div>
                <span class="ui green label" data-content="Will be send to {{ucwords($status->provider)}}">
                    <i class="send icon"></i> {{$status->will_post_in}}
                </span>
            </div>
        @endif
    </div>
</div>
