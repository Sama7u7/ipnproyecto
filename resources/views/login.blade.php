@extends ('layouts.layoutlogin')
@section ('content')
<section class="vh-100" style="background-color: #761345;">
    <div class="container py-5 h-100">
      <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col col-xl-10">
          <div class="card" style="border-radius: 1rem;">
            <div class="row g-0">
              <div class="col-md-6 col-lg-5 d-none d-md-block">
                <img src="{{ asset('ipn-fachada.webp') }}"
                alt="login form"
                class="img-fluid w-100 h-auto"
                style="max-height: 800px; border-radius: 1rem 0 0 1rem;" />

            </div>
            <div class="col-md-6 col-lg-7 d-flex align-items-center">
                <div class="card-body p-4 p-lg-5 text-black">

                    <form method="POST" action="{{ route('login.submit') }}">
                    @csrf <!-- Token CSRF necesario para la seguridad del formulario -->

                    <div class="d-flex align-items-center mb-3 pb-1">
                        <a href="/login">
                            <img src="{{ asset('logoipn.svg') }}" alt="Logo CICATA" style="width: 100px; height: 90px;">
                         </a>

                      <span class="h1 fw-bold mb-0" style="color: #761345;">CICATA</span>
                    </div>

                    <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Inicia sesión</h5>

                    <div data-mdb-input-init class="form-outline mb-4">
                      <input type="email" id="email" name="email" class="form-control form-control-lg" value="{{ old('email') }}" required />
                      <label class="form-label" for="email">Correo electrónico</label>
                      @error('email')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div data-mdb-input-init class="form-outline mb-4">
                      <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                      <label class="form-label" for="password">Contraseña</label>
                      @error('password')
                        <div class="text-danger">{{ $message }}</div>
                      @enderror
                    </div>

                    <div class="pt-1 mb-4">
                      <button class="btn btn-primary btn-lg btn-block" type="submit">Iniciar sesión</button>
                    </div>

                    @if(session('error'))
                      <div class="alert alert-danger">
                        {{ session('error') }}
                      </div>
                    @endif

                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
