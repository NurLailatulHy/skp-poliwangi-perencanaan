<div class="p-4">
    <form method="POST" action="{{ url('/penilaian/periode/set') }}">
        @csrf
        <div class="d-flex align-content-center">
            <select name="periodetahun" id="" class="form-control mr-2">
                @if (count($periode) === 1)
                    @foreach ($periode as $p)
                        <option selected value="{{ $p->id }}">{{ $p->tahun }}</option>
                    @endforeach
                @elseif(count($periode) > 1)
                    <option value="">-- Pilih Tahun --</option>
                    @foreach ($periode as $p)
                        <option value="{{ $p->id }}">{{ $p->tahun }}</option>
                    @endforeach
                @elseif(count($periode) == 0)
                    <option selected value="">-- Pilih Tahun --</option>
                @endif
            </select>
            <select name="periode-range" id="" class="form-control mr-2">
                @if (count($periode) === 1)
                    @foreach ($periode as $p)
                        <option selected value="{{ $p->id }}">{{ $p->start_date }} - {{ $p->end_date }}</option>
                    @endforeach
                @elseif(count($periode) > 1)
                    <option value="">-- Pilih Rentang Periode --</option>
                    @foreach ($periode as $p)
                        <option value="{{ $p->id }}">{{ $p->start_date }} - {{ $p->end_date }}</option>
                    @endforeach
                @elseif(count($periode) == 0)
                    <option selected value="">-- Pilih Rentang Periode --</option>
                @endif
            </select>
            <select name="unit_id" id="nama-unit" class="form-control mr-2" {{ count($pegawai->timKerjaAnggota) === 1 ? 'disabled' : ''  }}>
                @if (count($pegawai->timKerjaAnggota) === 1)
                    @foreach ($pegawai->timKerjaAnggota as $p)
                        <option selected value="{{ $p->id }}">{{ $p->unit->nama }}</option>
                    @endforeach
                @elseif(count($pegawai->timKerjaAnggota) > 1)
                    <option value="">-- Pilih Unit --</option>
                    @foreach ($pegawai->timKerjaAnggota as $p)
                        <option value="{{ $p->id }}">{{ $p->unit->nama }}</option>
                    @endforeach
                @endif
            </select>
            <select name="peran" id="peran" class="form-control mr-2" {{ count($pegawai->timKerjaAnggota) === 1 ? 'disabled' : '' }}>
                @if (count($pegawai->timKerjaAnggota) === 1)
                    @foreach ($pegawai->timKerjaAnggota as $p)
                        <option selected value="{{ $p->id }}">{{ $p->pivot->peran }} {{ $p->unit->nama }}</option>
                    @endforeach
                @elseif(count($pegawai->timKerjaAnggota) > 1)
                    <option value="">-- Pilih Peran --</option>
                    @foreach ($pegawai->timKerjaAnggota as $p)
                        <option value="{{ $p->id }}">{{ $p->pivot->peran }} {{ $p->unit->nama }}</option>
                    @endforeach
                @endif
            </select>
            <button type="submit" class="btn btn-primary">Set</button>
        </div>
    </form>
</div>
