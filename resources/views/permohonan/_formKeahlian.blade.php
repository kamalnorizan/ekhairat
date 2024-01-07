<input type="hidden" name="type" id="type" class="form-control" value="{{ $type }}">

<div class="row">
    <div class="col-md-12">
        <h4 class="highlight-me">Maklumat Ketua Keluarga</h4>
    </div>
    <div class="col-md-12 form-group{{ $errors->has('nama') ? ' has-error' : '' }}">
        {!! Form::label('nama', 'Nama Penuh', ['class' => 'required-label']) !!}
        {!! Form::text('nama', $keahlian->nama ?? null, [
            'class' => 'form-control',
            'required' => 'required',
            'placeholder' => 'NAMA PENUH',
        ]) !!}
        <small class="text-danger">{{ $errors->first('nama') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('nokp') ? ' has-error' : '' }}">
        {!! Form::label('nokp', 'No Kad Pengenalan', ['class' => 'required-label']) !!}
        {!! Form::text('nokp', $keahlian->nokp ?? null, [
            'class' => 'form-control nokp',
            'required' => 'required',
            'placeholder' => 'cth: 840909-10-4543',
        ]) !!}
        <small class="text-danger">{{ $errors->first('nokp') }}</small>
    </div>

    <div class="col-md-4 form-group{{ $errors->has('tlahir') ? ' has-error' : '' }}">
        {!! Form::label('tlahir', 'Tarikh Lahir') !!}
        {!! Form::date('tlahir', $keahlian->tlahir ?? null, [
            'class' => 'form-control',
            'placeholder' => 'TARIKH LAHIR',
        ]) !!}
        <small class="text-danger">{{ $errors->first('tlahir') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('umur') ? ' has-error' : '' }}">
        {!! Form::label('umur', 'Umur') !!}
        {!! Form::text(
            'umur',
            $keahlian->tlahir != null ? \Carbon\Carbon::parse($keahlian->tlahir)->diffInYears(\Carbon\Carbon::now()) : null,
            ['class' => 'form-control umur', 'placeholder' => 'UMUR'],
        ) !!}
        <small class="text-danger">{{ $errors->first('umur') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('notel_r') ? ' has-error' : '' }}">
        {!! Form::label('notel_r', 'No Phone(R)') !!}
        {!! Form::text('notel_r', $keahlian->notel_r ?? null, [
            'class' => 'form-control',
            'placeholder' => '0X-XXXXXXXX',
        ]) !!}
        <small class="text-danger">{{ $errors->first('notel_r') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('notel_hp') ? ' has-error' : '' }}">
        {!! Form::label('notel_hp', 'No Phone(HP)', ['class' => 'required-label']) !!}
        {!! Form::text('notel_hp', $keahlian->notel_hp ?? null, [
            'class' => 'form-control',
            'placeholder' => '0X-XXXXXXXX',
            'required' => 'required',
        ]) !!}
        <small class="text-danger">{{ $errors->first('notel_hp') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('notel_p') ? ' has-error' : '' }}">
        {!! Form::label('notel_p', 'No Phone(P)', ['class' => '']) !!}
        {!! Form::text('notel_p', $keahlian->notel_p ?? null, [
            'class' => 'form-control',
            'placeholder' => '0X-XXXXXXXX',
        ]) !!}
        <small class="text-danger">{{ $errors->first('notel_p') }}</small>
    </div>
    <div class="col-md-6 form-group{{ $errors->has('pekerjaan') ? ' has-error' : '' }}">
        {!! Form::label('pekerjaan', 'Pekerjaan') !!}
        {!! Form::text('pekerjaan', $keahlian->pekerjaan ?? null, [
            'class' => 'form-control',
            'placeholder' => 'PEKERJAAN',
        ]) !!}
        <small class="text-danger">{{ $errors->first('pekerjaan') }}</small>
    </div>
    <div class="col-md-6 form-group{{ $errors->has('email') ? ' has-error' : '' }}">
        {!! Form::label('email', 'Email') !!}
        {!! Form::email('email', $keahlian->user->email ?? null, [
            'class' => 'form-control',
            'placeholder' => 'cth: example@gmail.com',
        ]) !!}
        <small class="text-danger">{{ $errors->first('email') }}</small>
    </div>
    <div class="col-md-8 form-group{{ $errors->has('alamat') ? ' has-error' : '' }}">
        {!! Form::label('alamat', 'Alamat', ['class' => 'required-label']) !!}
        {!! Form::text('alamat', $keahlian->alamat ?? null, [
            'class' => 'form-control',
            'placeholder' => 'ALAMAT',
            'required' => 'required',
        ]) !!}
        <small class="text-danger">{{ $errors->first('alamat') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('ltalamat_id') ? ' has-error' : '' }}">
        {!! Form::label('ltalamat_id', 'Kawasan Alamat') !!}
        {!! Form::select('ltalamat_id', $lt_alamat, $keahlian->ltalamat_id ?? null, [
            'id' => 'ltalamat_id',
            'class' => 'form-control',
            'required' => 'required',
        ]) !!}
        <small class="text-danger">{{ $errors->first('ltalamat_id') }}</small>
    </div>
    <div class="radio{{ $errors->has('status') ? ' has-error' : '' }} form-group-default ">
        <div class="row">
            <div class="col-md-12">
                {!! Form::label('status', 'STATUS') !!}
            </div>
        </div>
        <label for="status">
            {!! Form::radio('status', 1, $keahlian->status == 1 ? true : false, [
                'id' => 'radio_status_1',
                'class' => 'statusRadio',
            ]) !!} Berkahwin
        </label>&nbsp;&nbsp;&nbsp;
        <label for="status">
            {!! Form::radio('status', 2, $keahlian->status == 2 ? true : false, [
                'id' => 'radio_status_2',
                'class' => 'statusRadio',
            ]) !!} Janda
        </label>&nbsp;&nbsp;&nbsp;
        <label for="status">
            {!! Form::radio('status', 3, $keahlian->status == 3 ? true : false, [
                'id' => 'radio_status_3',
                'class' => 'statusRadio',
            ]) !!} Duda
        </label>&nbsp;&nbsp;&nbsp;
        <label for="status">
            {!! Form::radio('status', 4, $keahlian->status == 4 ? true : false, [
                'id' => 'radio_status_4',
                'class' => 'statusRadio',
            ]) !!} Bujang
        </label>&nbsp;&nbsp;&nbsp;
        <small class="text-danger">{{ $errors->first('status') }}</small>
    </div>
