<div id="tabwizard1" class="wizard-tab">
    <div class="text-center mb-4">
        <h5>Sessions</h5>
        <p class="card-title-desc">Fill all information below</p>
    </div>
    <div>
        <input type="hidden" name="sessions[id]" id="sessions[id]" value="{{$sessions->id}}">
        <input type="hidden" name="sessions[task_id]" id="sessions[task_id]" value="{{$event->id}}">
        <div class="row">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="basicpill-pancard-input" class="form-label">Session Name</label>
                    <input type="text" class="form-control" value="{{$sessions->name}}" placeholder="Session Name" id="sessions[name]" name="sessions[name]">
                    <div class="valid-feedback"></div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="mb-3">
                    <label for="basicpill-vatno-input"
                        class="form-label">Max job</label>
                    {{-- <p class="card-title-desc">Số lượng job hoàn thành để nhận được mã số quay thưởng.</p> --}}
                    <input
                        type="number"
                        class="form-control"
                        placeholder="2"
                        value="{{$sessions->max_job}}"
                        id="sessions[max_job]"
                        name="sessions[max_job]"
                        min="0"
                        max="100">
                    <div class="valid-feedback"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="basicpill-cstno-input" class="form-label">Mô tả session</label>
                    <div id="editor2"></div>
                    <input type="hidden" class="form-control" id="sessions-description" name="sessions[description]" value="{{$sessions->description}}"  />

                </div>
            </div>
        </div>

        @if ($isPreview)
            <table class="table table-bordered mb-0">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>QR Code</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions->detail as $k => $session)
                        <tr>
                           <td>{{$k+1}}</td> 
                           <td>{{$session->name}}</td> 
                           <td>{!!$session->description!!}</td> 
                           <td>
                                @php
                                    $qr = 'https://'.config('plats.event').'/events/code?type=event&id='.$session->code;
                                @endphp
                                {!! QrCode::size(200)->generate($qr) !!}
                           </td> 
                           <td>
                                <input
                                        type="checkbox"
                                        id="session_{{ $k+1 }}"
                                        switch="none"
                                        @if($session->status) checked @endif
                                    >
                                    <label class="job"
                                        data-id="{{$session->code}}"
                                        data-detail-id="{{$sessions->id}}"
                                        for="session_{{ $k+1 }}"
                                        data-on-label="On"
                                        data-off-label="Off">
                                    </label>
                           </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="row mt-3">
                <div class="listRowSession" id="listRowSession">
                    @foreach($sessions->detail as $sessionDetail)
                        <div class="mb-3 row itemSessionDetail" id="itemImage{{$sessionDetail->id}}">
                            {{--Id--}}
                            <input
                                type="hidden"
                                name="sessions[detail][{{$sessionDetail->id}}][id]"
                                id="sessions[detail][{{$sessionDetail->id}}][id]"
                                value="{{$sessionDetail->id}}">
                            {{--Session Id--}}
                            {{--Is delete--}}
                            <input
                                type="hidden"
                                name="sessions[detail][{{$sessionDetail->id}}][is_delete]"
                                id="sessionsFlagDelete{{$sessionDetail->id}}"
                                value="0">

                            <label for="inputPassword" class="col-sm-2 col-form-label">Session {{$loop->index+1}}</label>
                            <div class="col-sm-4">
                                <input
                                    type="text"
                                    placeholder="Name"
                                    class="form-control"
                                    id="sessions[detail][{{$sessionDetail->id}}][name]"
                                    name="sessions[detail][{{$sessionDetail->id}}][name]"
                                    value="{{$sessionDetail->name}}">
                            </div>
                            <div class="col-sm-4">
                                <input
                                    type="text"
                                    placeholder="Description"
                                    class="form-control"
                                    id="sessions[detail][{{$sessionDetail->id}}][description]"
                                    name="sessions[detail][{{$sessionDetail->id}}][description]"
                                    value="{{$sessionDetail->description}}">
                            </div>
                            <div class="col-sm-2">
                                <div class="col-auto">
                                    <button
                                        type="button"
                                        data-id="{{$sessionDetail->id}}"
                                        onclick="deleteImageReform({{$sessionDetail->id}})"
                                        class="btn btn-danger mb-3 btnDeleteImage">Xoá</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mt-3">
                    <div class="d-flex flex-row-reverse">
                        <div class="p-2">
                            <button
                                id="btnAddItemSession"
                                type="button"
                                class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2">
                                <i class="mdi mdi-plus me-1"></i> Thêm</button>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        @endif
    </div>
</div>
