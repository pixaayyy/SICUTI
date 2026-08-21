@extends('layouts.mandor')

@section('title', 'Anggota Tim - SICUTI')

@section('content')

<style>

    /* =====================================================
       HEADER
       ===================================================== */

    .page-header {
        margin-bottom: 20px;
    }

    .page-header h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 5px;
    }

    .page-header p {
        font-size: 13px;
        color: #6b7280;
    }


    /* =====================================================
       SEARCH
       ===================================================== */

    .search-container {
        background: #ffffff;
        padding: 10px;
        border-radius: 10px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
    }

    .search-form {
        position: relative;
        width: 100%;
    }

    .search-input {
        width: 100%;
        height: 38px;

        padding: 0 14px 0 40px;

        border: 1px solid #ddd6fe;
        border-radius: 7px;

        font-size: 12px;
        color: #374151;

        outline: none;

        background: #ffffff;

        transition: 0.2s;
    }

    .search-input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.08);
    }

    .search-input::placeholder {
        color: #9ca3af;
    }

    .search-icon {
        position: absolute;
        left: 14px;
        top: 50%;

        transform: translateY(-50%);

        width: 15px;
        height: 15px;

        color: #9ca3af;
    }


    /* =====================================================
       GRID
       ===================================================== */

    .team-grid {
        display: grid;

        grid-template-columns: repeat(3, minmax(0, 1fr));

        gap: 14px;
    }


    /* =====================================================
       CARD
       ===================================================== */

    .team-card {
        background: #ffffff;

        border: 1px solid #f0f0f5;

        border-radius: 10px;

        padding: 14px;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.04);

        transition: 0.2s;

        min-width: 0;
    }

    .team-card:hover {
        transform: translateY(-2px);

        box-shadow:
            0 8px 20px rgba(0, 0, 0, 0.07);
    }


    /* =====================================================
       PROFILE
       ===================================================== */

    .team-profile {
        display: flex;
        align-items: center;

        gap: 10px;

        margin-bottom: 13px;
    }

    .team-avatar {
        width: 40px;
        height: 40px;

        border-radius: 50%;

        overflow: hidden;

        flex-shrink: 0;

        background: #e5e7eb;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #0d3b82;

        font-size: 14px;
        font-weight: 700;
    }

    .team-avatar img {
        width: 100%;
        height: 100%;

        object-fit: cover;
    }

    .team-info {
        min-width: 0;
    }

    .team-info h4 {
        font-size: 13px;
        font-weight: 600;

        color: #1f2937;

        margin-bottom: 3px;

        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .team-info p {
        font-size: 10px;
        color: #6b7280;
    }


    /* =====================================================
       DETAILS
       ===================================================== */

    .team-details {
        display: flex;
        flex-direction: column;

        gap: 8px;

        margin-bottom: 12px;
    }

    .detail-row {
        display: flex;

        justify-content: space-between;
        align-items: center;

        gap: 10px;
    }

    .detail-label {
        font-size: 9px;
        color: #9ca3af;
    }

    .detail-value {
        font-size: 9px;

        font-weight: 600;

        color: #374151;

        text-align: right;
    }


    /* =====================================================
       BUTTON
       ===================================================== */

    .btn-lihat {
        width: 100%;

        padding: 8px 10px;

        border: none;

        border-radius: 6px;

        background: #e0e7ff;

        color: #2563eb;

        font-size: 10px;

        font-weight: 600;

        cursor: pointer;

        transition: 0.2s;
    }

    .btn-lihat:hover {
        background: #c7d2fe;
    }


    /* =====================================================
       EMPTY
       ===================================================== */

    .empty-team {
        grid-column: 1 / -1;

        background: #ffffff;

        border-radius: 10px;

        padding: 50px 20px;

        text-align: center;

        color: #9ca3af;

        font-size: 13px;

        border: 1px solid #f3f4f6;
    }


    /* =====================================================
       MODAL
       ===================================================== */

    .member-modal {
        display: none;

        position: fixed;

        inset: 0;

        z-index: 3000;

        background: rgba(15, 23, 42, 0.45);

        align-items: center;
        justify-content: center;

        padding: 20px;
    }

    .member-modal.show {
        display: flex;
    }

    .member-modal-content {
        width: 420px;
        max-width: 100%;

        background: #ffffff;

        border-radius: 14px;

        padding: 24px;

        box-shadow:
            0 20px 50px rgba(0, 0, 0, 0.15);

        position: relative;
    }

    .modal-close {
        position: absolute;

        top: 12px;
        right: 16px;

        border: none;

        background: transparent;

        font-size: 24px;

        color: #9ca3af;

        cursor: pointer;
    }

    .modal-close:hover {
        color: #1f2937;
    }

    .modal-profile {
        display: flex;

        align-items: center;

        gap: 14px;

        margin-bottom: 20px;

        padding-bottom: 18px;

        border-bottom: 1px solid #f3f4f6;
    }

    .modal-avatar {
        width: 55px;
        height: 55px;

        border-radius: 50%;

        overflow: hidden;

        background: #e0e7ff;

        display: flex;
        align-items: center;
        justify-content: center;

        color: #2563eb;

        font-weight: 700;
        font-size: 18px;
    }

    .modal-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .modal-profile h3 {
        font-size: 16px;
        color: #1f2937;
        margin-bottom: 4px;
    }

    .modal-profile p {
        font-size: 12px;
        color: #6b7280;
    }

    .modal-detail {
        display: flex;

        justify-content: space-between;

        padding: 10px 0;

        border-bottom: 1px solid #f9fafb;
    }

    .modal-detail span:first-child {
        font-size: 12px;
        color: #6b7280;
    }

    .modal-detail span:last-child {
        font-size: 12px;
        color: #1f2937;
        font-weight: 600;
        text-align: right;
    }


    /* =====================================================
       RESPONSIVE
       ===================================================== */

    @media (max-width: 1000px) {

        .team-grid {
            grid-template-columns: repeat(2, 1fr);
        }

    }

    @media (max-width: 650px) {

        .team-grid {
            grid-template-columns: 1fr;
        }

        .main-content {
            padding: 20px;
        }

    }

</style>


<!-- =====================================================
     HEADER
     ===================================================== -->

<div class="page-header">

    <h2>
        Anggota Tim
    </h2>

    <p>
        Daftar anggota tim yang berada di bawah tanggung jawab Anda
    </p>

</div>


<!-- =====================================================
     SEARCH
     ===================================================== -->

<div class="search-container">

    <form
        action="{{ route('mandor.anggota') }}"
        method="GET"
        class="search-form"
    >

        <svg
            class="search-icon"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >

            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
            />

        </svg>

        <input
            type="text"
            name="search"
            class="search-input"
            value="{{ $search ?? '' }}"
            placeholder="Cari anggota tim..."
        >

    </form>

</div>


<!-- =====================================================
     TEAM GRID
     ===================================================== -->

<div class="team-grid">

    @forelse($anggotaTim as $anggota)

        @php

            $nama =
                $anggota->user->name
                ?? 'Tanpa Nama';

            $jabatan =
                $anggota->jabatan
                ?? '-';

            $sisaCuti =
                optional($anggota->sisaCuti->first())->sisa
                ?? 12;

            $tanggalBergabung =
                $anggota->created_at
                    ? \Carbon\Carbon::parse($anggota->created_at)
                        ->translatedFormat('d M Y')
                    : '-';

            $foto =
                $anggota->foto
                    ? asset('storage/' . $anggota->foto)
                    : null;

            $initial =
                strtoupper(
                    substr($nama, 0, 1)
                );

        @endphp


        <div class="team-card">

            <!-- PROFILE -->

            <div class="team-profile">

                <div class="team-avatar">

                    @if($foto)

                        <img
                            src="{{ $foto }}"
                            alt="{{ $nama }}"
                            onerror="this.style.display='none'; this.parentElement.innerHTML='{{ $initial }}';"
                        >

                    @else

                        {{ $initial }}

                    @endif

                </div>


                <div class="team-info">

                    <h4>
                        {{ $nama }}
                    </h4>

                    <p>
                        {{ $jabatan }}
                    </p>

                </div>

            </div>


            <!-- DETAIL -->

            <div class="team-details">

                <div class="detail-row">

                    <span class="detail-label">
                        Tanggal Bergabung
                    </span>

                    <span class="detail-value">
                        {{ $tanggalBergabung }}
                    </span>

                </div>


                <div class="detail-row">

                    <span class="detail-label">
                        Sisa Cuti Tahunan
                    </span>

                    <span class="detail-value">
                        {{ $sisaCuti }} Hari
                    </span>

                </div>

            </div>


            <!-- BUTTON -->

            <button
                type="button"
                class="btn-lihat"
                onclick="openMemberModal(
                    @js($nama),
                    @js($jabatan),
                    @js($tanggalBergabung),
                    @js($sisaCuti),
                    @js($foto)
                )"
            >
                Lihat Detail
            </button>

        </div>

    @empty

        <div class="empty-team">

            Tidak ada anggota tim yang ditemukan.

        </div>

    @endforelse

</div>


<!-- =====================================================
     MODAL DETAIL
     ===================================================== -->

<div
    id="memberModal"
    class="member-modal"
>

    <div class="member-modal-content">

        <button
            type="button"
            class="modal-close"
            onclick="closeMemberModal()"
        >
            &times;
        </button>


        <div class="modal-profile">

            <div
                id="modalAvatar"
                class="modal-avatar"
            >
            </div>


            <div>

                <h3 id="modalNama">
                    -
                </h3>

                <p id="modalJabatan">
                    -
                </p>

            </div>

        </div>


        <div class="modal-detail">

            <span>
                Tanggal Bergabung
            </span>

            <span id="modalTanggal">
                -
            </span>

        </div>


        <div class="modal-detail">

            <span>
                Sisa Cuti Tahunan
            </span>

            <span id="modalCuti">
                -
            </span>

        </div>

    </div>

</div>


<!-- =====================================================
     JAVASCRIPT
     ===================================================== -->

<script>

    function openMemberModal(
        nama,
        jabatan,
        tanggal,
        sisaCuti,
        foto
    ) {

        const modal =
            document.getElementById('memberModal');

        const avatar =
            document.getElementById('modalAvatar');

        document.getElementById('modalNama')
            .innerText = nama;

        document.getElementById('modalJabatan')
            .innerText = jabatan;

        document.getElementById('modalTanggal')
            .innerText = tanggal;

        document.getElementById('modalCuti')
            .innerText = sisaCuti + ' Hari';


        // ==========================================
        // AVATAR
        // ==========================================

        if (foto) {

            avatar.innerHTML =
                '<img src="' + foto + '" alt="">';

        } else {

            avatar.innerText =
                nama.charAt(0).toUpperCase();

        }


        modal.classList.add('show');

    }


    function closeMemberModal() {

        document
            .getElementById('memberModal')
            .classList.remove('show');

    }


    // Klik di luar modal

    document
        .getElementById('memberModal')
        .addEventListener('click', function(event) {

            if (event.target === this) {

                closeMemberModal();

            }

        });


    // ESC

    document.addEventListener('keydown', function(event) {

        if (event.key === 'Escape') {

            closeMemberModal();

        }

    });

</script>

@endsection