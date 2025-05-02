<div class="p-4">
    <form action="">
        <div class="d-flex align-content-center">
            <select name="" id="" class="form-control mr-2">
                <option selected>Choose</option>
                @foreach ($periode as $p)
                    <option value="{{ $p->id }}">{{ $p->tahun }}</option>
                @endforeach
            </select>
            <select name="" id="" class="form-control mr-2">
                <option selected>Choose</option>
                @foreach ($periode as $p)
                    <option value="{{ $p->id }}">{{ $p->start_date }} - {{ $p->end_date }}</option>
                @endforeach
            </select>
            <select name="" id="" class="form-control mr-2">
                <option selected>Choose</option>
                @if ($pegawai && $pegawai->pejabat)
                    <option value="">{{ $pegawai->pejabat->jabatan->nama_jabatan }}</option>
                @endif
                @foreach ($pegawai->timKerjaAnggota as $p)
                    <option value="{{ $p->id }}">{{ $p->pejabat->unit->nama }}</option>
                @endforeach
            </select>
            <select name="" id="" class="form-control mr-2">
                <option selected>Choose...</option>
                @if ($pegawai && $pegawai->pejabat)
                    <option value="">{{ $pegawai->pejabat->jabatan->nama_jabatan }}</option>
                @endif
                @foreach ($pegawai->timKerjaAnggota as $p)
                    <option value="{{ $p->id }}">{{ $p->pejabat->unit->nama }}</option>
                @endforeach
            </select>
            <button class="btn btn-primary" type="submit">Set</button>
        </div>
    </form>
</div>
