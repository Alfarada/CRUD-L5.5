
{{-- ShowErrors --}}
@if($errors->any())
<div class="alert alert-danger">
    <p> <h6>Corrige los siguientes errores</h6> </p>
    <ul>
        @foreach($errors->all() as $error)
        <li> {{ $error }} </li>
        @endforeach
    </ul>
</div>
@endif