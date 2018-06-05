@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ $thread->creator->name }}</a> posted: {{ $thread->title }}
                    </div>

                    <div class="card-body">
                            {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                @foreach($thread->replies as $reply)
                    @include ('threads.reply')
                @endforeach
            </div>
        </div>

        @if(auth()->check())
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="POST" action="{{$thread->path()}}/replies">

                    {{csrf_field()}}

                    <div class="form-group mt-5">
                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5"></textarea>
                    </div>

                    <button type="submit" class="btn btn-default">Post</button>
                </form>
            </div>
        </div>
        @else
            <div class="row justify-content-center mt-5">
                <p>Please <a href="{{ route('login') }}">Sign In</a> to partecipate in this discussion.</p>
            </div>
        @endif
    </div>
@endsection
