<div class="chat-wrapper p-1">
@foreach($list as $value)
       
        @if($value->created_by != \Auth::user()->id)
        <div class="chat-box-wrapper">
            <div>
                <div class="avatar-icon-wrapper mr-1">
                    <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                    <div class="avatar-icon avatar-icon-lg rounded">
                        <img src="{{ url('/assets/images/avatars/custom.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div>
                <div class="chat-box">{{ $value->message }}</div>
                <small class="opacity-6">
                    <i class="fa fa-calendar-alt mr-1"></i>
                    {{timeAgo($value->created_at, date("Y-m-d H:i:s"))}} | {{ $value->operator }}
                </small>
            </div>
        </div>
        
        @else
        <div class="float-right">
            <div class="chat-box-wrapper chat-box-wrapper-right">
                <div>
                    <div class="chat-box">{{ $value->message }}</div>
                    <small class="opacity-6">
                        <i class="fa fa-calendar-alt mr-1"></i>
                        {{timeAgo($value->created_at, date("Y-m-d H:i:s"))}} | {{ $value->operator }}
                    </small>
                </div>
                <div>
                    <div class="avatar-icon-wrapper ml-1">
                        <div class="badge badge-bottom btn-shine badge-success badge-dot badge-dot-lg"></div>
                        <div class="avatar-icon avatar-icon-lg rounded">
                            <img src="{{ url('/assets/images/avatars/custom.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @endif
    @endforeach
</div>