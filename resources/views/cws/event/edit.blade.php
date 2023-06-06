<?php

/**
 * @var App\Models\Task\ $event
 * @var array $categories
 */

?>

@extends('cws.layouts.app')
@section('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection
@section('content')
    <div class="container-fluid">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">Forms Steps</h4>
                    </div><!-- end card header -->
                    <div class="card-body">
                        <form action="#">
                            <ul class="wizard-nav mb-5">
                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Seller Details">
                                            <i class="bx bx-user-circle"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Sessions">
                                            <i class="bx bx-file"></i>
                                        </div>
                                    </div>
                                </li>

                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Booths">
                                            <i class="bx bx-edit"></i>
                                        </div>
                                    </div>
                                </li>
                                {{--Social--}}
                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Social">
                                            <i class="bx bx-edit"></i>
                                        </div>
                                    </div>
                                </li>
                                <li class="wizard-list-item">
                                    <div class="list-item">
                                        <div class="step-icon" data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="Quiz">
                                            <i class="bx bx-edit"></i>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- wizard-nav -->

                            <div class="wizard-tab">
                                <div class="text-center mb-4">
                                    <h5>Event Details</h5>
                                    <p class="card-title-desc">Detail Event</p>
                                </div>
                                <div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input" class="form-label">Name</label>
                                                <input type="text" value="{{ $event->name }}"
                                                       class="form-control" placeholder="Enter Event Name" id="event_name" name="event_name">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input" class="form-label">Address</label>
                                                <input type="text" value="{{ $event->address }}"
                                                       class="form-control" placeholder="Enter Event Address" id="event_address" name="event_address">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="basicpill-firstname-input" class="form-label">Lat</label>
                                                <input type="text" class="form-control" value="{{ $event->lat }}"
                                                       placeholder="Enter Event Name" id="event_name" name="event_name">
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="basicpill-lastname-input" class="form-label">Long</label>
                                                <input type="text" class="form-control" value="{{ $event->long }}"
                                                       placeholder="Enter Last Name" id="basicpill-lastname-input">
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="event_description" class="form-label">Description</label>
                                                <div id="editorjs"></div>
                                                <script type="text/javascript">
                                                    const editor = new EditorJS({
                                                      holder: 'editorjs',
                                                      tools: { 
                                                        header: Header, 
                                                        list: List,
                                                      }, 
                                                    });
                                                </script>
                                                {{-- <input type="text" name="description" id="editorjs"> --}}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="basicpill-address-input"
                                                       class="form-label">Order</label>
                                                <input type="text" class="form-control" placeholder="" id="order" name="order">
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="basicpill-address-input"
                                                       class="form-label">&nbsp;</label>
                                                <div class="form-check mt-1">
                                                    <input class="form-check-input" type="checkbox" value="" name="paid" id="flexCheckPaid" checked>
                                                    <label class="form-check-label" for="flexCheckPaid">
                                                        Paid
                                                    </label>
                                                </div>
                                            </div>

                                        </div><!-- end col -->
                                    </div><!-- end row -->
                                    <div class="row" id="row_paid">
                                        <div class="col-lg-6">
                                        </div><!-- end col -->
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" placeholder="" id="order" name="order">
                                                </div>
                                            </div>

                                        </div><!-- end col -->
                                        <div class="col-lg-3">
                                            <div class="mb-3">
                                                <div class="mb-3">
                                                    <select class="form-select" aria-label="Default select example">
                                                        <option value="1">Web</option>
                                                        <option value="2">User</option>
                                                    </select>
                                                </div>
                                            </div>

                                        </div><!-- end col -->
                                    </div><!-- end row -->


                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="basicpill-phoneno-input"
                                                       class="form-label">Start At</label>
                                                <input type="text" class="form-control" value="{{ $event->starter_at }}"
                                                       placeholder="" id="start_at" name="start_at">
                                            </div>
                                        </div><!-- end col -->
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="basicpill-email-input"
                                                       class="form-label">End At</label>
                                                <input type="email" class="form-control" value="{{ $event->starter_at }}"
                                                       placeholder="" id="end_at" name="end_at">
                                            </div>
                                        </div><!-- end col -->
                                    </div><!-- end row -->

                                </div>

                            </div>
                            <!-- wizard-tab -->

                            <div class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Sessions</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-pancard-input" class="form-label">PAN
                                                        Card</label>
                                                    <input type="text" class="form-control" placeholder="Enter Pan Card" id="basicpill-pancard-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input"
                                                           class="form-label">VAT/TIN No.</label>
                                                    <input type="text" class="form-control" placeholder="Enter VAT/TIN No." id="basicpill-vatno-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-cstno-input" class="form-label">CST
                                                        No.</label>
                                                    <input type="text" class="form-control" placeholder="Enter CST No." id="basicpill-cstno-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-servicetax-input"
                                                           class="form-label">Service Tax No.</label>
                                                    <input type="text" class="form-control" placeholder="Enter Service Tax No." id="basicpill-servicetax-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-companyuin-input"
                                                           class="form-label">Company UIN</label>
                                                    <input type="text" class="form-control" placeholder="Enter Company UIN" id="basicpill-companyuin-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-declaration-input"
                                                           class="form-label">Declaration</label>
                                                    <input type="text" class="form-control" placeholder="Enter Declaration" id="basicpill-declaration-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row-->
                                    </div><!-- end form -->
                                </div>
                            </div>
                            <!-- wizard-tab -->

                            <div class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Booths</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-namecard-input"
                                                           class="form-label">Name On Card</label>
                                                    <input type="text" class="form-control" placeholder="Enter Name On Card" id="basicpill-namecard-input">
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Credit Card Type</label>
                                                    <select class="form-select">
                                                        <option selected>Select Card Type</option>
                                                        <option value="AE">American Express</option>
                                                        <option value="VI">Visa</option>
                                                        <option value="MC">MasterCard</option>
                                                        <option value="DI">Discover</option>
                                                    </select>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-cardno-input"
                                                           class="form-label">Credit Card Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter Credit Card Number" id="basicpill-cardno-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-card-verification-input"
                                                           class="form-label">Card Verification Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter Card Verification Number" id="basicpill-card-verification-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-expiration-input"
                                                           class="form-label">Expiration Date</label>
                                                    <input type="text" class="form-control" id="datepicker-basic" placeholder="Enter Expiration Date" id="basicpill-expiration-input">
                                                </div>
                                            </div>
                                        </div><!-- end row -->
                                    </div><!-- end form -->

                                </div>
                            </div>
                            <div class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Social</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-namecard-input"
                                                           class="form-label">Name On Card</label>
                                                    <input type="text" class="form-control" placeholder="Enter Name On Card" id="basicpill-namecard-input">
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Credit Card Type</label>
                                                    <select class="form-select">
                                                        <option selected>Select Card Type</option>
                                                        <option value="AE">American Express</option>
                                                        <option value="VI">Visa</option>
                                                        <option value="MC">MasterCard</option>
                                                        <option value="DI">Discover</option>
                                                    </select>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-cardno-input"
                                                           class="form-label">Credit Card Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter Credit Card Number" id="basicpill-cardno-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-card-verification-input"
                                                           class="form-label">Card Verification Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter Card Verification Number" id="basicpill-card-verification-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-expiration-input"
                                                           class="form-label">Expiration Date</label>
                                                    <input type="text" class="form-control" id="datepicker-basic" placeholder="Enter Expiration Date" id="basicpill-expiration-input">
                                                </div>
                                            </div>
                                        </div><!-- end row -->
                                    </div><!-- end form -->

                                </div>
                            </div>
                            <div class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Quiz</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-namecard-input"
                                                           class="form-label">Name On Card</label>
                                                    <input type="text" class="form-control" placeholder="Enter Name On Card" id="basicpill-namecard-input">
                                                </div>
                                            </div><!-- end col -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label class="form-label">Credit Card Type</label>
                                                    <select class="form-select">
                                                        <option selected>Select Card Type</option>
                                                        <option value="AE">American Express</option>
                                                        <option value="VI">Visa</option>
                                                        <option value="MC">MasterCard</option>
                                                        <option value="DI">Discover</option>
                                                    </select>
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-cardno-input"
                                                           class="form-label">Credit Card Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter Credit Card Number" id="basicpill-cardno-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-card-verification-input"
                                                           class="form-label">Card Verification Number</label>
                                                    <input type="text" class="form-control" placeholder="Enter Card Verification Number" id="basicpill-card-verification-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="basicpill-expiration-input"
                                                           class="form-label">Expiration Date</label>
                                                    <input type="text" class="form-control" id="datepicker-basic" placeholder="Enter Expiration Date" id="basicpill-expiration-input">
                                                </div>
                                            </div>
                                        </div><!-- end row -->
                                    </div><!-- end form -->

                                </div>
                            </div>
                            <!-- wizard-tab -->

                            <div class="d-flex align-items-start gap-3 mt-4">
                                <button type="button" class="btn btn-primary w-sm" id="prevBtn" onclick="nextPrev(-1)">Previous</button>
                                <button type="button" class="btn btn-primary w-sm ms-auto" id="nextBtn" onclick="nextPrev(1)">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!-- end col -->
        </div><!-- end row -->




    </div>

@endsection


@section('scripts')

    <script>

    </script>
    <script>


        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("wizard-tab");

            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                document.getElementById("nextBtn").innerHTML = "Submit";
            } else {
                document.getElementById("nextBtn").innerHTML = "Next";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("wizard-tab");
            //console.log(x)

            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                currentTab = currentTab - n;
                x[currentTab].style.display = "block";
            }
            // Otherwise, display the correct tab:
            showTab(currentTab)
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("list-item");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
    </script>
@endsection
