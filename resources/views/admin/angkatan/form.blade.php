
          <div class="form-group">
            <div class="col-sm-6">
              <label for="inputTahun">Tahun</label>
              <input type="text" name="tahun" id="tahun" class="form-control @error('tahun') is-invalid @enderror" placeholder="Nama.." value="{{ old('tahun', $update ? $angkatan->tahun:'') }}">
            </div>
            @error('tahun')
                <span role="alert">
                    <strong>{{ $message }}</strong>
                </span>
             @enderror
          </div>
          