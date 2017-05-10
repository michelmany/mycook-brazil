@if (count($errors->get($field)) > 0)
    <div class="text-danger">
        <ul>
            @foreach ($errors->get($field) as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif