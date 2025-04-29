<div class="mt-4">
    <form id="form-umpan-balik">
        <table class="table mb-0" style="table-layout: fixed; width: 100%;">
            <thead>
              <tr>
                <th colspan="2">EVALUASI HASIL KERJA</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Rekomendasi</td>
                <td>Diatas Ekspektasi</td>
              </tr>
              <tr>
                <td>Rating Hasil Kerja</td>
                <td>
                    <select class="custom-select" id="rating-hasil-kerja" name="hasil_kerja">
                        <option selected>-- Pilih Rating --</option>
                        <option value="3">Diatas Ekspektasi</option>
                        <option value="2">Sesuai Ekspektasi</option>
                        <option value="1">Dibawah Ekspektasi</option>
                    </select>
                    <textarea style="height: 150px; width: 100%; padding: 10px; overflow-y: auto; resize: vertical;"></textarea>
                </td>
              </tr>
            </tbody>
        </table>
        <table class="table" style="table-layout: fixed; width: 100%;">
            <thead>
              <tr>
                <th colspan="2">EVALUASI PERILAKU</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Rekomendasi</td>
                <td>Diatas Ekspektasi</td>
              </tr>
              <tr>
                <td>Rating Perilaku</td>
                <td>
                    <select class="custom-select" id="rating-perilaku" name="perilaku">
                        <option selected>-- Pilih Rating --</option>
                        <option value="3">Diatas Ekspektasi</option>
                        <option value="2">Sesuai Ekspektasi</option>
                        <option value="1">Dibawah Ekspektasi</option>
                    </select>
                    <textarea style="height: 150px; width: 100%; padding: 10px; overflow-y: auto; resize: vertical;"></textarea>
                </td>
              </tr>
            </tbody>
        </table>
        <table class="table" style="table-layout: fixed; width: 100%;">
            <tbody>
              <tr>
                <td>Predikat Kinerja Pegawai</td>
                <td>-</td>
              </tr>
            </tbody>
        </table>
        <div class="w-100 mt-4 d-flex justify-content-end">
            <button id="proses-umpan-balik-button" class="btn btn-primary mr-1">Ubah Umpan Balik</button>
            <button type="submit" id="proses-umpan-balik-button" class="btn btn-primary ml-1">Simpan Hasil Evaluasi</button>
        </div>
    </form>
</div>
