<div class="form-group{{ $errors->has('username') ? ' has-error' : ''}}">
    {!! Form::label('username', 'Username', ['class' => 'control-label']) !!}
    {!! Form::text('username', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('username', '<p class="help-block text-danger">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('name') ? ' has-error' : ''}}">
    {!! Form::label('name', 'Name', ['class' => 'control-label']) !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('name', '<p class="help-block text-danger">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : ''}}">
    {!! Form::label('email', 'Email', ['class' => 'control-label']) !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
    {!! $errors->first('email', '<p class="help-block text-danger">:message</p>') !!}
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : ''}}">
    {!! Form::label('password', 'Password', ['class' => 'control-label']) !!}
    @php
        $passwordOptions = ['class' => 'form-control'];
        if ($formMode === 'create') {
            $passwordOptions = array_merge($passwordOptions, ['required' => 'required']);
        }
    @endphp
    {!! Form::password('password', $passwordOptions) !!}
    {!! $errors->first('password', '<p class="help-block text-danger">:message</p>') !!}
</div>
@if (isset($user))
    @if (Auth::user()->id == $user->id)


        <div class="row form-group {{ $errors->has('picture') ? 'has-error' : ''}}">
            {!! Form::label('picture', 'Picture', ['class' => 'col-md-12 control-label']) !!}
            <div class="col-md-12">
                <input type="file" name="picture" id="picture" accept="image/*">
            </div>
            {!! $errors->first('picture', '<p class="help-block text-danger">:message</p>') !!}
        </div>
    @endif
@endif
@if (Auth::user()->hasRole('superadmin') || Auth::user()->hasRole('admin'))
    <div class="form-group {{ $errors->has('active') ? 'has-error' : ''}}">
        {!! Form::label('active', 'Active', ['class' => 'control-label']) !!}
        <select class="select2 form-control" id="active" name="active">
            @if (isset($user))
                <option value="{{ $user->active }}">Selected {{ $user->active == 1 ? 'Active' : 'Non Active' }}</option>
            @endif
            <option value="1">Active</option>
            <option value="0">Non Active</option>
        </select>
        {!! $errors->first('active', '<p class="help-block text-danger">:message</p>') !!}
    </div>
    <div class="form-group{{ $errors->has('roles') ? ' has-error' : ''}}">
        {!! Form::label('role', 'Role', ['class' => 'control-label']) !!}
        {!! Form::select('roles[]', $roles, isset($user_roles) ? $user_roles : [], ['class' => 'form-control ht-100', 'multiple' => true]) !!}
    </div>
@endif
<hr/>
<div class="form-group">
    {!! Form::submit($formMode === 'edit' ? 'Update' : 'Create', ['class' => 'btn btn-primary']) !!}
</div>
