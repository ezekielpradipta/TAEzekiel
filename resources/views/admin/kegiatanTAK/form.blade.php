    <div class="form-group @error('pilartak_id') has-error @enderror">
        <label for="pilartak_id">Pilar</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="pilartak_id" class="form-control" required>
                <option value="">- Pilih Pilar -</option>
                @foreach($pilartaks as $pilartak)
                    <option value="{{ $pilartak->id }}" @if($update && $kegiatanTAK->pilartak_id==$pilartak->id) selected @endif> {{$pilartak->kategoritak->nama}} -
                    {{ $pilartak->nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.pilarTAK.create') }}" class="btn btn-primary" style="width: 100%;">Tambah Pilar TAK</a>
        </div>
        </div>
        @error('pilartak_id')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
          <div class="form-group">
            <div class="col-sm-6">
              <label for="InputNama">Nama Kegiatan</label>
              <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama.." value="{{ old('nama', $update ? $kegiatanTAK->nama:'') }}">
            </div>
         @error('nama')
        <p class="help-block">{{ $message }}</p>
        @enderror
          </div>
          