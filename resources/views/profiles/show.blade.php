@extends ('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="pb-2 mb-2 mt-4 border-bottom">
                    <h1>
                        {{ $profileUser->name }}
                        <small>Since {{$profileUser->created_at->diffForHumans()}}</small>
                    </h1>
                </div>

                @foreach($activities as $date => $activity)
                    <h3 class="pb-2 mb-2 mt-4 border-bottom">{{ $date }}</h3>
                    @foreach($activity as $record)
                        @include("profiles.activities.{$record->type}", ['activity' => $record])
                    @endforeach
                @endforeach

                {{--{{ $threads->links() }}--}}
            </div>
        </div>
    </div>
@endsection