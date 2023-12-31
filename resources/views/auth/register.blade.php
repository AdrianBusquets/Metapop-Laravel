<x-layout>
    <!--Register-->
    <div class="container-fluid">
    <div class="d-flex justify-content-center">
        <div class="Sesion col-9 col-md-4 col-lg-3 row text-center">
                <!--FORM TITLE-->
                    <h2 class="form-title space-around">{{__('Crear cuenta') }}</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ( $errors->all() as $error )
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!--FORM FIELDS-->
                <form action="/register" method="POST" role="form" class="form-control formularios">
                    @csrf
                    <!--Name-->
                    <div class="space-around my-2">
                        <input type="text" name="name" id="name" class="form-control forms-field-input" placeholder="{{__('Tu nombre') }}" data-rule="minlen:4" data-msg="Please enter at least 4 chars"><!--si no vale es _ en forms_field-->
                        <div class="validate"></div>

                    </div>
                    <!-- Email-->
                    <div class="space-around my-2">
                        <input type="email" name="email" id="email" class="form-control forms_field-input" placeholder="{{__('Tu correo') }}" data-rule="minlen:4" data-msg="PLease enter at least 4 chars">
                        <div class="validate"></div>

                    </div>
                    <!--Password-->
                    <div class="space-around my-2">
                        <input type="password" name="password" id="password" class="form-control forms_field-input" placeholder="{{__('Tu contraseña') }}">
                        <div class="validate"></div>

                    </div>
                    <!--Password Confirmation-->
                    <div class="space-around my-2">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control forms_field-input" placeholder="{{__('Tu contraseña otra vez') }}">
                        <div class="validate"></div>

                    </div>
                    <!-- Button-Register-->
                    <button type="submit" class="btn btn-info">
                        {{__('Crear cuenta') }}
                    </button>
                </form>

                <p class="my-3">{{__('¿Ya eres de los nuestros?') }} <a href="{{ route('login') }}" class="btn btn-info btn-sm ms-2">{{__('Entra!') }}</a></p>

        </div>

    </div>

</div>

</section>
</x-layout>