</div>
<div class="row" id="divPasangan">
    <div class="col-md-12 mt-3">
        <hr>
        <h4 class="highlight-me">Maklumat Pasangan</h4>
    </div>
    <div class="col-md-12 form-group{{ $errors->has('namapasangan') ? ' has-error' : '' }}">
        {!! Form::label('namapasangan', 'Nama Penuh') !!}
        {!! Form::text('namapasangan', $keahlian->namapasangan ?? null, [
            'class' => 'form-control',
            'placeholder' => 'NAMA PENUH PASANGAN',
        ]) !!}
        <small class="text-danger">{{ $errors->first('namapasangan') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('nokppasangan') ? ' has-error' : '' }}">
        {!! Form::label('nokppasangan', 'No Kad Pengenalan') !!}
        {!! Form::text('nokppasangan', $keahlian->nokppasangan ?? null, [
            'class' => 'form-control nokp',
            'required' => 'required',
            'placeholder' => 'cth: 840909-10-4543',
        ]) !!}
        <small class="text-danger">{{ $errors->first('nokppasangan') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('tlahirpasangan') ? ' has-error' : '' }}">
        {!! Form::label('tlahirpasangan', 'Tarikh Lahir') !!}
        {!! Form::date('tlahirpasangan', $keahlian->tlahirpasangan ?? null, [
            'class' => 'form-control',
            'placeholder' => 'TARIKH LAHIR PASANGAN',
        ]) !!}
        <small class="text-danger">{{ $errors->first('tlahirpasangan') }}</small>
    </div>
    <div class="col-md-4 form-group{{ $errors->has('umurpasangan') ? ' has-error' : '' }}">
        {!! Form::label('umurpasangan', 'Umur') !!}
        {!! Form::text('umurpasangan', $keahlian->umurpasangan ?? null, [
            'class' => 'form-control umur',
            'placeholder' => 'UMUR PASANGAN',
        ]) !!}
        <small class="text-danger">{{ $errors->first('umurpasangan') }}</small>
    </div>

    <div class="col-md-6 form-group{{ $errors->has('pekerjaanpasangan') ? ' has-error' : '' }}">
        {!! Form::label('pekerjaanpasangan', 'Pekerjaan') !!}
        {!! Form::text('pekerjaanpasangan', $keahlian->pekerjaanpasangan ?? null, [
            'class' => 'form-control',
            'placeholder' => 'PEKERJAAN PASANGAN',
        ]) !!}
        <small class="text-danger">{{ $errors->first('pekerjaanpasangan') }}</small>
    </div>
    <div class="col-md-6 form-group{{ $errors->has('notelpasangan_hp') ? ' has-error' : '' }}">
        {!! Form::label('notelpasangan_hp', 'No Telefon Pasangan') !!}
        {!! Form::text('notelpasangan_hp', $keahlian->notelpasangan_hp ?? null, [
            'class' => 'form-control',
            'placeholder' => '0X-XXXXXXXX',
        ]) !!}
        <small class="text-danger">{{ $errors->first('notelpasangan_hp') }}</small>
    </div>
