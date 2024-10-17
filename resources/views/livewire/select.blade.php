<select class="input w-100" name="usuario" id="usuario">
    <option value="">Todos</option>
    @foreach(\App\Models\User::all() as $user)
        <option @if($id && $id == $user->id) selected @endif value="{{$user->id}}">{{$user->nome}}</option>
    @endforeach
</select>