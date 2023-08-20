<div id="tabwizard2" class="wizard-tab">
    <div class="text-center mb-4">
        <h5>Sessions</h5>
        <p class="card-title-desc text-danger">
            - Trong sự kiện bạn tổ chức nếu có session thì vui lòng tạo sesion
            <br>
            - Nếu không có session bạn ấn "Next" để bỏ qua bước tạo session
        </p>
    </div>
    <div>
        <input type="hidden" name="sessions[id]" id="sessions[id]" value="{{$sessions->id}}">
        <input type="hidden" name="sessions[task_id]" id="sessions[task_id]" value="{{$event->id}}">
        <div class="row">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="basicpill-pancard-input" class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{$sessions->name}}" placeholder="Name" id="sessions[name]" name="sessions[name]">
                    <div class="valid-feedback"></div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="mb-3">
                    <label for="basicpill-vatno-input"
                        class="form-label">Max job</label>
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
                    <label for="basicpill-cstno-input" class="form-label">Description</label>
                    <div id="editor2"></div>
                    <input type="hidden"
                        class="form-control"
                        id="sessions-description"
                        name="sessions[description]"
                        value="{{$sessions->description}}" />
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
                        <th>QR</th>
                        <th>
                            Download
                        </th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions->detail as $k => $session)
                        @php
                            $qr = 'https://'.config('plats.event').'/events/code?type=event&id='.$session->code;
                        @endphp
                        <tr>
                           <td width="5%">{{$k+1}}</td> 
                           <td width="20%">{{$session->name}}</td> 
                           <td width="30%">{!!$session->description!!}</td>
                           <td width="20%" class="text-center" data-url="{{$qr}}">
                               <img style="margin: 0 auto;"
                                    src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(100)->generate($qr)) !!}">
                           </td>
                           <td width="20%" class="text-center" data-url="{{$qr}}">
                                <a href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate($qr)) !!}"
                                    download="session_{{$session->code.'_'.($k+1)}}.png">
                                    Download</a>
                           </td>
                           <td width="5%">{{totalUserJob($session->id)}}</td>
                           <td width="20%">
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
                <div class="listRowSession" id="listRowSession" style="padding-left: 150px;">
                    @foreach($sessions->detail as $a => $sessionDetail)
                        <div class="mb-3 row itemSessionDetail" id="itemSession{{$sessionDetail->id}}">
                            <hr>
                            <input
                                type="hidden"
                                name="sessions[detail][{{$sessionDetail->id}}][id]"
                                id="sessions[detail][{{$sessionDetail->id}}][id]"
                                value="{{$sessionDetail->id}}">
                            <input
                                type="hidden"
                                name="sessions[detail][{{$sessionDetail->id}}][is_delete]"
                                id="sessionsFlagDelete{{$sessionDetail->id}}"
                                value="0">

                            <label class="col-sm-12 col-form-label">
                                Session {{$loop->index+1}}<span class="text-danger" style="font-size: 11px;"> (Chú ý: Những trường có dấu * bắt buộc phải nhập)</span>
                            </label>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="col-form-label">Chọn travel game</label>
                                    <select class="form-select" name="sessions[detail][{{$sessionDetail->id}}][travel_game_id]">
                                        @foreach($travelGames as $game)
                                            <option value="{{$game->id}}" @if($sessionDetail->travel_game_id == $game->id) selected @endif>{{$game->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label">Name <span class="text-danger" style="font-size: 11px;">(*)</span></label>
                                <input
                                    type="text"
                                    placeholder="Name"
                                    class="form-control"
                                    id="sessions[detail][{{$sessionDetail->id}}][name]"
                                    name="sessions[detail][{{$sessionDetail->id}}][name]"
                                    value="{{$sessionDetail->name}}">
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label">Description <span class="text-danger" style="font-size: 11px;">(optional)</label>
                                <input
                                    type="text"
                                    placeholder="Description"
                                    class="form-control"
                                    id="sessions[detail][{{$sessionDetail->id}}][description]"
                                    name="sessions[detail][{{$sessionDetail->id}}][description]"
                                    value="{{$sessionDetail->description}}">
                            </div>
                            <div class="col-sm-2 mt-5 mt-5">
                                <input
                                    class="form-check-input"
                                    data-id="{{$sessionDetail->id}}"
                                    type="checkbox" value="1"
                                    name="sessions[detail][{{$sessionDetail->id}}][is_required]"
                                    @if ($sessionDetail->is_required) checked @endif
                                    id="r_{{$sessionDetail->id}}">
                                <label class="form-check-label" for="r_{{$sessionDetail->id}}">
                                    Required <span class="text-danger" style="font-size: 11px;">(Yes/No)</span>
                                </label>
                            </div>
                            <div class="col-sm-2 mt-5 mt-5">
                                <input
                                    class="form-check-input sCheck"
                                    data-id="{{$sessionDetail->id}}"
                                    type="checkbox" value="1"
                                    name="sessions[detail][{{$sessionDetail->id}}][is_question]"
                                    @if ($sessionDetail->is_required) is_question @endif
                                    id="q_{{$sessionDetail->id}}">
                                <label class="form-check-label" for="q_{{$sessionDetail->id}}">
                                    Is question <span class="text-danger" style="font-size: 11px;">(Yes/No)</span>
                                </label>
                            </div>

                            <div id="s-{{$sessionDetail->id}}" class="{{$sessionDetail->is_question ? '' : 'd-none'}}">
                                <div class="row mt-1">
                                    <div class="col-sm-12">
                                        <label class="form-check-label">Question</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="sessions[detail][{{$sessionDetail->id}}][question]"
                                            name="sessions[detail][{{$sessionDetail->id}}][question]"
                                            placeholder="Câu hỏi"
                                            value="{{$sessionDetail->question}}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <label class="form-check-label">Answer 1</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="sessions[detail][{{$sessionDetail->id}}][a1]"
                                            name="sessions[detail][{{$sessionDetail->id}}][a1]"
                                            placeholder="Answer"
                                            value="{{$sessionDetail->a1}}">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <input
                                            class="form-check-input checkQ"
                                            data-id="{{$sessionDetail->id}}"
                                            type="checkbox" value="1"
                                            name="sessions[detail][{{$sessionDetail->id}}][is_a1]"
                                            @if ($sessionDetail->is_a1) checked @endif
                                            id="is_a1_{{$sessionDetail->id}}">
                                        <label class="form-check-label" for="is_a1_{{$sessionDetail->id}}">
                                            Yes/No
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-check-label">Answer 2</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="sessions[detail][{{$sessionDetail->id}}][a2]"
                                            name="sessions[detail][{{$sessionDetail->id}}][a2]"
                                            placeholder="Answer"
                                            value="{{$sessionDetail->a2}}">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <input
                                            class="form-check-input checkQ"
                                            data-id="{{$sessionDetail->id}}"
                                            type="checkbox" value="1"
                                            name="sessions[detail][{{$sessionDetail->id}}][is_a2]"
                                            @if ($sessionDetail->is_a2) checked @endif
                                            id="is_a2_{{$sessionDetail->id}}">
                                        <label class="form-check-label" for="is_a2_{{$sessionDetail->id}}">
                                            Yes/No
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <label class="form-check-label">Answer 3</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="sessions[detail][{{$sessionDetail->id}}][a3]"
                                            placeholder="Answer"
                                            value="{{$sessionDetail->a3}}">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <input
                                            class="form-check-input checkQ"
                                            data-id="{{$sessionDetail->id}}"
                                            type="checkbox" value="1"
                                            name="sessions[detail][{{$sessionDetail->id}}][is_a3]"
                                            @if ($sessionDetail->is_a3) checked @endif
                                            id="is_a3_{{$sessionDetail->id}}">
                                        <label class="form-check-label" for="is_a3_{{$sessionDetail->id}}">
                                            Yes/No
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-check-label">Answer 4</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="sessions[detail][{{$sessionDetail->id}}][a4]"
                                            name="sessions[detail][{{$sessionDetail->id}}][a4]"
                                            placeholder="Nội dung"
                                            value="{{$sessionDetail->a4}}">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <input
                                            class="form-check-input checkQ"
                                            data-id="{{$sessionDetail->id}}"
                                            type="checkbox" value="1"
                                            name="sessions[detail][{{$sessionDetail->id}}][is_a4]"
                                            @if ($sessionDetail->is_a4) checked @endif
                                            id="is_a4_{{$sessionDetail->id}}">
                                        <label class="form-check-label" for="is_a4_{{$sessionDetail->id}}">
                                            Yes/No
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-12 text-right">
                                <div class="col-auto">
                                    <button type="button" data-id="{{$sessionDetail->id}}" class="btn btn-danger mb-3 sRemove">Remove</button>
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
                                <i class="mdi mdi-plus me-1"></i> Add More</button>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
        @endif
    </div>
</div>
