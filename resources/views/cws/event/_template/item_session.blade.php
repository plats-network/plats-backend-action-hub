<hr>
<div class="mb-3 row itemSessionDetail" id="itemImage{{$indexImageItem}}">
    <label for="inputPassword" class="col-sm-12 col-form-label">
        Session {{$getInc}}<span class="text-danger" style="font-size: 11px;">(Chú ý: Những trường có dấu * bắt buộc phải nhập)</span>
    </label>
    <div class="row">
        <div class="col-lg-4 mb-2">
            <label class="col-form-label">Chọn travel game</label>
            <select class="form-select" name="sessions[detail][{{$indexImageItem}}][travel_game_id]">
                @foreach($travelGames as $game)
                    <option value="{{$game->id}}">{{$game->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <input
            type="text"
            class="form-control"
            id="sessions[detail][{{$indexImageItem}}][name]"
            name="sessions[detail][{{$indexImageItem}}][name]"
            placeholder="Tên session {{$getInc}}"
            value="">
    </div>

    <div class="col-sm-4">
        <input
            type="text"
            class="form-control"
            id="sessions[detail][{{$indexImageItem}}][description]"
            name="sessions[detail][{{$indexImageItem}}][description]"
            placeholder="Mô tả {{$getInc}}"
            value="">
    </div>
 
    <div class="col-sm-2 mt-2">
        <input
            class="form-check-input"
            data-id="{{$indexImageItem}}"
            type="checkbox" value="1"
            name="sessions[detail][{{$indexImageItem}}][is_required]"
            id="r_{{$getInc}}">
        <label class="form-check-label" for="r_{{$getInc}}">
            Bắt buộc
        </label>
    </div>

    <div class="col-sm-2 mt-2">
        <input
            class="form-check-input sCheck"
            data-id="{{$indexImageItem}}"
            type="checkbox" value="1"
            name="sessions[detail][{{$indexImageItem}}][is_question]"
            id="q_{{$getInc}}">
        <label class="form-check-label" for="q_{{$getInc}}">
            Câu hỏi
        </label>
    </div>

    {{-- And question --}}
    <div id="s-{{$indexImageItem}}" class="d-none">
        <div class="row mt-1">
            <label class="form-check-label">Câu hỏi</label>
            <div class="col-sm-12">
                <input
                    type="text"
                    class="form-control"
                    id="sq-{{$indexImageItem}}"
                    name="sessions[detail][{{$indexImageItem}}][question]"
                    placeholder="Câu hỏi {{$getInc}}"
                    value="">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-4">
                <label class="form-check-label">Đáp án 1</label>
                <input
                    type="text"
                    class="form-control"
                    id="sa1-{{$indexImageItem}}"
                    name="sessions[detail][{{$indexImageItem}}][a1]"
                    placeholder="Nội dung"
                    value="">
            </div>
            <div class="col-sm-2 mt-4">
                <input
                    class="form-check-input"
                    data-id="{{$indexImageItem}}"
                    type="checkbox"
                    value="1"
                    name="sessions[detail][{{$indexImageItem}}][is_a1]"
                    id="is_a1_{{$getInc}}">
                <label class="form-check-label" for="is_a1_{{$getInc}}">
                    Chọn đúng
                </label>
            </div>
            <div class="col-sm-4">
                <label class="form-check-label">Đáp án 2</label>
                <input
                    type="text"
                    class="form-control"
                    id="sa2-{{$indexImageItem}}"
                    name="sessions[detail][{{$indexImageItem}}][a2]"
                    placeholder="Nội dung"
                    value="">
            </div>
            <div class="col-sm-2 mt-4">
                <input
                    class="form-check-input"
                    data-id="{{$indexImageItem}}"
                    type="checkbox" value="1"
                    name="sessions[detail][{{$indexImageItem}}][is_a2]"
                    id="is_a2_{{$getInc}}">
                <label class="form-check-label" for="is_a2_{{$getInc}}">
                    Chọn đúng
                </label>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-4">
                <label class="form-check-label">Đáp án 3</label>
                <input
                    type="text"
                    class="form-control"
                    id="sa3-{{$indexImageItem}}"
                    name="sessions[detail][{{$indexImageItem}}][a3]"
                    placeholder="Nội dung"
                    value="">
            </div>
            <div class="col-sm-2 mt-4">
                <input
                    class="form-check-input"
                    data-id="{{$indexImageItem}}"
                    type="checkbox" value="1"
                    name="sessions[detail][{{$indexImageItem}}][is_a3]"
                    id="is_a3_{{$getInc}}">
                <label class="form-check-label" for="is_a3_{{$getInc}}">
                    Chọn đúng
                </label>
            </div>
            <div class="col-sm-4">
                <label class="form-check-label">Đáp án 4</label>
                <input
                    type="text"
                    class="form-control"
                    id="sa4-{{$indexImageItem}}"
                    name="sessions[detail][{{$indexImageItem}}][a4]"
                    placeholder="Nội dung"
                    value="">
            </div>
            <div class="col-sm-2 mt-4">
                <input
                    class="form-check-input"
                    data-id="{{$indexImageItem}}"
                    type="checkbox" value="1"
                    name="sessions[detail][{{$indexImageItem}}][is_a4]"
                    id="is_a4_{{$getInc}}">
                <label class="form-check-label" for="is_a4_{{$getInc}}">
                    Chọn đúng
                </label>
            </div>
        </div>
    </div>

    <div class="col-sm-12 text-right">
        <div class="col-auto">
            <button
                type="button"
                data-id="{{$indexImageItem}}"
                onclick="deleteImageReform({{$indexImageItem}})"
                class="btn btn-danger mb-3 btnDeleteImage">Xoá</button>
        </div>
    </div>
</div>
