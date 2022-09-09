@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card shadow">
                <div class="card-header">
                    <h3>Логин</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-8">
                                <div class="form-group">
                                    <label class="form-control-label" for="name">
                                        Введите свое имя
                                    </label>
                                    <div class="input-group input-group-alternative mb-4">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">
                                                @svg('si-premierleague')
                                            </span>
                                        </div>
                                        <input type="text"
                                               name="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               placeholder="Ivan Ivanov"
                                        />
                                    </div>
                                    @error('name')
                                        <span class="invalid-feedback d-block" role="alert">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-success">
                                        Войти
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
