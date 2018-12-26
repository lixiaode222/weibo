<form method="POST" action="{{ route('statuses.store') }}">
    @include('shared._errors')
    {{ csrf_field() }}
    <textarea class="form-control" rows="3" placeholder="今天有什么想说的..." name="content">{{ old('content') }}</textarea>
    <div class="text-right">
        <button type="submit" class="btn btn-primary mt-3">发布</button>
    </div>
</form>