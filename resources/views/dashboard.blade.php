@extends('layouts.auth')

@section('content')
    <div class="page-heading">
        <h3 class="float-start">Profile Statistics</h3>

    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                <div class="row">
                    @foreach ($cardData as $card)
                        <div class="col-6 col-lg-3 col-md-6">
                            <a href="{{ $card['route'] }}" style="text-decoration: none;">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div
                                                class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon purple mb-2">
                                                    <i class="iconly-boldShow"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">{{ $card['label'] }}</h6>
                                                <h6 class="font-extrabold mb-0">{{ $card['value'] }}</h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Dashboard Visit</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img src="{{ asset('storage/' . Auth::user()->profile_photo_path) }}">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">{{ Auth::user()->name }}</h5>
                                <h6 class="text-muted mb-0">{{ Auth::user()->role }}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Recent Ebooks</h4>
                    </div>
                    <div class="card-content pb-4">
                        @foreach ($ebooks as $ebook)
                            <div class="recent-message d-flex px-4 py-3">
                                <div class="avatar avatar-lg">
                                    <img src="{{ asset('storage/' . $ebook->cover_image) }}">
                                </div>
                                <div class="name ms-4">
                                    <a href="{{ asset('storage/' . $ebook->file_path) }}">
                                        <h5 class="mb-1">{{ $ebook->title }}</h5>
                                    </a>
                                    <h6 class="text-muted mb-0">{{ $ebook->author }}</h6>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </section>
    </div>
@endsection

@section('scripts')
    <!-- Need: Apexcharts -->
    <script src="{{ asset('assets/auth/extensions/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ asset('assets/auth/static/js/pages/dashboard.js') }}"></script>
@endsection
