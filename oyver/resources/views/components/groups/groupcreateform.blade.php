<div class="container" id="main-wrapper">
  <div class="row justify-content-center my-5">
      <div class="col-xl-10">
          <div class="card border-0 card">
              <div class="card-body p-0 card">
                  <div class="row no-gutters">
                      <div class="col">
                          <div class="p-5">
                              <div class="mb-5">
                                  <h3 class="h4 font-weight-bold text-theme text-center">Grup Oluştur</h3>
                              </div>
                              <form method="POST" action="/group/create" >
                                @csrf
                                  <div class="form-group"><label class="form-label" for="grouptitle">Grup Adı</label>
                                  <input class="form-control form-control" type="text" id="groupTitle" value="{{ old('title') }}" name="title">
                                  @error('title')
                                  <p class="text-danger text-sm mt-1">
                                   {{$message}}
                                  </p>
                                  @enderror
                                  </div>
                                  <div class="form-group">
                                    <label class="form-label d-block" for="anketsure">Üye Gizliliği</label> 
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="userprivacy" value="0">
                                      <label class="form-check-label" for="privateUsers">
                                        Üyeler gizli olsun
                                      </label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="userprivacy"  value="1">
                                      <label class="form-check-label" for="publicUsers">
                                        Üyeler görünür olsun
                                      </label>
                                    </div>
                                    @error('userprivacy')
                                      <p class="text-danger text-sm mt-1">
                                        {{$message}}
                                      </p>
                                    @enderror
                                  </div>
                                  
                                    <div class="form-group mb-5">
                                      <label class="form-label" for="groupDescription">Grup Açıklama</label>
                                      <textarea class="form-control form-control" type="description" id="groupDescription" name="description" placeholder="Anket açıklamasını yazınız..">{{old('description')}}</textarea>
                                      @error('description')
                                      <p class="text-danger text-sm mt-1">
                                        {{$message}}
                                      </p>
                                      @enderror
                                    </div>
                                      <button class="btn btn-success btn-lg rounded mb-1" onclick="submitForm(event)"  type="submit" style="background:rgb(34, 34, 34);">Grup Oluştur</button>
                                </div>

                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>