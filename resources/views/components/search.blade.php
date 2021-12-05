<form action="{{ route('search') }}">
    <div class="d-flex rounded-pill bg-white border border-2 border-green overflow-hidden" style="padding: 2px">
        <input type="text" name="q"
               autocomplete="off"
               value="{{ request('q') }}"
               class="form-control shadow-none border-0 rounded-0 bg-transparent"
               placeholder="جستجو در محصولات ...">
        <button type="submit" class="bg-green border-0 text-white rounded-pill ">
            <i class="far fa-search mx-3"></i>
        </button>
    </div>
</form>
