@extends('templates.default')

@section('content')
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <h3>Регистрация</h3>
            <form method="POST" action="{{ route('auth.signup') }}" novalidate>
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" class="form-control {{ $errors->has('email') ? ' is-invalid ' : '' }}"
                        id="email" placeholder="Например vasya@gmail.com" value="{{ Request::old('email') ?: '' }}">

                    @if ($errors->has('email'))
                        <span class="help-block text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="username">Login</label>
                    <input type="text" name="username"
                        class="form-control {{ $errors->has('username') ? ' is-invalid ' : '' }}" id="username"
                        placeholder="Например Vasia Puplin" value="{{ Request::old('username') ?: '' }}">
                    @if ($errors->has('username'))
                        <span class="help-block text-danger">{{ $errors->first('username') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password"
                        class="form-control {{ $errors->has('password') ? ' is-invalid ' : '' }}" id="password"
                        placeholder="Минимум 6 символов">
                    @if ($errors->has('password'))
                        <span class="help-block text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="row col-md-7">
                        <select name="gender" class="custom-select @error('gender') is-invalid @enderror" id="">
                            <option value="">Ваш пол</option>
                            <option value="m" {{ old('gender') === 'm' ? 'selected' : '' }}>Мужчина</option>
                            <option value="f" {{ old('gender') === 'f' ? 'selected' : '' }}>Женщина</option>
                        </select>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Создать аккаунт</button>
            </form>
        </div>

    </div>
@endsection
