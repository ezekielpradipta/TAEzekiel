    <div class="form-group @error('kategoritak_id') has-error @enderror">
        <label for="kategoritak_id">Kategori</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="kategoritak_id" class="form-control" required>
                <option value="">- Pilih Kategori -</option>
                @foreach($kategoritaks as $kategoritak)
                    <option value="{{ $kategoritak->id }}" @if($update && $pilarTAK->kategoritak_id==$kategoritak->id) selected @endif>
                    {{ $kategoritak->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.kategoriTAK.create') }}" class="btn btn-primary" style="width: 100%;">Tambah Kategori TAK</a>
        </div>
        </div>
        @error('kategoritak_id')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="InputNama">Nama Pilar</label>
              <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama.." value="{{ old('nama', $update ? $pilarTAK->nama:'') }}">
            </div>
                @error('nama')
                    <span role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
          </div>
          