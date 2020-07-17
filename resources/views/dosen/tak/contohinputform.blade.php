<div class="form-group @error('kategoritak_id') has-error @enderror">
        <label for="kategoritak_id">Kategori</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="kategoritak_id" id="kategoritak_id" class="form-control" required>
                <option value="">- Pilih Kategori -</option>
                @foreach($kategoritaks as $id => $nama)
                    <option value="{{ $id }}">
                    {{ $nama }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.kegiatanTAK.create') }}" class="btn btn-primary" style="width: 100%;">Tambah Kategori TAK</a>
        </div>
        </div>
        @error('kategoritak_id')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group @error('pilartak_id') has-error @enderror">
        <label for="pilartak_id">Pilar</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="pilartak_id" id="pilartak_id" class="form-control" required>
                <option value="">- NA -</option>
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
    <div class="form-group @error('kegiatantak_id') has-error @enderror">
        <label for="pilartak_id">Kegiatan</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="kegiatantak_id" id="kegiatantak_id" class="form-control" required>
                <option value="">- NA -</option>
            </select>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.kegiatanTAK.create') }}" class="btn btn-primary" style="width: 100%;">Tambah Kegiatan TAK</a>
        </div>
        </div>
        @error('kegiatantak_id')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group @error('tingkattak_id') has-error @enderror">
        <label for="pilartak_id">Tingkat</label>
        <div class="row">
        <div class="col-sm-6">
            <select name="tingkattak_id" id="tingkattak_id" class="form-control" required>
                <option value="">- NA -</option>
            </select>
        </div>
        <div class="col-sm-3">
            <a href="{{ route('admin.tingkatTAK.create') }}" class="btn btn-primary" style="width: 100%;">Tambah Tingkat TAK</a>
        </div>
        </div>
        @error('tingkattak_id')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
    <div class="form-group">
            <div class="col-sm-6">
              <label for="InputScore">Deskripso</label>
              <input type="text" name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Skor..">
            </div>
         @error('deskripsi')
        <p class="help-block">{{ $message }}</p>
        @enderror
    </div>
@push('scripts')
<script type="text/javascript">
    var host = window.location.href;  
    jQuery(document).ready(function ()
    {
            jQuery('select[name="kategoritak_id"]').on('change',function(){
               var kategoritak_id = jQuery(this).val();
               if(kategoritak_id)
               {
                var url = "{{route('dosen.tak.cekPilar')}}".concat("/" + kategoritak_id);   
             
                  jQuery.ajax({
                     url :  url,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="pilartak_id"]').empty();
                        jQuery('select[name="pilartak_id"]').append('<option>--Pilih Pilar--</option>');
                        jQuery.each(data, function(id,nama){
                           $('select[name="pilartak_id"]').append('<option value="'+ id +'">'+ nama +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="pilartak_id"]').empty();
               }
            });
            jQuery('select[name="pilartak_id"]').on('change',function(){
               var pilartak_id = jQuery(this).val();
               if(pilartak_id)
               {
                var urlPilar = "{{route('dosen.tak.cekKegiatan')}}".concat("/" + pilartak_id);   
         
                  jQuery.ajax({
                     url : urlPilar,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="kegiatantak_id"]').empty();
                        jQuery('select[name="kegiatantak_id"]').append('<option>--Pilih Kegiatan--</option>');
                        jQuery.each(data, function(id,nama){
                           $('select[name="kegiatantak_id"]').append('<option value="'+ id +'">'+ nama +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="kegiatantak_id"]').empty();
               }
            });
            jQuery('select[name="kegiatantak_id"]').on('change',function(){
               var kegiatantak_id = jQuery(this).val();
               if(kegiatantak_id)
               {
                var urlKegiatan = "{{route('dosen.tak.cekTingkat')}}".concat("/" + kegiatantak_id);   
                console.log(urlKegiatan);
                  jQuery.ajax({
                     url :  urlKegiatan,
                     type : "GET",
                     dataType : "json",
                     success:function(data)
                     {
                        console.log(data);
                        jQuery('select[name="tingkattak_id"]').empty();
                        jQuery('select[name="tingkattak_id"]').append('<option>--Pilih Tingkat--</option>');
                        jQuery.each(data, function(id,nama){
                           $('select[name="tingkattak_id"]').append('<option value="'+ id +'">'+ nama +'</option>');
                        });
                     }
                  });
               }
               else
               {
                  $('select[name="tingkattak_id"]').empty();
               }
            });
    });
</script>
@endpush