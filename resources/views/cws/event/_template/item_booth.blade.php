<div class="mb-3 row itemBoothDetail" id="itemBooth{{$indexImageItem}}">
    <hr>
    <label class="col-sm-12 col-form-label">
        Booth {{$getInc}}<span class="text-danger" style="font-size: 11px;">(Chú ý: Những trường có dấu * bắt buộc phải nhập)</span>
    </label>
    <div class="row">
        <div class="col-lg-4 mb-2">
            <label class="col-form-label">Travel game</label>
            <select class="form-select" name="booths[detail][{{$indexImageItem}}][travel_game_id]">
                @foreach($travelGames as $game)
                    <option value="{{$game->id}}">{{$game->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-sm-4">
        <label class="col-form-label">Name <span class="text-danger fs-11">(*)</span></label>
        <input
            type="text"
            class="form-control"
            id="booths[detail][{{$indexImageItem}}][name]"
            name="booths[detail][{{$indexImageItem}}][name]"
            placeholder="Name {{$getInc}}"
            value="">
    </div>
    <div class="col-sm-4">
        <label class="col-form-label">Description <span class="text-danger fs-11">(optional)</span></label>
        <input
            type="text"
            class="form-control"
            id="booths[detail][{{$indexImageItem}}][description]"
            name="booths[detail][{{$indexImageItem}}][description]"
            placeholder="Mô tả {{$getInc}}"
            value="">
    </div>

    <div class="col-sm-4 mt-5">
        <input type="hidden" name="booths[detail][{{$indexImageItem}}][is_question]" value="0">
        <input
            class="form-check-input"
            data-id="{{$indexImageItem}}"
            type="checkbox" value="1"
            name="booths[detail][{{$indexImageItem}}][is_required]"
            id="br_{{$getInc}}">
        <label class="form-check-label" for="br_{{$getInc}}">
            Is required <span class="text-danger fs-11">(Yes/No)</span>
        </label>
    </div>

    {{-- <div class="col-sm-2 mt-5">
        <input
            class="form-check-input bCheck"
            data-id="{{$indexImageItem}}"
            type="checkbox" value="1"
            name="booths[detail][{{$indexImageItem}}][is_question]"
            id="bq_{{$getInc}}">
        <label class="form-check-label" for="bq_{{$getInc}}">
            Is question <span class="text-danger fs-11">(Yes/No)</span>
        </label>
    </div> --}}

    {{-- <div id="b-{{$indexImageItem}}" class="d-none">
        <div class="row mt-1">
            <div class="col-sm-12">
                <label class="form-check-label">Question</label>
                <input
                    type="text"
                    class="form-control"
                    id="booths[detail][{{$indexImageItem}}][question]"
                    name="booths[detail][{{$indexImageItem}}][question]"
                    placeholder=""
                    value="">
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-4">
                <label class="form-check-label">Answer 1</label>
                <input
                    type="text"
                    class="form-control"
                    id="booths[detail][{{$indexImageItem}}][a1]"
                    name="booths[detail][{{$indexImageItem}}][a1]"
                    placeholder=""
                    value="">
            </div>
            <div class="col-sm-2 mt-4">
                <input
                    class="form-check-input"
                    data-id="{{$indexImageItem}}"
                    type="checkbox" value="1"
                    name="booths[detail][{{$indexImageItem}}][is_a1]"
                    id="bis_a1_{{$getInc}}">
                <label class="form-check-label" for="bis_a1_{{$getInc}}">
                    Yes/No
                </label>
            </div>
            <div class="col-sm-4">
                <label class="form-check-label">Answer 2</label>
                <input
                    type="text"
                    class="form-control"
                    id="booths[detail][{{$indexImageItem}}][a2]"
                    name="booths[detail][{{$indexImageItem}}][a2]"
                    placeholder=""
                    value="">
            </div>
            <div class="col-sm-2 mt-4">
                <input
                    class="form-check-input"
                    data-id="{{$indexImageItem}}"
                    type="checkbox" value="1"
                    name="booths[detail][{{$indexImageItem}}][is_a2]"
                    id="bis_a2_{{$getInc}}">
                <label class="form-check-label" for="bis_a2_{{$getInc}}">
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
                    name="booths[detail][{{$indexImageItem}}][a3]"
                    placeholder="Answer"
                    value="">
            </div>
            <div class="col-sm-2 mt-4">
                <input
                    class="form-check-input"
                    data-id="{{$indexImageItem}}"
                    type="checkbox" value="1"
                    name="booths[detail][{{$indexImageItem}}][is_a3]"
                    id="bis_a3_{{$getInc}}">
                <label class="form-check-label" for="bis_a3_{{$getInc}}">
                    Yes/No
                </label>
            </div>
            <div class="col-sm-4">
                <label class="form-check-label">Answer 4</label>
                <input
                    type="text"
                    class="form-control"
                    id="booths[detail][{{$indexImageItem}}][a4]"
                    name="booths[detail][{{$indexImageItem}}][a4]"
                    placeholder="Answer"
                    value="">
            </div>
            <div class="col-sm-2 mt-4">
                <input
                    class="form-check-input checkQ"
                    data-id="{{$indexImageItem}}"
                    type="checkbox" value="1"
                    name="booths[detail][{{$indexImageItem}}][is_a4]"
                    id="bis_a4_{{$getInc}}">
                <label class="form-check-label" for="bis_a4_{{$getInc}}">
                    Yes/No
                </label>
            </div>
        </div>
    </div> --}}

    <div class="col-sm-12 text-right">
        <label class="col-form-label">&nbsp;</label>
        <div class="col-auto">
            <button type="button" data-id="{{$indexImageItem}}" class="btn btn-danger mb-3 bRemove">Remove</button>
        </div>
    </div>
</div>
