<div class="container" id="main-wrapper">
    <div class="row justify-content-center my-5">
        <div class="col-xl-10">
            <div class="card border-0 card">
                <div class="card-body p-0 card">
                    <div class="row no-gutters">
                        <div class="col-md-6">
                            <div class="p-5">
                                <div class="mb-5">
                                    <h3 class="h4 font-weight-bold text-theme">Kayıt Ol</h3>
                                </div>
                                <form action="/user/create" method="POST" onsubmit="return checkForm(this);" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-group">
                                    <label class="form-label" for="yourName">Kullanıcı Adı</label>
                                    <input class="form-control form-control" type="text" id="yourName" autocomplete="name" value="{{old('name')}}" name="name">
                                    @error('name')
                                    <p class="text-danger text-sm mt-1">
                                     {{$message}}
                                    </p>
                                    @enderror
                                    </div>
                                    <div class="form-group">
                                    <label class="form-label" for="exampleInputEmail1">E-posta adresi</label>
                                    <input class="form-control form-control" type="email" id="exampleInputEmail1" autocomplete="email" value="{{old("email")}}" name="email" >
                                    @error('email')
                                    <p class="text-danger text-sm mt-1">
                                     {{$message}}
                                    </p>
                                    @enderror
                                    </div>
                                    <div class="form-group">
                                    <label class="form-label" for="exampleInputPassword1">Şifre</label>
                                    <input class="form-control form-control" type="password" autocomplete="new-password" id="exampleInputPassword1"  name="password">
                                    @error('password')
                                    <p class="text-danger text-sm mt-1">
                                     {{$message}}
                                    </p>
                                    @enderror
                                    </div>
                                    <div class="form-group">
                                    <label class="form-label" for="exampleInputPassword2">Şifre tekrar</label>
                                    <input class="form-control form-control" type="password" autocomplete="new-password" id="exampleInputPassword2"  name="password_confirmation">
                                    @error('password_confirmation')
                                    <p class="text-danger text-sm mt-1">
                                     {{$message}}
                                    </p>
                                    @enderror
                                    </div>
                                    <div class="form-group mb-5">
                                        <label class="form-label" for="fileupload1">Profil Resmi(Opsiyonel)</label>
                                        <input class="form-control form-control" type="file" name="profilepicture" id="fileupload1" style="border: 1px solid #ced4da; padding: .375rem .75rem; font-size: 1rem; line-height: 1.5; border-radius: .25rem;">
                                        @error('profilepicture')
                                    <p class="text-danger text-sm mt-1">
                                     {{$message}}
                                    </p>
                                    @enderror
                                      </div>
                                      
                                    <button class="btn btn-success btn-lg rounded" onclick="submitForm(event)" type="submit" style="background:rgb(34, 34, 34);">Kayıt Ol</button>
                                </form>
                            </div>
                        </div>
                        <div class="col-md-6 d-none d-md-inline-block">
                            <div class="account-block rounded-right">
                                <div class="overlay rounded-right"></div>
                                <div class="account-testimonial">
                                    <h4 class="text-white mb-4">DÜŞÜNCENİ BELİRT,OYUNU VER.</h4>
                                    <p class="lead text-white">"Bir oy bile, birçok kez hiçbir şey yapmaktan daha etkilidir."</p>
                                    <p>- John F. Kennedy</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <p class="text-center text-muted mt-3 mb-0">Zaten hesabın var mı?&nbsp;<a class="ml-1" href="/login">Giriş yap</a></p>
        </div>
    </div>
</div>



