@props(['categories','groups'])


<div class="container" id="main-wrapper">
  <div class="row justify-content-center my-5">
      <div class="col-xl-10">
          <div class="card border-0 card">
              <div class="card-body p-0 card">
                  <div class="row no-gutters">
                      <div class="col">
                          <div class="p-5">
                              <div class="mb-5">
                                  <h3 class="h4 font-weight-bold text-theme text-center">Anket Oluştur</h3>
                              </div>
                              <form method="POST" action="/pool/create" >
                                @csrf
                                  <div class="form-group"><label class="form-label" for="anketbaslik">Anket Başlığı</label>
                                  <input class="form-control form-control" type="text" id="anketbaslik" value="{{ old('title') }}" name="title">
                                  @error('title')
                                  <p class="text-danger text-sm mt-1">
                                   {{$message}}
                                  </p>
                                  @enderror
                                  </div>
                                  <div class="form-group">
                                    <label class="form-label" for="anketkategori">Anket Kategorisi</label>
                                    <select class="form-control" id="anketkategori" name="category">
                                        <option value="">Kategori Seçin</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category') == $category->id ? 'selected' : '' }}>
                                                {{ $category->category_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <p class="text-danger text-sm mt-1">
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                      @php
                                       $optionCount = count(old('option', ['Seçenek 1', 'Seçenek 2']));
                                      @endphp
                                    <div id="secenek-alanlari" data-option-count="{{ $optionCount }}">

                                      @for ($i = 0; $i < $optionCount; $i++)
                                          <div class="form-group new-option" >
                                              <label class="form-label" for="secenek{{ $i + 1 }}">Seçenek {{ $i + 1 }}</label>
                                              <div class="d-flex align-items-center">
                                                  <input class="form-control form-control" type="text" name="option[]" id="secenek{{ $i + 1 }}" value="{{ old('option.' . $i) }}">
                                                  @if($i == 1)
                                                      <button class="btn btn-success  rounded"  onclick="addOption()" type="button" style="background:rgb(34, 34, 34);">
                                                      <i class="fas fa-plus"></i>
                                                      </button>
                                                  @endif
                                                  @if ($i >= 2)
                                                      <button type="button" class="btn d-flex align-items-center btn-danger rounded" onclick="secenekSil(this)">
                                                          <i class="fas fa-trash-alt me-1"></i> Sil
                                                      </button>
                                                  @endif
                                              </div>
                                  
                                              <div class="error-div">
                                                  @if ($errors->has('option.' . $i))
                                                      <p class="text-danger text-sm mt-1">{{ $errors->first('option.' . $i) }}</p>
                                                  @endif
                                              </div>
                                  
                                          </div>
                                      @endfor
                                </div>
                                <div class="form-group">
                                  <label class="form-label d-block" for="anketsure">Anket Süresi</label> 
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hasEndDate" id="endDateYes" {{ old('hasEndDate') == 1   ? "checked" : null}}   value="1">
                                    <label class="form-check-label" for="endDateYes">
                                      Belirli Bir Tarih
                                    </label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="hasEndDate" id="endDateNo" {{ old('hasEndDate') == "0"   ? "checked" : null}} value="0" >
                                    <label class="form-check-label" for="endDateNo">
                                      Sınırsız
                                    </label>
                                  </div>
                                  @error('hasEndDate')
                                  <p class="text-danger text-sm mt-1">
                                    {{$message}}
                                  </p>
                                  @enderror
                                  <input class="form-control form-control" type="datetime-local" id="anketsure" value="{{ old('poolEndTime') }}" name="poolEndTime" style="display: {{ old('poolEndTime') != null   ? "block" : "none" }}">
                                  @error('poolEndTime')
                                    <p class="text-danger text-sm mt-1">
                                      {{$message}}
                                    </p>
                                  @enderror
                                </div>
                                @if($groups != null)
                                <div class="form-group">
                                  <label class="form-label d-block" for="anketsure">Anket Tipi</label> 
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="groupPoll" {{ old('groupPoll') == 1   ? "checked" : null}} id="groupPoll" value="1">
                                      <label class="form-check-label" for="groupPoll">
                                          Grup Anket
                                      </label>
                                  </div>
                                  <div class="form-check form-check-inline">
                                      <input class="form-check-input" type="radio" name="groupPoll" {{ old('groupPoll') == "0"   ? "checked" : null}} id="publicPoll" value="0" >
                                      <label class="form-check-label" for="publicPoll">
                                          Herkese Açık Anket
                                      </label>
                                  </div>
                                  @error('groupPoll')
                                            <p class="text-danger text-sm mt-1">
                                               {{$message}}
                                            </p>
                                  @enderror
                                  <div id="groupPollOptions"  style="display: {{ old('groupPoll') == "1"  ? "block" : "none" }}">
                                      <div class="form-group">
                                          <label class="form-label" for="groupPoll">Grup Listesi</label>
                                          <select class="form-control" id="groupPollSelect" name="groupId">
                                              <option value="">Grup Seçin</option>
                                              @foreach ($groups as $group)
                                                  <option value="{{ $group->id }}" {{ old('groupId') == $group->id ? 'selected' : '' }}>
                                                      {{ $group->title }}
                                                  </option>
                                              @endforeach
                                          </select>
                                          @error('groupId')
                                            <p class="text-danger text-sm mt-1">
                                               {{$message}}
                                            </p>
                                          @enderror
                                      </div>
                                  </div>
                              </div>
                              @endif
                                  <div class="form-group mb-5"><label class="form-label" for="anketaciklama">Anket Açıklama</label><textarea class="form-control form-control" type="description" id="anketaciklama" name="description" placeholder="Anket açıklamasını yazınız..">{{old('description')}}</textarea>
                                    @error('description')
                                    <p class="text-danger text-sm mt-1">
                                      {{ $message  }}
                                    </p>
                                    @enderror</div>
                                  <button class="btn btn-success btn-lg rounded mb-1" onclick="submitForm(event)"  type="submit" style="background:rgb(34, 34, 34);">Anket Oluştur</button>
                              
                              </form>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
</div>








  