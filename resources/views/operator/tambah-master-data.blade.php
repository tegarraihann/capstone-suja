@extends('layouts.app')

@section('title', 'Tambah IKU')

@section('content')

    @if (!empty(session('success')))
        <script>
            swal({
                title: "{{ Session::get('success.title') }}",
                text: "{{ Session::get('success.message') }}",
                icon: "success",
                button: {
                    text: "OK",
                    closeModal: true,
                }
            }).then(() => {
                window.location.href = "{{ url('operator/dashboard') }}";
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            var errorMessage = "";
            @foreach ($errors->all() as $error)
                errorMessage += "{{ $error }}\n";
            @endforeach

            swal("Data submit failed!", errorMessage, "error", {
                button: true,
                button: "OK",
            });
        </script>
    @endif

    <div class="w-full p-5 h-full">
        <a class="text-gray-600 font-semibold text-2xl flex items-center gap-3" href="{{ url('operator/dashboard') }}"><i
                class="fa-solid fa-angle-left text-lg"></i> Tambah Master Data</a>
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-5 bg-white mt-5">
            <p class="font-semibold text-lg text-gray-600 mb-3">
                {{ $entityName ?? 'Entitas tidak ditemukan' }}
            </p>
            <form class="mx-auto" action="{{ url('operator/tambah-master-data') }}" method="post">
                {{ csrf_field() }}
                <input type="hidden" name="type" value="{{ $entityType }}">
                <input type="hidden" name="entity_id" value="{{ $entityId }}">

                <div class="">
                    <div class="mt-4 mb-2 flex items-center gap-2">
                        <p class="text-gray-800">Pilih triwulan:</p>
                        <div class="flex items-center">
                            <select name="triwulan_id" class="px-4 py-2 pr-4 w-[200px] rounded-md shadow-sm outline-none border-none appearance-none text-gray-800 active:border-blue-500 active:border-2">
                                <option value="">pilih</option>
                                @foreach ($triwulan as $data)
                                    @if ($data->status === 'open')
                                        <option value="{{$data->id}}">{{$data->triwulan}}</option>
                                    @elseif ($data->status === 'close')
                                        <option @disabled(true) class="disabled:text-gray-300" value="{{$data->id}}">{{$data->triwulan}}</option>
                                    @endif
                                @endforeach
                            </select>
                            <svg class="w-4 h-4 mt-px -ml-6 pointer-events-none " xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                    <p class="w-full font-semibold border-b-2 py-2 mb-4 text-gray-600">Perjanjian Kinerja</p>
                    <div class="flex gap-x-10 gap-y-3 w-full items-center justify-between">
                        <div class="mb-5 w-1/2">
                            <label for="perjanjian_kinerja_target_kumulatif"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Target
                                komulatif</label>
                            <input type="number" min="0" max="100" name="perjanjian_kinerja_target_kumulatif"
                                id="perjanjian_kinerja_target_kumulatif"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="0" required />
                        </div>
                        <div class="mb-5 w-1/2">
                            <label for="perjanjian_kinerja_realisasi_kumulatif"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Realisasi
                                komulatif</label>
                            <input type="number" min="0" max="100"
                                name="perjanjian_kinerja_realisasi_kumulatif" id="perjanjian_kinerja_realisasi_kumulatif"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="0" required />
                        </div>
                    </div>
                </div>
                <div class="border-b-2">
                    <p class="w-full font-semibold border-b-2 py-2 mb-4 text-gray-600">Capaian Kinerja</p>
                    <div class="flex gap-x-10 gap-y-3 w-full items-center justify-between">
                        <div class="mb-5 w-1/2">
                            <label for="capaian_kinerja_kumulatif"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Komulatif</label>
                            <input type="number" min="0.00" step="0.01" name="capaian_kinerja_kumulatif"
                                id="capaian_kinerja_kumulatif"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="0.00" required />
                        </div>
                        <div class="mb-5 w-1/2">
                            <label for="capaian_kinerja_target_setahun"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Terhadap target
                                setahun</label>
                            <input type="number" min="0.00" step="0.01" name="capaian_kinerja_target_setahun"
                                id="capaian_kinerja_target_setahun"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="0.00" required />
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="mb-5 w-full">
                        <label for="link_bukti_dukung_capaian" class="block mb-2 text-sm font-medium text-gray-900 ">Link
                            bukti dukung capaian</label>
                        <input type="text" name="link_bukti_dukung_capaian" id="link_bukti_dukung_capaian"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan link bukti dukung" required />
                    </div>
                    <div class="mb-5 w-full">
                        <label for="upaya_yang_dilakukan" class="block mb-2 text-sm font-medium text-gray-900 ">Upaya yang
                            dilakukan</label>
                        <textarea type="text" name="upaya_yang_dilakukan" id="upaya_yang_dilakukan"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan upaya yang sudah dilakukan" rows="6" required></textarea>
                    </div>
                    <div class="mb-5 w-full">
                        <label for="link_bukti_dukung_upaya_yang_dilakukan"
                            class="block mb-2 text-sm font-medium text-gray-900 ">Link
                            bukti dukung upaya</label>
                        <input type="text" name="link_bukti_dukung_upaya_yang_dilakukan"
                            id="link_bukti_dukung_upaya_yang_dilakukan"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan link bukti upaya" required />
                    </div>
                </div>
                <div class="">
                    <p class="w-full font-semibold border-b-2 py-2 mb-4 text-gray-600">Analisis Pencapaian Kinerja di
                        Triwulan Berjalan</p>
                    <div class="grid grid-cols-2 gap-x-10 gap-y-3 w-full items-center justify-between">
                        <div class="mb-5 w-full">
                            <label for="kendala" class="block mb-2 text-sm font-medium text-gray-900 ">Kendala</label>
                            <textarea type="text" name="kendala" id="kendala"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="Masukkan kendala saat triwulan ini" rows="6" required></textarea>
                        </div>
                        <div class="mb-5 w-full">
                            <label for="solusi_atas_kendala"
                                class="block mb-2 text-sm font-medium text-gray-900 ">Solusi</label>
                            <textarea type="text" name="solusi_atas_kendala" id="solusi_atas_kendala"
                                class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                                placeholder="Masukkan solusi atas kendala" rows="6" required></textarea>
                        </div>
                    </div>
                    <div class="mb-5 w-full">
                        <label for="rencana_tidak_lanjut" class="block mb-2 text-sm font-medium text-gray-900 ">Rencana
                            tindak
                            lanjut</label>
                        <textarea type="text" name="rencana_tidak_lanjut" id="rencana_tidak_lanjut"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan rencana tindak lanjut untuk triwulan berikutnya" rows="6" required></textarea>
                    </div>
                    <div class="mb-5 w-full">
                        <label for="pic_tidak_lanjut" class="block mb-2 text-sm font-medium text-gray-900 ">PIC tindak
                            lanjut</label>
                        <input type="text" name="pic_tidak_lanjut" id="pic_tidak_lanjut"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            placeholder="Masukkan PIC tindak lanjut untuk triwulan berikutnya" required></input>
                    </div>
                    <div class="mb-5 w-1/4">
                        <label for="tenggat_tidak_lanjut" class="block mb-2 text-sm font-medium text-gray-900 ">Batas
                            waktu tindak
                            lanjut</label>
                        <input type="date" name="tenggat_tidak_lanjut" id="tenggat_tidak_lanjut"
                            class="shadow-sm bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 "
                            required></input>
                    </div>
                </div>

                <button type="submit"
                    class="text-white bg-blue-500 hover:bg-blue-600 transition-all focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan</button>
            </form>
        </div>

    </div>
@endsection
