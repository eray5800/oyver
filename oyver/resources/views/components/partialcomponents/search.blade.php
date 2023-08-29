@props(['action','placeholder','categories' => ''])
<div class="mb-3">
    <div class="card">
        <div class="card-body">
            <form action="{{$action}}" class="d-flex align-items-center mb-0">
                <i class="fas fa-search text-body  h4 m-0"></i>
                <input class="form-control flex-shrink-1 form-control form-control form-control form-control-lg form-control-borderless" type="search" value="@php echo(request()->search) @endphp"    placeholder="{{$placeholder}}" name="search">

                @if($categories != '')
                <div class="form-group d-none d-sm-block  me-2 ">
                    <select class="form-control-lg" id="anketkategori" name="category" >
                        <option value="">Kategori Seçin</option>
                        
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ request()->category == $category->id ? 'selected' : '' }}>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
                <button class="btn btn-success btn-lg rounded" onclick="submitForm(event)" type="submit" style="background: rgb(34, 34, 34);">Ara</button>
            </form>
        </div>
        
    </div>
</div>