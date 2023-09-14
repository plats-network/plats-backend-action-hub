<div id="infoUser" class="modal fade" data-backdrop="static" data-keyboard="false">
        <style type="text/css">
            .text-danger, .error {
                color: red;
            }

            .btn--order {
                padding: 10px 30px;
                background: #3EA2FF;
                color: #fff;
                text-align: right;
            }
        </style>

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="font-size: 25px; text-align: center;">Cập nhật thông tin</h5>
                    {{-- <button type="button" class="close" data-dismiss="modal">&times;</button> --}}
                </div>
                <div class="modal-body">
                    <form id="infoForm" method="POST" action="{{route('web.editEmail')}}">
                        @csrf
                        <input type="hidden" name="task_id" value="{{$task_id}}">
                        <input type="hidden" name="user_type" value="2">
                        <div class="row" style="display: block;">
                            <div class="col-md-12">
                                <label class="form-label">Name <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="name"
                                    value="{{$user ? $user->name : ''}}"
                                    maxlenght="50"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    value="{{$user ? $user->email : ''}}"
                                    name="email"
                                    required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6" style="padding-left: 0;">
                                <label class="form-label" style="margin-top: 10px;">Phone <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    id="phone"
                                    class="form-control"
                                    value="{{$user ? $user->phone : ''}}"
                                    name="phone"
                                    maxlength="12"
                                    required>
                            </div>
                            <div class="col-6" style="padding-right: 0;">
                                <label class="form-label">Tuổi <span class="text-danger">*</span></label>
                                <input
                                    type="number"
                                    class="form-control"
                                    min="10"
                                    max="100"
                                    maxlenght="2"
                                    name="age"
                                    value="{{$user ? $user->age : ''}}"
                                    id="age"
                                    required>
                            </div>
                        </div>

                        <div class="row" style="display: block;">
                            <div class="col-md-12">
                                <label class="form-label">Vị trí <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="position"
                                    id="position"
                                    value="{{$user ? $user->position : ''}}"
                                    maxlenght="100"
                                    required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Cơ quan/Trường học <span class="text-danger">*</span></label>
                                <input
                                    type="text"
                                    class="form-control"
                                    name="organization"
                                    id="organization"
                                    value="{{$user ? $user->organization : ''}}"
                                    maxlenght="100"
                                    required>
                            </div>
                        </div>
                        
                        <div class="text-center" style="margin-top: 20px;">
                            <button type="submit" class="btn btn-primary btn--order">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>