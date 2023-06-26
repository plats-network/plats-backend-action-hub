<div id="tabwizard2" class="wizard-tab">
    <div class="text-center mb-4">
        <h5>Booths</h5>
        <p class="card-title-desc">Fill all information below</p>
    </div>
    <div>
        <div class="row">
            <input type="hidden" name="booths[id]" id="booths[id]" value="{{$booths->id}}">
            <input type="hidden" name="booths[task_id]" id="booths[task_id]" value="{{$event->id}}">
            <div class="col-lg-9">
                <div class="mb-3">
                    <label for="booths[name]" class="form-label">Name Booth</label>
                    <input type="text" class="form-control" value="{{$booths->name}}" placeholder="Booth Name" id="booths[name]" name="booths[name]" />
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
            </div><!-- end col -->
        </div><!-- end row -->
        <div class="row">
            <div class="col-lg-12">
                <div class="mb-3">
                    <label for="booths[description]" class="form-label">Mô tả Booth</label>
                    <div id="editor3"></div>
                    <input type="hidden" class="form-control" id="booths-description" name="booths[description]" value="{{$booths->description}}"  />

                </div>
            </div><!-- end col -->

        </div><!-- end row -->
        <div class="row mt-3">
            @if ($isPreview)
                <table class="table table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>QR Code</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($booths->detail as $k => $booth)
                            @php
                                $qr = 'https://'.config('plats.event').'/events/code?type=event&id='.$booth->code;
                            @endphp
                            <tr>
                               <td width="5%">{{$k+1}}</td> 
                               <td width="20%">{{$booth->name}}</td> 
                               <td width="30%">{!!$booth->description!!}</td> 
                               <td width="20%" data-url="{{$qr}}" class="text-center">
                                    <img
                                        style="margin: 0 auto;"
                                        src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(150)->generate($qr)) !!} ">
                                    <a
                                        href="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(300)->generate($qr)) !!} "
                                        class="btn btn-primary text-center" download="booth_{{$booth->code.'_'.($k+1)}}.png">
                                        Download</a>
                               </td> 
                               <td width="10%">{{rand(10, 100)}}</td>
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
                <div class="listRowBooth" id="listRowBooth">
                    @foreach($booths->detail as $k => $boothDetail)
                        <div class="mb-3 row itemBoothDetail" id="itemBooth{{$boothDetail->id}}">
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
                            <label for="inputPassword" class="col-sm-2 col-form-label">Booth {{$k+1}}</label>
                            <div class="col-sm-4">
                                <input
                                    type="text"
                                    placeholder="Name"
                                    class="form-control"
                                    id="booths[detail][{{$boothDetail->id}}][name]"
                                    name="booths[detail][{{$boothDetail->id}}][name]"
                                    value="{{$boothDetail->name}}">
                            </div>
                            <div class="col-sm-4">
                                <input
                                    type="text"
                                    placeholder="Description"
                                    class="form-control"
                                    id="booths[detail][{{$boothDetail->id}}][description]"
                                    name="booths[detail][{{$boothDetail->id}}][description]"
                                    value="{{$boothDetail->description}}">
                            </div>
                            <div class="col-sm-2">
                                <div class="col-auto">
                                    <button
                                        type="button"
                                        data-id="{{$boothDetail->id}}"
                                        onclick="deleteImageReform({{$boothDetail->id}})"
                                        class="btn btn-danger mb-3 btnDeleteImageBooth">Xoá</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-3">
                    <div class="d-flex flex-row-reverse">
                        <div class="p-2">
                            <button id="btnAddItemBooth" type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"><i class="mdi mdi-plus me-1"></i> Thêm job</button>
                        </div>
                    </div>
                    <hr>
                </div>
            @endif
        </div>
    </div>
</div>
