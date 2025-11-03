@component('mail::message')
# Pemberitahuan Sesi Opname

Halo Subadmin,

Sebuah sesi opname baru telah dijadwalkan untuk Departemen **{{ $opnameSession->departement->nama ?? 'Tidak Diketahui' }}**.

@component('mail::panel')
**Detail Sesi:**
* **Tanggal Dijadwalkan:** {{ $opnameSession->tanggal_dijadwalkan->format('d-m-Y H:i') ?? 'Tidak Diketahui' }}
* **Status:** {{ $opnameSession->status ?? 'Tidak Diketahui' }}
* **Deskripsi:** {{ $opnameSession->deskripsi ?? 'Tidak Ada Deskripsi' }}
@endcomponent

@component('mail::button', ['url' => route('subadmin.opname.index')])
Lihat Detail
@endcomponent

Terima kasih,<br>
{{ config('app.name') }}
@endcomponent