<div class="container" id="main-wrapper">
    <div class="row justify-content-center my-5">
        <div class="col-xl-10">
            <div class="card border-0 card">
                <div class="card-body p-0 card">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <div class="p-5">
                                <div class="mb-5">
                                    <h3 class="h4 font-weight-bold text-theme">Giriş Yap</h3>
                                </div>
                                <form method="POST" action="/authenticate" onsubmit="return checkForm(this);">
                                    @csrf
                                    <div class="form-group"><label class="form-label" for="exampleInputEmail1">E-posta adresi</label>
                                    <input class="form-control form-control" type="email" id="exampleInputEmail1" autocomplete="email" value="{{old('email')}}" name="email">
                                    @error('email')
                                    <p class="text-danger text-sm mt-1">
                                     {{$message}}
                                    </p>
                                    @enderror
                                    </div>
                                    <div class="form-group mb-5"><label class="form-label" for="exampleInputPassword1">Şifre</label>
                                    <input class="form-control form-control" type="password" id="exampleInputPassword1" autocomplete="current-password" name="password">
                                    @error('password')
                                    <p class="text-danger text-sm mt-1">
                                     {{$message}}
                                    </p>
                                    @enderror
                                    </div>
                                    <button class="btn btn-success btn-lg rounded" onclick="submitForm(event)" type="submit" style="background:rgb(34, 34, 34);">Giriş Yap</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-md-inline-block">
                            <div class="account-block rounded-right">
                                <div class="overlay rounded-right"></div>
                                <div class="account-testimonial">
                                    <h4 class="text-white mb-4">DÜŞÜNCENİ BELİRT,OYUNU VER.</h4>
                                    <p class="lead text-white">"Siz oylarınızı kullanmazsanız, diğer insanlar sizin geleceğinizi şekillendirecektir."</p>
                                    <p>- Loung Ung</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center text-muted mt-3 mb-0">Hesabın yok mu?&nbsp;<a class="ml-1" href="/register">Kayıt Ol</a></p>
        </div>
    </div>
</div>