</div>
<div class="row" id="divAnak">
    <div class="col-md-12 mt-3">
        <hr>
        <h4 class="highlight-me">Maklumat anak-anak yang berumur 1 tahun sehingga 23 tahun yang masih dalam tanggungan
        </h4>
        <div class="col-md-12" id="tanggunganDiv">
        </div>
        <div class="col-md-12 text-center">
            <button type="button" class="btn btn-primary" id="tambahTanggungan"> <i class="fa fa-plus"
                    aria-hidden="true"></i> Tambah Tanggungan</button>
        </div>
    </div>
</div>
<div class="row" id="divWaris">
    <div class="col-md-12 mt-3">
        <hr>
        <h4 class="highlight-me">Waris Terdekat (Jika berlaku kecemasan & rujukan)</h4>
    </div>
    <div class="col-md-6 form-group{{ $errors->has('namawaris') ? ' has-error' : '' }}">
        {!! Form::label('namawaris', 'Nama Penuh', ['class' => 'required-label']) !!}
        {!! Form::text('namawaris', $keahlian->namawaris ?? null, [
            'class' => 'form-control',
            'placeholder' => 'NAMA PENUH WARIS',
        ]) !!}
        <small class="text-danger">{{ $errors->first('namawaris') }}</small>
    </div>
    <div class="col-md-6 form-group{{ $errors->has('hubungan') ? ' has-error' : '' }}">
        {!! Form::label('hubunganwaris', 'Hubungan') !!}
        {!! Form::select(
            'hubunganwaris',
            [
                'Ayah Kandung' => 'AYAH',
                'Ibu Kandung' => 'IBU',
                'Mertua' => 'MERTUA',
                'Anak Kandung' => 'ANAK',
                'Menantu' => 'MENANTU',
                'Anak Tiri' => 'ANAK TIRI',
                'Adik Beradik' => 'ADIK BERADIK',
                'Ipar' => 'IPAR',
                'Saudara' => 'SAUDARA',
            ],
            $keahlian->hubunganwaris ?? null,
            ['id' => 'hubunganwaris', 'class' => 'form-control', 'required' => 'required'],
        ) !!}
        <small class="text-danger">{{ $errors->first('hubunganwaris') }}</small>
    </div>
    <div class="col-md-6 form-group{{ $errors->has('notelwaris_1') ? ' has-error' : '' }}">
        {!! Form::label('notelwaris_1', 'No Telefon 1', ['class' => 'required-label']) !!}
        {!! Form::text('notelwaris_1', $keahlian->notelwaris_1 ?? null, [
            'class' => 'form-control',
            'placeholder' => '01X-XXXXXXX',
            'required',
        ]) !!}
        <small class="text-danger">{{ $errors->first('notelwaris_1') }}</small>
    </div>
    <div class="col-md-6 form-group{{ $errors->has('notelwaris_2') ? ' has-error' : '' }}">
        {!! Form::label('notelwaris_2', 'No Telefon 2') !!}
        {!! Form::text('notelwaris_2', $keahlian->notelwaris_2 ?? null, [
            'class' => 'form-control',
            'placeholder' => '01X-XXXXXXX',
        ]) !!}
        <small class="text-danger">{{ $errors->first('notelwaris_2') }}</small>
    </div>
</div>
<div class="row">
    @if ($type == 'p')
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" type="button" id="btnPembayaran">Proses Pembayaran</button>
        </div>
    @else
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" type="button" id="btnPembayaran">Kemaskini Maklumat Keahlian</button>
        </div>
    @endif
</div>
