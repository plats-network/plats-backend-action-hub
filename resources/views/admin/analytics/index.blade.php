@extends('admin.layout')
@section('content')
    <x-admin::top_page :title="trans('admin.analysis.page_name')" :desc="trans('admin.analysis.page_desc')">
    </x-admin::top_page>

    <x-alert />
    <!-- Top Analytics Start -->
    <div class="row">
        <div class="col-12 col-lg-6">
            <!-- Stats Start -->
            <div class="d-flex">
                <div class="dropdown-as-select me-3" data-setactive="false" data-childselector="span">
                    <a class="pe-0 pt-0 align-top lh-1 dropdown-toggle" href="#" data-bs-toggle="dropdown"
                        aria-expanded="false" aria-haspopup="true">
                        <span class="small-title">Today's</span>
                    </a>
                    <div class="dropdown-menu font-standard">
                        <div class="nav flex-column" role="tablist">
                            <a class="active dropdown-item text-medium" href="#" aria-selected="true"
                                role="tab">Today's</a>
                            <a class="dropdown-item text-medium" href="#" aria-selected="false"
                                role="tab">Weekly</a>
                            <a class="dropdown-item text-medium" href="#" aria-selected="false"
                                role="tab">Monthly</a>
                            <a class="dropdown-item text-medium" href="#" aria-selected="false"
                                role="tab">Yearly</a>
                        </div>
                    </div>
                </div>
                <h2 class="small-title">Stats</h2>
            </div>

            <div class="mb-4 row g-2">
                <!-- Top Label Start -->
                <section class="scroll-section" id="topLabel">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 col-sm-12 col-xl-12">

                                    <div class="d-flex project-info">
                                        <div class="img-container">
                                            <img src="https://dhms0p1aun79c.cloudfront.net/tasks/cover/20220616/5dcERuzHYOGG4YK9TIFMzxFZFTLItwjSvjn2bmvi.jpg"
                                                alt="" />
                                        </div>

                                        <div
                                            class="info flex-grow-1 d-flex flex-column justify-content-center align-items-center">
                                            <h5 class="mb-1">Starbucks Check-in Task</h5>
                                            <p class="mb-0">
                                                {{-- in progress --}}
                                                <span class="text-success">
                                                    <i class="fas fa-circle"></i>
                                                    In Progress
                                                </span>
                                            </p>
                                        </div>

                                    </div>

                                    {{-- Start Progress Bar --}}
                                    <div class="progress sh-1 mt-3">
                                        <div class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0"
                                            aria-valuemax="100" style="width: 70%;"></div>


                                    </div>
                                    <div class="position-relative text-medium mt-2">
                                        <span class="absolute">July 15</span>
                                        <span class="position-absolute" style="left: 18rem">July 26</span>
                                        <span class="position-absolute" style="right: 0">July 30</span>

                                    </div>
                                    {{-- End Progress Bar --}}

                                </div>
                            </div>


                        </div>
                    </div>
                </section>
                <!-- Top Label End -->


            </div>
            <!-- Stats End -->

            <!-- Sales & Stocks Charts Start -->
            <div class="card mb-5 sh-45">
                <div class="card-body">
                    <div class="custom-legend-container mb-3 pb-3 d-flex flex-row">
                        <a href="#" class="d-flex flex-row g-0 align-items-center me-5">
                            <div class="pe-2">
                                <div class="icon-container border sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center"
                                    style="border-color: rgb(30, 168, 231) !important;">

                                    <i class="fa-solid fa-users"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text p mb-0 d-flex align-items-center text-small text-muted">Participant Total
                                </div>
                                <div class="value cta-4" style="color: rgb(30, 168, 231) !important;">2214</div>
                            </div>
                        </a>

                        <a href="#" class="d-flex flex-row g-0 align-items-center me-5">
                            <div class="pe-2">
                                <div class="icon-container border sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center"
                                    style="border-color: rgb(108, 219, 239) !important;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                        viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="acorn-icons acorn-icons-cupcake icon"
                                        style="color: rgb(108, 219, 239) !important;">
                                        <path
                                            d="M16.5 11.5L14.5586 12.2894C13.6118 12.6743 12.527 12.4622 11.7949 11.7489V11.7489C10.7962 10.7757 9.20383 10.7757 8.20507 11.7489V11.7489C7.47305 12.4622 6.38817 12.6743 5.44139 12.2894L3.5 11.5">
                                        </path>
                                        <path
                                            d="M14 5L15.1555 5.30852C16.0463 5.54637 16.7839 6.17049 17.1659 7.00965V7.00965C17.6884 8.15765 17.6161 9.48873 16.9721 10.5733L16.3962 11.5433C16.2168 11.8454 16.0919 12.1767 16.0271 12.522L15.4588 15.5529C15.1928 16.9718 13.9539 18 12.5102 18H7.48978C6.04613 18 4.80721 16.9718 4.54116 15.5529L3.97288 12.522C3.90813 12.1767 3.78322 11.8454 3.60383 11.5433L3.0279 10.5733C2.38394 9.48873 2.31157 8.15765 2.83414 7.00965V7.00965C3.21614 6.17049 3.95371 5.54637 4.84452 5.30852L6 5">
                                        </path>
                                        <path d="M6 6.5C6 4.29086 7.5454 2 10 2C12.4546 2 14 4.29086 14 6.5"></path>
                                    </svg>
                                </div>
                            </div>
                            <div>
                                <div class="text p mb-0 d-flex align-items-center text-small text-muted">CAKES</div>
                                <div class="value cta-4" style="color: rgb(108, 219, 239) !important;">240</div>
                            </div>
                        </a>
                    </div>
                    <template class="custom-legend-item">
                        <a href="#" class="d-flex flex-row g-0 align-items-center me-5">
                            <div class="pe-2">
                                <div
                                    class="icon-container border sw-5 sh-5 rounded-xl d-flex justify-content-center align-items-center">
                                    <i class="icon"></i>
                                </div>
                            </div>
                            <div>
                                <div class="text p mb-0 d-flex align-items-center text-small text-muted">Title</div>
                                <div class="value cta-4">Value</div>
                            </div>
                        </a>
                    </template>
                    <div class="sh-30">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="customLegendBarChart" style="display: block; height: 240px; width: 554px;"
                            width="461" height="200" class="chartjs-render-monitor"></canvas>
                        <div class="custom-tooltip position-absolute bg-foreground rounded-md border border-separator pe-none p-3 d-flex z-index-1 align-items-center opacity-0 basic-transform-transition center"
                            style="opacity: 0; left: 472.644px; top: 252.011px;">
                            <div class="icon-container border d-flex align-middle align-items-center justify-content-center align-self-center rounded-xl sh-5 sw-5 rounded-xl me-3"
                                style="border-color: rgb(0, 160, 235) !important;">
                            </div>
                            <div>
                                <span
                                    class="text d-flex align-middle text-muted align-items-center text-small">TODAY</span>
                                <span class="value d-flex align-middle align-items-center cta-4"
                                    style="color: rgb(0, 160, 235);">242</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sales & Stocks Charts End -->
        </div>

        <!-- Logs Start -->
        <div class="col-xl-6">



            <h2 class="small-title">Ratings</h2>
            <div class="card sh-20 mb-4">
                <div class="card-body sh-20">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <div>Location</div>
                            <div>Restaurant Design</div>
                            <div>Services</div>
                            <div>Drinks</div>
                            <div>Hygiene</div>
                        </div>


                        <div class="flex-1 flex-grow-2" style="margin-right: 1rem; font-weight: bold">
                            <div class="text-center">4</div>
                            <div class="text-center">3.7</div>
                            <div class="text-center">4</div>
                            <div class="text-center">5</div>
                            <div class="text-center">4</div>
                        </div>

                        <div class="flex-6 flex-grow-2 ">
                            <div class="">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-light fa-star"></i>
                            </div>
                            <div class="">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star-half"></i>
                                <i class="fa-light fa-star"></i>
                            </div>
                            <div class="">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-light fa-star-half"></i>
                            </div>
                            <div class="">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid  fa-star"></i>
                                <i class="fa-solid  fa-star"></i>
                                <i class="fa-light fa-star"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            <h2 class="small-title">Comment</h2>
            <div class="card">
                <div class="card-body" style="overflow-y: scroll; max-height: 383px;">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="media">
                                    <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview"
                                        src="https://i.imgur.com/stD0Q19.jpg" />
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-8 d-flex">
                                                <h5>Maria Smantha</h5>
                                                <span>- 2 hours ago</span>
                                            </div>

                                            <div class="col-4">

                                                <div class="pull-right reply">

                                                    <a href="#"><span><i class="fa fa-reply"></i> reply</span></a>

                                                </div>

                                            </div>
                                        </div>

                                        It is a long established fact that a reader will be distracted by the readable
                                        content of a page.

                                        <div class="media mt-4">
                                            <a class="pr-3" href="#"><img class="rounded-circle"
                                                    alt="Bootstrap Media Another Preview"
                                                    src="https://i.imgur.com/xELPaag.jpg" /></a>
                                            <div class="media-body">

                                                <div class="row">
                                                    <div class="col-12 d-flex">
                                                        <h5>Simona Disa</h5>
                                                        <span>- 3 hours ago</span>
                                                    </div>


                                                </div>

                                                letters, as opposed to using 'Content here, content here', making it look
                                                like readable English.
                                            </div>
                                        </div>

                                        <div class="media mt-3">
                                            <a class="pr-3" href="#"><img class="rounded-circle"
                                                    alt="Bootstrap Media Another Preview"
                                                    src="https://i.imgur.com/nAcoHRf.jpg" /></a>
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="col-12 d-flex">
                                                        <h5>John Smith</h5>
                                                        <span>- 4 hours ago</span>
                                                    </div>


                                                </div>

                                                the majority have suffered alteration in some form, by injected humour, or
                                                randomised words.

                                            </div>
                                        </div>
                                    </div>
                                </div>




                                <div class="media mt-4">
                                    <img class="mr-3 rounded-circle" alt="Bootstrap Media Preview"
                                        src="https://i.imgur.com/xELPaag.jpg" />
                                    <div class="media-body">
                                        <div class="row">
                                            <div class="col-8 d-flex">
                                                <h5>Shad f</h5>
                                                <span>- 2 hours ago</span>
                                            </div>

                                            <div class="col-4">

                                                <div class="pull-right reply">

                                                    <a href="#"><span><i class="fa fa-reply"></i> reply</span></a>

                                                </div>

                                            </div>
                                        </div>

                                        The standard chunk of Lorem Ipsum used since the 1500s is reproduced below for those
                                        interested. Sections 1.10.32 and 1.10.33.
                                        <div class="media mt-4">
                                            <a class="pr-3" href="#"><img class="rounded-circle"
                                                    alt="Bootstrap Media Another Preview"
                                                    src="https://i.imgur.com/nUNhspp.jpg" /></a>
                                            <div class="media-body">

                                                <div class="row">
                                                    <div class="col-12 d-flex">
                                                        <h5>Andy flowe</h5>
                                                        <span>- 5 hours ago</span>
                                                    </div>


                                                </div>

                                                Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque
                                                ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at,
                                                tempus viverra turpis.
                                            </div>
                                        </div>

                                        <div class="media mt-3">
                                            <a class="pr-3" href="#"><img class="rounded-circle"
                                                    alt="Bootstrap Media Another Preview"
                                                    src="https://i.imgur.com/HjKTNkG.jpg" /></a>
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="col-12 d-flex">
                                                        <h5>Simp f</h5>
                                                        <span>- 5 hours ago</span>
                                                    </div>


                                                </div>

                                                a Latin professor at Hampden-Sydney College in Virginia, looked up one of
                                                the more obscure Latin words, consectetur
                                            </div>
                                        </div>


                                        <div class="media mt-3">
                                            <a class="pr-3" href="#"><img class="rounded-circle"
                                                    alt="Bootstrap Media Another Preview"
                                                    src="https://i.imgur.com/nAcoHRf.jpg" /></a>
                                            <div class="media-body">
                                                <div class="row">
                                                    <div class="col-12 d-flex">
                                                        <h5>John Smith</h5>
                                                        <span>- 4 hours ago</span>
                                                    </div>


                                                </div>

                                                the majority have suffered alteration in some form, by injected humour, or
                                                randomised words.

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Logs End -->

        <div class="col-12" style="margin-top: -24px;">
            <h2 class="small-title">Gallery</h2>
            <div class="card sh-26 mb-4">
                <div class="card-body sh-26">
                    <div class="g-2 gallery custom-scrollbar" style="overflow-x: scroll; overflow-y: hidden; padding-bottom: 1.7rem; gap: 0.5rem;white-space:nowrap;">
                        <a href="https://i.imgur.com/5WLWDg3.png"
                            class="rounded-md bg-cover-center d-inline-block position-relative"
                            style="width: 180px; height: 180px; background-image: url('https://i.imgur.com/5WLWDg3.png')">
                        <div class="position-absolute" style="font-size: 1.2rem; font-weight: bold; bottom: -2rem; right: 0; left: 0; text-align: center; ">Amy Truong</div></a>
                        <a href="https://i.imgur.com/9MxfL9X.png"
                            class="rounded-md bg-cover-center d-inline-block position-relative"
                            style="width: 180px; height: 180px; background-image: url('https://i.imgur.com/9MxfL9X.png')">
                        <div class="position-absolute" style="font-size: 1.2rem; font-weight: bold; bottom: -2rem; right: 0; left: 0; text-align: center; ">James</div></a>
                        <a href="https://i.imgur.com/9MxfL9X.png"
                            class="rounded-md bg-cover-center d-inline-block position-relative"
                            style="width: 180px; height: 180px; background-image: url('https://i.imgur.com/l3HYr79.png')">
                        <div class="position-absolute" style="font-size: 1.2rem; font-weight: bold; bottom: -2rem; right: 0; left: 0; text-align: center; ">Mi Nguyen</div></a>

                        <a href="https://i.imgur.com/nZmIarQ.png"
                            class="rounded-md bg-cover-center d-inline-block position-relative"
                            style="width: 180px; height: 180px; background-image: url('https://i.imgur.com/nZmIarQ.png')">
                        <div class="position-absolute" style="font-size: 1.2rem; font-weight: bold; bottom: -2rem; right: 0; left: 0; text-align: center; ">Xiao Yi</div></a>

                        <a href="https://i.imgur.com/nMV0GvG.png"
                            class="rounded-md bg-cover-center d-inline-block position-relative"
                            style="width: 180px; height: 180px; background-image: url('https://i.imgur.com/nMV0GvG.png')">
                        <div class="position-absolute" style="font-size: 1.2rem; font-weight: bold; bottom: -2rem; right: 0; left: 0; text-align: center; ">Wayne Gacy</div></a>

                        <a href="https://i.imgur.com/yrkzu3i.png"
                            class="rounded-md bg-cover-center d-inline-block position-relative"
                            style="width: 180px; height: 180px; background-image: url('https://i.imgur.com/yrkzu3i.png')">
                        <div class="position-absolute" style="font-size: 1.2rem; font-weight: bold; bottom: -2rem; right: 0; left: 0; text-align: center; ">Ji Sung</div></a>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    <ul class="pagination">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-chevron-left undefined"><path d="M13 16L7.35355 10.3536C7.15829 10.1583 7.15829 9.84171 7.35355 9.64645L13 4"></path></svg>
                            </a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                        <li class="page-item active" aria-current="page">
                            <a class="page-link" href="#">2</a>
                        </li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="acorn-icons acorn-icons-chevron-right undefined"><path d="M7 4L12.6464 9.64645C12.8417 9.84171 12.8417 10.1583 12.6464 10.3536L7 16"></path></svg>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Products End -->
    </div>

    <!-- Top Analytics End -->
@endsection

@push('css')
    <link rel="stylesheet" href="{{ mix('/static/css/admin/pages/analysis.css') }}">
    <link href="https://cdn.jsdelivr.net/gh/hung1001/font-awesome-pro-v6@18657a9/css/all.min.css" rel="stylesheet"
        type="text/css" />
@endpush
