@extends('layouts.application')

@section('styles')
    <!-- Page -->
    <link rel="stylesheet" href="{{ mix('/totaa/css/coming-soon.css') }}">
    <link rel="stylesheet" href="{{ mix('/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}">
@endsection

@section('scripts')
    <!-- Dependencies -->
    <script src="{{ mix('/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="{{ mix('/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.vi.min.js') }}"></script>
@endsection

@section('layout-content')
    <div class="d-flex align-items-stretch w-100 ui-mh-100vh ui-bg-cover ui-bg-overlay-container" style="background-image: url({{ asset('/img/bg/16.jpg') }});">
        <div class="row no-gutters w-100">
            <div class="ui-bg-overlay bg-dark"></div>

            <div class="d-flex col flex-column text-white px-4 px-sm-5">
                <div class="d-flex align-items-center mt-5">
                    <div class="ui-w-60">
                        <div class="w-100 position-relative" style="padding-bottom: 24%">
                            @include('layouts.includes.logo')
                        </div>
                    </div>
                    <div class="text-large ml-3 font-weight-semibold">
                        CPC1 Hà Nội
                    </div>
                </div>

                <div class="py-5 my-auto">
                    <div class="display-4 text-expanded mb-2">Bạn không có quyền truy cập</div>
                    <h1 class="display-2 font-weight-bolder text-expanded">Chưa được cấp quyền</h1>

                    <livewire:user.yeu-cau-cap-quyen />

                </div>
            </div>

            <div class="theme-bg-white d-flex col-lg-5 col-xl-4 align-items-center py-5 px-4 px-sm-5">
                <div class="flex-shrink-1">
                    <h5 class="font-weight-bold mb-4">WHO <span class="text-primary">WE ARE</span></h5>
                    <p>Công ty Cổ phần CPC1 Hà Nội là một trong những công ty hàng đầu trong việc áp dụng công nghệ cao vào trong quá trình sản xuất Dược phẩm. Đem tới những sản phẩm thuốc chất lượng cao, đáp ứng nhu cầu.</p>
                    <h5 class="font-weight-bold mt-5 mb-4">TOUCH <span class="text-primary">WITH US</span></h5>
                    <p><i class="ion ion-ios-call ui-w-40 text-center text-vimeo text-big align-middle"></i><span class="align-middle text-vimeo">1800 6357</span></p>
                    <div>
                        <a target="_blank" href="https://www.facebook.com/cpc1hn/" class="btn icon-btn borderless btn-outline-facebook rounded-pill">
                        <span class="ion ion-logo-facebook"></span>
                        </a>
                        <a target="_blank" href="https://www.youtube.com/channel/UC94ztWJMDnzM2FHt69UNTgQ/" class="btn icon-btn borderless btn-outline-youtube rounded-pill">
                        <span class="ion ion-logo-youtube"></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
