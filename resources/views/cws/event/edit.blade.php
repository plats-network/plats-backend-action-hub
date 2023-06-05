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
                                        <div class="col-md-12">
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
                                                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
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
                                            <div class="col-lg-9">
                                                <div class="mb-3">
                                                    <label for="basicpill-pancard-input" class="form-label">Session Name</label>
                                                    <input type="text" class="form-control" placeholder="Session Name" id="basicpill-pancard-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input"
                                                           class="form-label">&nbsp;</label>
                                                    <input type="text" class="form-control" placeholder="" id="basicpill-vatno-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="basicpill-cstno-input" class="form-label">Mô tả session</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            </div><!-- end col -->

                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">Session 1</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputPassword">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputPassword">
                                                </div>
                                                <div class="col-sm-2">
                                                    {{--Button delete--}}
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-danger mb-3">Xoá</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">

                                                <div class="d-flex flex-row-reverse">
                                                    <div class="p-2">
                                                        <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".add-new-order"><i class="mdi mdi-plus me-1"></i> Thêm Item</button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
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
                                            <div class="col-lg-9">
                                                <div class="mb-3">
                                                    <label for="basicpill-pancard-input" class="form-label">Scan Booth</label>
                                                    <input type="text" class="form-control" placeholder="Session Name" id="basicpill-pancard-input">
                                                </div>
                                            </div><!-- end col -->

                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-vatno-input"
                                                           class="form-label">&nbsp;</label>
                                                    <input type="text" class="form-control" placeholder="" id="basicpill-vatno-input">
                                                </div>
                                            </div><!-- end col -->
                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="basicpill-cstno-input" class="form-label">Mô tả Booth</label>
                                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                </div>
                                            </div><!-- end col -->

                                        </div><!-- end row -->
                                        <div class="row">
                                            <div class="mb-3 row">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">Booth 1</label>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputPassword">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="text" class="form-control" id="inputPassword">
                                                </div>
                                                <div class="col-sm-2">
                                                    {{--Button delete--}}
                                                    <div class="col-auto">
                                                        <button type="submit" class="btn btn-danger mb-3">Xoá</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">

                                                <div class="d-flex flex-row-reverse">
                                                    <div class="p-2">
                                                        <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".add-new-order"><i class="mdi mdi-plus me-1"></i> Thêm Item</button>
                                                    </div>
                                                </div>
                                                <hr>
                                            </div>
                                        </div>
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
                                            <div class="col-lg-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        Social
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="option1">
                                                                    <label class="form-check-label" for="inlineCheckbox1">Comment</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox2" value="option2">
                                                                    <label class="form-check-label" for="inlineCheckbox2">like</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox3" value="option3">
                                                                    <label class="form-check-label" for="inlineCheckbox3">Retweet</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2">
                                                                <div class="form-check form-check-inline">
                                                                    <input class="form-check-input" type="checkbox" id="inlineCheckbox4" value="option4">
                                                                    <label class="form-check-label" for="inlineCheckbox4">Tweet</label>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mt-3">
                                                            <div class="mb-3">
                                                                <label for="basicpill-cardno-input"
                                                                       class="form-label">Url</label>
                                                                <input type="text" class="form-control" placeholder="Url" id="basicpill-cardno-input">
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="basicpill-cardno-input"
                                                                       class="form-label">Text</label>
                                                                <input type="text" class="form-control" placeholder="Text" id="basicpill-cardno-input">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="card">
                                                    <div class="card-header">
                                                        Discord
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3">
                                                            <label for="basicpill-cardno-input"
                                                                   class="form-label">Bot Token</label>
                                                            <input type="text" class="form-control" placeholder="Bot Token" id="basicpill-cardno-input">
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="basicpill-cardno-input"
                                                                           class="form-label">Channel Id</label>
                                                                    <input type="text" class="form-control" placeholder="Channel Id" id="basicpill-cardno-input">
                                                                </div>
                                                            </div><!-- end col -->
                                                            <div class="col-lg-6">
                                                                <div class="mb-3">
                                                                    <label for="basicpill-cardno-input"
                                                                           class="form-label">Channel Url</label>
                                                                    <input type="text" class="form-control" placeholder="Channel Url" id="basicpill-cardno-input">
                                                                </div>
                                                            </div><!-- end col -->
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                            </div>
                                        </div><!-- end row -->
                                    </div><!-- end form -->

                            </div>
                            <div class="wizard-tab">
                                <div>
                                    <div class="text-center mb-4">
                                        <h5>Quiz</h5>
                                        <p class="card-title-desc">Fill all information below</p>
                                    </div>
                                    <div>
                                        <div class="row">
                                            <div class="col-lg-7">
                                                <div class="mb-3">
                                                    <label for="basicpill-expiration-input"
                                                           class="form-label">Question 1</label>
                                                    <input type="text" class="form-control" id="datepicker-basic" placeholder="Question 1" id="basicpill-expiration-input">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <div class="mb-3">
                                                    <label for="basicpill-expiration-input"
                                                           class="form-label">Time</label>
                                                    <input type="text" class="form-control" id="datepicker-basic" placeholder="Time" id="basicpill-expiration-input">
                                                </div>
                                            </div>
                                            <div class="col-lg-1">
                                                <div class="mb-3">
                                                    <label for="basicpill-expiration-input"
                                                           class="form-label">Order</label>
                                                    <input type="text" class="form-control" id="datepicker-basic" placeholder="Order" id="basicpill-expiration-input">
                                                </div>
                                            </div>
                                            <div class="col-lg-2">
                                                <label for="basicpill-expiration-input"
                                                       class="form-label">&nbsp;</label>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                                                    <label class="form-check-label" for="flexSwitchCheckChecked">Status</label>
                                                </div>
                                            </div>
                                        </div><!-- end row -->
                                        <br>
                                        <div class="row">
                                            <div class="mb-3 row offset-md-1">
                                                <label for="inputPassword" class="col-sm-2 col-form-label">Answer 1</label>
                                                <div class="col-sm-7">
                                                    <input type="text" class="form-control" id="inputPassword">
                                                </div>
                                                <div class="col-sm-2">

                                                    <div class="form-check mt-2">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                                        <label class="form-check-label" for="flexCheckDefault">
                                                            Option
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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


        var currentTab = {{$activeTab}}; // Current tab is set to be the first tab (0)
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
