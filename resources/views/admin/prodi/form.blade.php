
          <div class="form-group">
            <div class="col-sm-6">
              <label for="InputNama">Nama</label>
              <input type="text" name="nama" id="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama.." value="{{ old('nama', $update ? $prodi->nama:'') }}">
            </div>
          </div>
          