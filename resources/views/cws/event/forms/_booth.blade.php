<div id="tabwizard3" class="wizard-tab">
    <div class="text-center mb-4">
        <h5>Booths</h5>
        <p class="card-title-desc text-danger">
            - Trong sự kiện bạn tổ chức nếu có booth thì vui lòng tạo booth
            <br>
            - Nếu không có booth bạn ấn "Next" để bỏ qua bước tạo booth
        </p>
    </div>

    <div>
        <div class="row">
            <input type="hidden" name="booths[id]" id="booths[id]" value="{{$booths->id}}">
            <input type="hidden" name="booths[task_id]" id="booths[task_id]" value="{{$event->id}}">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="booths[name]" class="form-label">Name</label>
                    <input type="text" class="form-control" value="{{$booths->name}}" placeholder="Name" id="booths[name]" name="booths[name]" />
                    <div class="valid-feedback"></div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="mb-3">
                    <label
                        for="basicpill-vatno-input"
                        class="form-label">Max Job</label>
                    <input
                        type="number"
                        class="form-control"
                        value="{{$booths->max_job}}"
                        placeholder="2"
                        id="booths[max_job]"
                        name="booths[max_job]">
                    <div class="valid-feedback"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="booths[description]" class="form-label">Description</label>
                    <div id="editor3"></div>
                    <input type="hidden" class="form-control" id="booths-description" name="booths[description]" value="{{$booths->description}}" />

                </div>
            </div>
        </div>
        <div class="row mt-3">
            @if ($isPreview)
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr class="text-center">
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>QR Code</th>
                            <th>Total</th>
                            <th>Vip</th>
                            <th>Click</th>
                            <th>QR <span class="text-danger">(ON/OFF)</span></th>
                        </tr>
                    </thead>
                    <tbody id="list-booth-id" data-b-ids="{{json_encode($booths->detail->pluck('id')->toArray())}}">
                        @foreach($booths->detail as $k => $booth)
                            @php
                                $qr = 'http://'.config('plats.event').'/events/code?type=event&id='.$booth->code;
                            @endphp
                            <tr>
                               <td width="5%">{{$k+1}}</td> 
                               <td width="20%">{{$booth->name}}</td> 
                               <td width="30%">{!!$booth->description!!}</td> 
                               <td width="20%" data-url="{{$qr}}" class="text-center">
                                    <p class="qr" id="bo-{{$booth->id}}" data-bo-url="{{$qr}}"></p>
                                    <div class="d-none" style="width: 300px; height: 300px;" id="dbo-{{$booth->id}}" data-bo-url="{{$qr}}"></div>
                                    <a class="bo-donw" data-id="{{$booth->id}}" data-num="{{$k+1}}" data-name="booth">Download</a>
                               </td> 
                               <td width="10%">{{totalUserJob($booth->id)}}</td>
                               <td>{{$booth->is_required ? 'Vip' : 'Normal'}}</td>
                               <td width="10%"><a href="{{$qr}}" target="_blank">link</a></td>
                               <td width="20%">
                                    <input
                                        type="checkbox"
                                        id="booth_{{ $k+1 }}"
                                        switch="none"
                                        @if($booth->status) checked @endif
                                    >
                                    <label class="job"
                                        data-id="{{$booth->code}}"
                                        data-detail-id="{{$booths->id}}"
                                        for="booth_{{ $k+1 }}"
                                        data-on-label="On"
                                        data-off-label="Off">
                                    </label>
                               </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="listRowBooth" id="listRowBooth" style="padding-left: 150px;">
                    @foreach($booths->detail as $k => $boothDetail)
                        <div class="mb-3 row itemBoothDetail" id="itemBooth{{$boothDetail->id}}">
                            <hr>
                            <input
                                type="hidden"
                                name="booths[detail][{{$boothDetail->id}}][id]"
                                id="booths[detail][{{$boothDetail->id}}][id]"
                                value="{{$boothDetail->id}}">
                            <input
                                type="hidden"
                                name="booths[detail][{{$boothDetail->id}}][is_delete]"
                                id="boothFlagDelete{{$boothDetail->id}}"
                                value="0">
                            <label class="col-sm-12 col-form-label">Booth {{$k+1}} <span class="text-danger" style="font-size: 11px;">(Chú ý: Những trường có dấu * bắt buộc phải nhập)</span></label>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label class="col-form-label">Travel game</label>
                                    <select class="form-select" name="booths[detail][{{$boothDetail->id}}][travel_game_id]">
                                        @foreach($travelGames as $game)
                                            <option value="{{$game->id}}" @if($boothDetail->travel_game_id == $game->id) selected @endif>{{$game->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label">Name <span class="text-danger">(*)</span></label>
                                <input
                                    type="text"
                                    placeholder="Name"
                                    class="form-control"
                                    id="booths[detail][{{$boothDetail->id}}][name]"
                                    name="booths[detail][{{$boothDetail->id}}][name]"
                                    value="{{$boothDetail->name}}">
                            </div>
                            <div class="col-sm-4">
                                <label class="col-form-label">Description <span class="text-danger">(*)</span></label>
                                <input
                                    type="text"
                                    placeholder="Description"
                                    class="form-control"
                                    id="booths[detail][{{$boothDetail->id}}][description]"
                                    name="booths[detail][{{$boothDetail->id}}][description]"
                                    value="{{$boothDetail->description}}">
                            </div>

                            <div class="col-sm-4 mt-5 mt-5">
                                <input type="hidden" name="booths[detail][{{$boothDetail->id}}][is_question]" value="{{$boothDetail->is_question}}">
                                <input
                                    class="form-check-input"
                                    data-id="{{$boothDetail->id}}"
                                    type="checkbox" value="1"
                                    name="booths[detail][{{$boothDetail->id}}][is_required]"
                                    @if($boothDetail->is_required) checked @endif
                                    id="br_{{$boothDetail->id}}">
                                <label class="form-check-label" for="br_{{$boothDetail->id}}">
                                    Vip <span class="text-danger" style="font-size: 11px;">(Yes/No)</span>
                                </label>
                            </div>

                            {{-- Question --}}
                            {{-- <div class="col-sm-2 mt-5 mt-5">
                                <input
                                    class="form-check-input bCheck"
                                    data-id="{{$boothDetail->id}}"
                                    type="checkbox" value="1"
                                    name="booths[detail][{{$boothDetail->id}}][is_question]"
                                    @if($boothDetail->is_question) checked @endif
                                    id="bq_{{$boothDetail->id}}">
                                <label class="form-check-label" for="bq_{{$boothDetail->id}}">
                                    Is quesion <span class="text-danger" style="font-size: 11px;">(Yes/No)</span>
                                </label>
                            </div> --}}

                            {{-- <div id="b-{{$boothDetail->id}}" class="{{$boothDetail->is_question ? '' : 'd-none'}}">
                                <div class="row mt-1">
                                    <div class="col-sm-12">
                                        <label class="form-check-label">Quesion</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="booths[detail][{{$boothDetail->id}}][question]"
                                            name="booths[detail][{{$boothDetail->id}}][question]"
                                            placeholder="Quesion"
                                            value="{{$boothDetail->is_question}}">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <label class="form-check-label">Answer 1</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="booths[detail][{{$boothDetail->id}}][a1]"
                                            name="booths[detail][{{$boothDetail->id}}][a1]"
                                            placeholder="Nội dung"
                                            value="{{$boothDetail->a1}}">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <input
                                            class="form-check-input"
                                            data-id="{{$boothDetail->id}}"
                                            type="checkbox" value="1"
                                            name="booths[detail][{{$boothDetail->id}}][is_a1]"
                                            @if($boothDetail->is_a1) checked @endif
                                            id="bis_a1_{{$boothDetail->id}}">
                                        <label class="form-check-label" for="bis_a1_{{$boothDetail->id}}">
                                            Chọn đúng
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-check-label">Answer 2</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="booths[detail][{{$boothDetail->id}}][a2]"
                                            name="booths[detail][{{$boothDetail->id}}][a2]"
                                            placeholder="Nội dung"
                                            value="{{$boothDetail->a2}}">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <input
                                            class="form-check-input"
                                            data-id="{{$boothDetail->id}}"
                                            type="checkbox" value="1"
                                            name="booths[detail][{{$boothDetail->id}}][is_a2]"
                                            @if($boothDetail->is_a2) checked @endif
                                            id="bis_a2_{{$boothDetail->id}}">
                                        <label class="form-check-label" for="bis_a2_{{$boothDetail->id}}">
                                            Chọn đúng
                                        </label>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-sm-4">
                                        <label class="form-check-label">Answer 3</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="booths[detail][{{$boothDetail->id}}][a3]"
                                            placeholder="Nội dung"
                                            value="{{$boothDetail->a3}}">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <input
                                            class="form-check-input"
                                            data-id="{{$boothDetail->id}}"
                                            type="checkbox" value="1"
                                            name="booths[detail][{{$boothDetail->id}}][is_a3]"
                                            @if($boothDetail->is_a3) checked @endif
                                            id="bis_a3_{{$boothDetail->id}}">
                                        <label class="form-check-label" for="bis_a3_{{$boothDetail->id}}">
                                            Chọn đúng
                                        </label>
                                    </div>
                                    <div class="col-sm-4">
                                        <label class="form-check-label">Answer 4</label>
                                        <input
                                            type="text"
                                            class="form-control"
                                            id="booths[detail][{{$boothDetail->id}}][a4]"
                                            name="booths[detail][{{$boothDetail->id}}][a4]"
                                            placeholder="Nội dung"
                                            value="{{$boothDetail->a4}}">
                                    </div>
                                    <div class="col-sm-2 mt-4">
                                        <input
                                            class="form-check-input"
                                            data-id="{{$boothDetail->id}}"
                                            type="checkbox" value="1"
                                            name="booths[detail][{{$boothDetail->id}}][is_a4]"
                                            @if($boothDetail->is_a4) checked @endif
                                            id="bis_a4_{{$boothDetail->id}}">
                                        <label class="form-check-label" for="bis_a4_{{$boothDetail->id}}">
                                            Yes/No
                                        </label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="col-sm-12 text-right">
                                <div class="col-auto">
                                    <button type="button" data-id="{{$boothDetail->id}}" class="btn btn-danger mb-3 bRemove">Remove</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="row mt-3">
                    <div class="d-flex flex-row-reverse">
                        <div class="p-2">
                            <button id="btnAddItemBooth" type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Add More</button>
                        </div>
                    </div>
                    <hr>
                </div>
            @endif
        </div>
    </div>
</div>
