@if ($errors->any())
<div class="error">
    <ul style="list-style: none;padding: 0">
    @foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
    @endforeach
    </ul>
</div>
@endif