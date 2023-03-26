<template>
    <el-row>
        <el-row class="mb-1">
            <h4>Events management</h4>
            <el-button style="float: right;margin: 5px"
                       type="primary"
                       @click="handleCreate()">
                <i class="el-icon-plus"></i> Event Reward
            </el-button>
            <el-descriptions title="" :column="3" border>
                <el-descriptions-item label="Name" label-class-name="my-label" content-class-name="my-content">
                    <el-col :span="23">
                        <el-input placeholder="typing ..." v-model="formSearch.name" @change="list_data()"></el-input>
                    </el-col>
                </el-descriptions-item>
                <el-descriptions-item label="Description" label-class-name="my-label" content-class-name="my-content">
                    <el-col :span="23">
                        <el-input placeholder="typing ..." v-model="formSearch.desc_vn" @change="list_data()"></el-input>
                    </el-col>
                </el-descriptions-item>
            </el-descriptions>
        </el-row>
        <el-row>
            <el-table
                :data="tableData"
                style="width: 100%">
                <el-table-column type="index" width="50"></el-table-column>
                <el-table-column
                    label="Image"
                    width="180">
                    <template slot-scope="scope">
                        <div class="demo-image__preview">
                            <el-image
                                :src="scope.row.banner_url"
                                :preview-src-list="[scope.row.banner_url]"
                                style="width: 50%"
                            >
                            </el-image>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column
                    prop="name"
                    label="Name"
                   >
                </el-table-column>
                <el-table-column
                    label="Thời gian" width="180"
                >
                    <template slot-scope="scope">
                        <el-tag type="info" v-if="new Date(scope.row.end_at) < new Date()" effect="dark">
                            Hết Hạn
                        </el-tag>
                        <el-tag type="danger" v-else effect="dark">
                            Còn Hạn
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column  width="180"
                    label="Status">
                    <template slot-scope="scope">
                        <el-switch
                            v-model="scope.row.status"
                            :active-value="1"
                            @change="changeStatus(scope.row.status,scope.row.id)"
                            :inactive-value="0"
                            active-text="public"
                            inactive-text="draft"
                        >
                        </el-switch>
                    </template>
                </el-table-column>
                <el-table-column
                    label="Actions">
                    <template slot-scope="scope">
                        <el-tooltip class="item" effect="dark" content="Chỉnh sửa" placement="top">
                            <el-button
                                size="mini"
                                type="primary"
                                @click="handleEdit(scope.$index, scope.row)">
                                <i class="el-icon-edit"></i>
                            </el-button>
                        </el-tooltip>
                        <el-tooltip class="item" effect="dark" content="Lấy mã QR" placement="top">
                        <el-button
                            size="mini" type="warning"
                            @click="handleQrCode(scope.$index, scope.row)">
                            <i class="el-icon-view"></i>
                        </el-button>
                        </el-tooltip>
                        <el-tooltip class="item" v-if="scope.row.task_generate_links.length != 0" effect="dark" content="Link Share" placement="top">
                        <el-button
                            size="mini"
                            type="success"
                            @click="handleLink(scope.$index, scope.row)">
                            <i class="el-icon-paperclip"></i>
                        </el-button>
                        </el-tooltip>
                        <el-tooltip v-if="scope.row.user_get_tickets.length != 0" class="item" effect="dark" content="Danh sách tham gia event" placement="top">
                                <el-button
                                    size="mini" plain  type="success"
                                    @click="handleJoinEvent(scope.$index, scope.row)">
                                    {{ scope.row.user_get_tickets.length}}&nbsp;<i class="el-icon-s-custom"></i>
                                </el-button>
                        </el-tooltip>
<!--                            <el-tooltip class="item" effect="dark" content="Lấy mã QR" placement="top">-->
<!--                        <el-button-->
<!--                            size="mini"-->
<!--                            type="danger"-->
<!--                            @click="handleDelete(scope.$index, scope.row)">-->
<!--                            <i class="el-icon-lock"></i>-->
<!--                        </el-button>-->
<!--                            </el-tooltip>-->
                    </template>
                </el-table-column>
            </el-table>
            <el-pagination
                background
                @size-change="handleSizeChange"
                @current-change="handleCurrentChange"
                :page-size="20"
                :current-page.sync="currentPage"
                layout="prev, pager, next"
                :total="this.totalNumber"
                class="float-right mt-3 text-center"
            >
            </el-pagination>

            <!-- Edit Events -->
            <el-drawer title="Edit events" size="50%" :visible.sync="drawerEdit">
                <el-form ref="form" class="form-style formCreate" :rules="rules" label-position="top" :model="form" label-width="100px" >
                    <el-row :gutter="20">
                        <el-col :span="16">
                            <el-form-item label="Name">
                                <el-input v-model="form.name" placeholder="Name"></el-input>
                            </el-form-item>
                            <el-form-item label="Address">
                                <el-input v-model="form.address" placeholder="Name"></el-input>
                            </el-form-item>
                            <div class="row">
                                <div class="col-md-6">
                                    <el-form-item label="Lat">
                                        <el-input v-model="form.lat" placeholder="Name"></el-input>
                                    </el-form-item></div>
                                <div class="col-md-6">
                                    <el-form-item label="Lng">
                                        <el-input v-model="form.lng" placeholder="Name"></el-input>
                                    </el-form-item>
                                </div>
                            </div>
                            <el-form-item label="Description" prop="Description">
                                <ckeditor v-model="form.description"  ></ckeditor>
                            </el-form-item>
                            <el-form-item label="Address">
                                <el-input v-model="form.address" placeholder="Address"></el-input>
                            </el-form-item>
                            <div class="d-flex">
                                <el-form-item label="Order">
                                    <el-input v-model="form.order" placeholder="Order" style="margin-right: 20px"></el-input>
                                </el-form-item>
                                <el-form-item label="Latitude" style="margin-right: 20px">
                                    <el-input v-model="form.lat" placeholder="0.000000"></el-input>
                                </el-form-item>
                                <el-form-item label="Longitude">
                                    <el-input v-model="form.lng" placeholder="0.000000"></el-input>
                                </el-form-item>
                            </div>
                            <div class="d-flex">
                                <el-form-item label="Start At" style="margin-right: 20px">
                                    <el-date-picker type="datetime" placeholder="Select date and time" v-model="form.start_at"></el-date-picker>
                                </el-form-item>
                                <el-form-item label="End At">
                                    <el-date-picker type="datetime" placeholder="Select date and time" v-model="form.end_at"></el-date-picker>
                                </el-form-item>
                            </div>
                            <div class="d-flex mt-4">
                                <el-button  @click="addSessions()">Sessions</el-button>
                                <el-button  @click="addBooths()">Booths</el-button>
                                <el-button @click="addSocial()">Social</el-button>
                                <el-button @click="dialogQuiz = true">Quiz</el-button>
                            </div>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item label="Image">
                                <el-upload
                                    class="avatar-uploader text-center"
                                    :headers="{ 'X-CSRF-TOKEN': csrf }"
                                    action="https://cws.plats.network/tasks/save-avatar-api"
                                    :on-success="handleAvatarSuccess"
                                    :before-upload="beforeAvatarUpload">
                                    <img v-if="form.banner_url" :src="form.banner_url" class="avatar">
                                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                            </el-form-item>
                            <el-form-item label="Slider">
                                <el-upload
                                    :headers="{ 'X-CSRF-TOKEN': csrf }"
                                    action="https://cws.plats.network/tasks/save-sliders-api"
                                    list-type="picture-card"
                                    :on-success="handleSuccess"
                                    :file-list="form.task_galleries"
                                    :on-remove="handleRemove">
                                    <i class="el-icon-plus"></i>
                                </el-upload>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-form-item class="mt-5">
                        <el-button type="primary" @click="submitForm('form')">Edit</el-button>
                        <el-button @click="drawerEdit = false">Cancel</el-button>
                    </el-form-item>
                </el-form>
            </el-drawer>

            <!-- Create Event -->
            <el-drawer title="Create events" size="50%" :visible.sync="drawerCreate">
                <el-form ref="form" class="form-style formCreate" :rules="rules" label-position="top" :model="form" label-width="100px" >
                    <el-row :gutter="20">
                        <el-col :span="16">
                            <el-form-item label="Name">
                                <el-input v-model="form.name" placeholder="Name"></el-input>
                            </el-form-item>
                            <el-form-item label="Address">
                                <el-input v-model="form.address" placeholder="Name"></el-input>
                            </el-form-item>
                            <div class="row">
                                <div class="col-md-6">
                                    <el-form-item label="Lat">
                                    <el-input v-model="form.lat" placeholder="Name"></el-input>
                                </el-form-item></div>
                                <div class="col-md-6">
                                    <el-form-item label="Lng">
                                        <el-input v-model="form.lng" placeholder="Name"></el-input>
                                    </el-form-item>
                                </div>
                            </div>
                            <el-form-item label="Description" prop="Description">
                                <ckeditor v-model="form.description" ></ckeditor>
                            </el-form-item>
                            <div class="d-flex">
                                <el-form-item label="Order">
                                    <el-input v-model="form.order" placeholder="Order" style="margin-right: 20px"></el-input>
                                </el-form-item>
                            </div>
                            <div class="d-flex">
                                <el-form-item label="Start At" style="margin-right: 20px">
                                    <el-date-picker
                                      type="datetime" :picker-options="pickerOptions"
                                      placeholder="Select date and time"
                                      v-model="form.start_at"
                                      :min-date="new Date()"></el-date-picker>
                                </el-form-item>
                                <el-form-item label="End At">
                                    <el-date-picker
                                      type="datetime" :picker-options="pickerOptions"
                                      placeholder="Select date and time"
                                      v-model="form.end_at"></el-date-picker>
                                </el-form-item>
                            </div>
                            <div class="d-flex mt-4">
                                <el-button @click="addSessions()">Sessions</el-button>
                                <el-button @click="addBooths()">Booths</el-button>
                                <el-button @click="addSocial()">Social</el-button>
                                <el-button @click="dialogQuiz = true">Quiz</el-button>
                            </div>
                        </el-col>
                        <el-col :span="8">
                            <el-form-item label="Image">
                                <el-upload
                                    class="avatar-uploader"
                                    :headers="{ 'X-CSRF-TOKEN': csrf }"
                                    action="https://cws.plats.network/tasks/save-avatar-api"
                                    :on-success="handleAvatarSuccess"
                                    :before-upload="beforeAvatarUpload">
                                    <img v-if="form.banner_url" :src="form.banner_url" class="avatar">
                                    <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                                </el-upload>
                            </el-form-item>
                            <el-form-item label="Slider">
                                <el-upload
                                    :headers="{ 'X-CSRF-TOKEN': csrf }"
                                    action="https://cws.plats.network/tasks/save-sliders-api"
                                    list-type="picture-card"
                                    :on-success="handleSuccess"
                                    :file-list="form.task_galleries"
                                    :on-remove="handleRemove">
                                    <i class="el-icon-plus"></i>
                                </el-upload>
                            </el-form-item>
                        </el-col>
                    </el-row>
                    <el-form-item class="mt-5">
                        <el-button type="primary" @click="submitForm('form')">Save</el-button>
                        <el-button @click="drawerCreate = false">Cancel</el-button>
                    </el-form-item>
                </el-form>
            </el-drawer>

            <!-- Sessions -->
            <el-drawer title="Sessions" size="50%" :visible.sync="dialogSessions" style="height: auto">
                <el-row :gutter="20" class="p-5">
                    <el-col :span="18">
                        <div class="d-flex mb-2">
                            <el-input v-model="form.sessions.name" placeholder="Name"></el-input>
                            <el-input v-model="form.sessions.max_job" style="width: 40%; margin-left: 20px;" placeholder="Number success"></el-input>
                        </div>
                        <ckeditor v-model="form.sessions.description" ></ckeditor>
                    </el-col>
                    <el-col :span="6">
                        <el-upload
                            class="avatar-uploader text-center"
                            :headers="{ 'X-CSRF-TOKEN': csrf }"
                            action="https://cws.plats.network/tasks/save-avatar-api"
                            :on-success="handleAvatarSuccess1"
                            :before-upload="beforeAvatarUpload">
                            <img v-if="form.sessions.banner_url" :src="form.sessions.banner_url" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-col>

                    <!-- Add session -->
                    <el-col :span="24">
                        <div v-for="(details, index) in  form.sessions.detail" class="mb-3 mt-3">
                            <el-row :gutter="20" >
                                <el-col :span="4"><div style="margin: 10px 0 0 0px">Session {{index+1}}</div></el-col>
                                <el-col :span="18" class="mb-2 d-flex">
                                    <el-input v-model="details.name" placeholder="Name" style="width: 70%; margin-right: 10px;"></el-input>
                                    <el-input v-model="details.description" style="margin-left: 20px;" placeholder="Description"></el-input>
                                </el-col>
                                <el-col :span="2">
                                  <el-button size="mini" type="danger" style="margin-top: 5px" @click.prevent="removeSessions(details)"><i
                                    class="el-icon-delete"></i></el-button>
                                  </el-col>
                            </el-row>
                        </div>
                        <div style="float: right;">
                            <el-button size="mini" type="success" @click="dialogSessions = false" class="mt-3 mb-2">Done</el-button>
                            <el-button size="mini" type="primary" class="mt-3 mb-2" @click="addDetailSessions"><i class="el-icon-plus"></i>Add Detail</el-button>
                        </div>
                    </el-col>
                </el-row>
            </el-drawer>

            <!-- Booths -->
            <el-drawer title="Booths" size="50%" :visible.sync="dialogBooths" style="height: auto">
                <el-row :gutter="20" class="p-5">
                    <el-col :span="18">
                        <div class="d-flex mb-2">
                            <el-input v-model="form.booths.name" placeholder="Name"></el-input>
                            <el-input v-model="form.booths.max_job" style="width: 40%; margin-left: 20px;" placeholder="Sl Hoàn thành"></el-input>
                        </div>
                        <ckeditor v-model="form.booths.description" ></ckeditor>
                    </el-col>
                    <el-col :span="6">
                        <el-upload
                            class="avatar-uploader text-center"
                            :headers="{ 'X-CSRF-TOKEN': csrf }"
                            action="https://cws.plats.network/tasks/save-avatar-api"
                            :on-success="handleAvatarSuccess2"
                            :before-upload="beforeAvatarUpload">
                            <img v-if="form.booths.banner_url" :src="form.booths.banner_url" class="avatar">
                            <i v-else class="el-icon-plus avatar-uploader-icon"></i>
                        </el-upload>
                    </el-col>
                    <el-col :span="24">
                        <div v-for="(details, index) in  form.booths.detail" class="mb-3 mt-3">
                            <el-row :gutter="20" >
                                <el-col :span="4"><div style="margin: 10px 0 0 0px">Booth {{index+1}}</div></el-col>
                                <el-col :span="18" class="mb-2 d-flex" >
                                    <el-input v-model="details.name" placeholder="Name" style="width: 70%"></el-input>
                                    <el-input v-model="details.description" style="margin-left: 20px;" placeholder="Description"></el-input>
                                </el-col>
                                <el-col :span="2">
                                  <el-button size="mini" type="danger" style="margin-top: 5px" @click.prevent="removeBooths(details)">
                                    <i class="el-icon-delete"></i>
                                  </el-button>
                                </el-col>
                            </el-row>
                        </div>
                        <div style="float: right;">
                            <el-button size="mini" type="success" @click="dialogBooths = false" class="mt-3 mb-2">Done</el-button>
                            <el-button size="mini" type="primary" style="float: right" class="mt-3 mb-2" @click="addDetailBooths"><i class="el-icon-plus"></i>Add Detail</el-button>
                        </div>
                    </el-col>
                </el-row>
            </el-drawer>

            <!-- Qrcode view -->
            <el-dialog  title="Link QrCode" :visible.sync="dialogQrCode" style="height: auto">
                <el-tabs v-model="activeName" @tab-click="handleClickTab">
                    <el-tab-pane label="Sessions" name="first">
                        <el-table border
                                  :data="dataSessions"
                                  style="width: 100%">
                            <el-table-column
                                type="index"
                                width="50">
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="Name"
                            >
                            </el-table-column>
                            <el-table-column
                                label="QRCODE"
                            >
                                <template slot-scope="scope">
                                    <div ref="qrcode">
                                    <qrcode-vue :id="scope.row.id" :value="'https://event.plats.network/events/code?type=event&id='+scope.row.code" :size="size" level="H"></qrcode-vue>
                                    </div>
                                    <button @click="downloadQrCode(scope.row.id)">Download</button>
                                </template>
                            </el-table-column>
                            <el-table-column label="Status" width="180">
                                <template slot-scope="scope">
                                    <el-switch
                                        v-model="scope.row.status"
                                        :active-value="true"
                                        @change="changeStatusDetail(scope.row.status,scope.row.id)"
                                        :inactive-value="false"
                                        active-text="UnLock"
                                        inactive-text="Lock"
                                    >
                                    </el-switch>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-tab-pane>
                    <el-tab-pane label="Booths" name="second">
                        <el-table border
                                  :data="dataBooths"
                                  style="width: 100%">
                            <el-table-column
                                type="index"
                                width="50">
                            </el-table-column>
                            <el-table-column
                                prop="name"
                                label="Name"
                            >
                            </el-table-column>
                            <el-table-column
                                label="QRCODE"
                            >
                                <template slot-scope="scope">
                                    <div ref="qrcode">
                                        <qrcode-vue :id="scope.row.id" :value="'https://event.plats.network/events/code?type=event&id='+scope.row.code" :size="size" level="H"></qrcode-vue>
                                    </div>
                                    <button @click="downloadQrCode(scope.row.id)">Download</button>
                                </template>
                            </el-table-column>
                            <el-table-column label="Status" width="180">
                                <template slot-scope="scope">
                                    <el-switch
                                        v-model="scope.row.status"
                                        :active-value="true"
                                        @change="changeStatusDetail(scope.row.status,scope.row.id)"
                                        :inactive-value="false"
                                        active-text="UnLock"
                                        inactive-text="Lock"
                                    >
                                    </el-switch>
                                </template>
                            </el-table-column>
                        </el-table>
                    </el-tab-pane>
                </el-tabs>
            </el-dialog>
<!--            social-->
            <el-drawer title="Social" size="50%" :visible.sync="dialogSocial" style="height: auto">
                <el-row :gutter="20" class="p-5">
                   <el-col >
                       <el-checkbox  v-model="form.task_event_socials.is_comment">Comment</el-checkbox>
                       <el-checkbox v-model="form.task_event_socials.is_like">Like</el-checkbox>
                       <el-checkbox v-model="form.task_event_socials.is_retweet">Retweet</el-checkbox>
                       <el-checkbox v-model="form.task_event_socials.is_tweet">Tweet</el-checkbox>
                   </el-col>
                    <el-col >
                        <div v-if="form.task_event_socials.is_comment == true || form.task_event_socials.is_like == true || form.task_event_socials.is_retweet == true">
                            <span> URL</span>
                            <el-input class="mb-2 mt-2" maxlength="255" show-word-limit  placeholder="https://twitter.com/elonmusk/status/1638381090368012289" v-model="form.task_event_socials.url"></el-input>
                        </div>
                        <div v-if="form.task_event_socials.is_tweet == true">
                            <span> Text</span>
                            <el-input class="mb-2 mt-2" maxlength="255" show-word-limit  placeholder="Text ..." v-model="form.task_event_socials.text"></el-input>
                        </div>
                    </el-col>
                    <div style="float: right;">
                        <el-button size="mini" type="primary" style="float: right" class="mt-3 mb-2" @click="dialogSocial = false"><i class="el-icon-plus"></i>Add Social</el-button>
                    </div>
                </el-row>
            </el-drawer>
            <!--            quiz-->
            <el-drawer title="Quiz" size="50%" :visible.sync="dialogQuiz">
                <div class="p-3">
                    <el-form ref="formQuiz"  label-position="top">
                        <div>
                            <el-col :span="24">
                                <div v-for="(details, index) in  this.quiz" class="mb-3 mt-3">
                                    <el-row :gutter="20" >
                                        <div class="d-flex justify-content-between mb-2">
                                            <el-form-item :label="'Question '+ (index+1)" :label-width="formLabelWidth" style="width: 65%;">
                                                <el-input v-model="details.name" ></el-input>
                                            </el-form-item>
                                            <el-form-item label="Time" :label-width="formLabelWidth" style="width: 15%;">
                                                <el-input v-model="details.time_quiz" ></el-input>
                                            </el-form-item>
                                            <el-form-item label="Order" prop="order" :label-width="formLabelWidth" style="width: 5%;">
                                                <el-input v-model="details.order" ></el-input>
                                            </el-form-item>
                                            <el-form-item label="Status" prop="status" :label-width="formLabelWidth" style="width: 10%;">
                                                <el-switch v-model="details.status">
                                                </el-switch>
                                            </el-form-item>
                                        </div>
                                        <div v-for="(answer, index) in  details.detail"
                                             class="mb-3 mt-3 " style="margin-left: 40px;margin-right: 40px">
                                            <div class="d-flex justify-content-between mb-2">
                                                <div>Answer {{index+1}}</div>
                                                <el-input v-model="answer.name"  style="width: 80%;"></el-input>
                                                <el-checkbox @change="clickAnswer(answer,details.detail)" v-model="answer.status">Option</el-checkbox>
                                            </div>
                                        </div>
                                        <div><el-button size="mini" type="danger" style="margin-top: 5px" @click.prevent="removeQuiz(details)">
                                            <i class="el-icon-delete"></i>
                                        </el-button></div>
                                    </el-row>
                                </div>
                                <div style="float: right;">
                                    <el-button size="mini" type="primary" class="mt-3 mb-2" @click="addQuiz"><i class="el-icon-plus"></i>Add Detail</el-button>
                                </div>
                            </el-col>
                        </div>
                    </el-form>
                    <span slot="footer" class="dialog-footer">
                        <el-button type="primary" @click="submitQuiz()">Add Quiz</el-button>
                    </span>
                </div>
            </el-drawer>
<!--            link share-->
            <el-dialog title="Link Share" :visible.sync="dialogLinks">
                <el-table :data="dataLink">
                    <el-table-column property="name" label="Name" width="200"></el-table-column>
                    <el-table-column property="url" label="Url" ></el-table-column>
                </el-table>
            </el-dialog>
        </el-row>
    </el-row>
</template>

<script>
import { ref } from 'vue'
import 'element-tiptap/lib/index.css';
import {Notification} from 'element-ui';
import {ElementTiptap} from 'element-tiptap';
import QrcodeVue from 'qrcode.vue'
import {
    Doc,
    Text,
    Paragraph,
    Heading,
    Bold,
    Underline,
    Italic,
    Strike,
    ListItem,
    BulletList,
    OrderedList,
    Image,
    TodoList,
    TodoItem,
    Iframe,
    Table,
    TableHeader,
    TableRow,
    TableCell,
    TextAlign,
    LineHeight,
    Indent,
    HorizontalRule,
    HardBreak,
    TrailingNode,
    History,
    TextColor,
    TextHighlight,
    FormatClear,
    FontType,
    FontSize,
    Preview,
    CodeView,
    Print,
    Fullscreen,
    SelectAll,
} from 'element-tiptap';

export default {
    name: "index",
    props: ['csrf', 'link_qrc'],
    components: {
        'el-tiptap': ElementTiptap,
        QrcodeVue,
    },
    data() {
        return {
            pickerOptions: {
                disabledDate(time) {
                    return time.getTime() < Date.now();
                },
            },
            dataLink: [],
            ruleQuiz:{
                name: [{
                    required: true,
                    message: 'Please input name',
                    trigger: ['blur', 'change']
                }],
                time_quiz: [{
                    required: true,
                    message: 'Please input name',
                    trigger: ['blur', 'change']
                }],

            },
            quiz :[
                    {
                        name: '',
                        time_quiz: '',
                        order: '',
                        status: true,
                        detail:[
                            {
                                key:0,
                                name:'',
                                status:true
                            },
                            {
                                key:1,
                                name:'',
                                status:false
                            },
                            {
                                key:2,
                                name:'',
                                status:false
                            },
                            {
                                key:3,
                                name:'',
                                status:false
                            }
                        ]
                    }
                ],
            formLabelWidth: '120px',
            activeName: 'first',
            size: 120,
            image: '',
            dialogSessions: false,
            dialogQuiz: false,
            dialogBooths: false,
            dialogSocial: false,
            dialogQrCode: false,
            dialogJoinEvent: false,
            dialogLinks : false,
            currentPage: 1,
            totalNumber: 0,
            page: 1,
            formSearch: {
                name: '',
            },
            tableData: [],
            drawerEdit : false,
            drawerCreate : false,
            rules: {
                banner_url: [{
                    required: true,
                    message: 'Hãy upload ảnh',
                    trigger: ['change']
                }],
                name: [{
                    required: true,
                    message: 'Please input name',
                    trigger: ['blur', 'change']
                }]
            },
            dataSessions:[
                {
                    id:'',
                    name:'',
                    description:'',
                    status:true,
                }
            ],
            dataBooths:[
                {
                    id:'',
                    name:'',
                    description:'',
                    status:'',
                }
            ],
            form : {
                id : '',
                banner_url : '',
                name : '',
                lat : '',
                lng : '',
                address : '',
                description : '',
                start_at : '',
                end_at : '',
                type : 1,
                order : '',
                task_galleries: [],
                sessions: {
                    name:'',
                    max_job:'',
                    banner_url:'',
                    description:'',
                    type:'',
                    detail:[
                        {
                            name: '',
                            description: ''
                        }
                    ]
                },
                booths: {
                        name:'',
                        max_job:'',
                        banner_url:'',
                        description:'',
                        type:'',
                        detail:[
                            {
                                name: '',
                                description: ''
                            }
                        ]
                },
                task_event_socials:{
                    url:'',
                    text:'',
                    is_comment:false,
                    is_like:false,
                    is_retweet:false,
                    is_tweet:false,
                    type:0,
                }
            },
        }
    },
    methods: {
        changeStatusDetail(status,id){
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            let rawData =
                {
                    'status': status,
                    'id': id,
                }
            axios.post('/api/cws/events/change-status-detail', rawData).then(e => {
                Notification.success({
                    title: ' Thành công',
                    message: ' Thành công',
                    type: 'success',
                });
                this.list_data()
                loading.close();
            }).catch(error => {
                this.errors = error.response.data.message; // this should be errors.
                Notification.error({
                    title: 'Error',
                    message: this.errors,
                    type: 'error',
                });

                loading.close();
            });
        },
        handleJoinEvent(scope, row){
            window.location.href = "/events/"+row.id;
        },
        handleLink(scope, row) {
            this.dataLink = row.task_generate_links;
            this.dialogLinks = true
        },
        clickAnswer(item,items){
            for (let i = 0; i < items.length; i++) {
                const el = items[i];
                if (el.key === item.key) {
                    el.status = true;
                } else {
                    el.status = false;
                }
            }
        },
        addQuiz(){
            this.quiz.push({
                name: '',
                time_quiz: '',
                order: '',
                status: true,
                detail:[
                    {
                        key:0,
                        name:'',
                        status:true
                    },
                    {
                        key:1,
                        name:'',
                        status:false
                    },
                    {
                        key:2,
                        name:'',
                        status:false
                    },
                    {
                        key:3,
                        name:'',
                        status:false
                    }
                ]
            });
        },
        submitQuiz(){
            this.form.quiz = this.quiz
            this.dialogQuiz = false
        },
        removeQuiz(item){
            let index = this.quiz.indexOf(item);
            if (index !== -1) {
                this.quiz.splice(index, 1);
            }
        },
        downloadQrCode(id){
            let canvasImage = document.getElementById(id).querySelector('canvas').toDataURL('image/png');
            // this can be used to download any image from webpage to local disk
            let xhr = new XMLHttpRequest();
            xhr.responseType = 'blob';
            xhr.onload = function () {
                let a = document.createElement('a');
                a.href = window.URL.createObjectURL(xhr.response);
                a.download = 'qrc'+id+'.png';
                a.style.display = 'none';
                document.body.appendChild(a);
                a.click();
                a.remove();
            };
            xhr.open('GET', canvasImage); // This is to download the canvas Image
            xhr.send();
        },
        handleClickTab(tab, event) {
            console.log(tab, event);
        },
        handleQrCode(scope, row){
            this.dialogQrCode = true
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            let url = '/api/tasks-cws/edit/'+ row.id;
            axios.get(url).then(e => {
                this.dataBooths = e.data.data.message.booths.detail;
                this.dataSessions = e.data.data.message.sessions.detail;
                loading.close();

            }).catch((_) => {
                loading.close();
            })
        },
        removeSessions(item){
            let index = this.form.sessions.detail.indexOf(item);
            if (index !== -1) {
                this.form.sessions.detail.splice(index, 1);
            }
        },
        removeBooths(item){
            let index = this.form.booths.detail.indexOf(item);
            if (index !== -1) {
                this.form.booths.detail.splice(index, 1);
            }
        },
        addDetailSessions(){
            this.form.sessions.detail.push({
                name: '',
                description: '',
            });
        },
        addDetailBooths(){
            this.form.booths.detail.push({
                name: '',
                description: '',
            });
        },
        addSessions(){
            this.dialogSessions = true
        },
        addBooths(){
            this.dialogBooths = true
        },
        addSocial(){
            this.dialogSocial = true
        },
        handleRemove(file, fileList) {
            this.form.task_galleries = fileList
        },
        handlePreview(file) {
            console.log(file);
        },
        handleSuccess( file,fileList) {
            this.form.task_galleries.push(
                file
            )

        },
        handleSizeChange(val) {
            this.list_data(val, false);
        },
        handleCurrentChange(val) {
            this.list_data(val);
        },
        handleAvatarSuccess(res, file) {
            this.form.banner_url = URL.createObjectURL(file.raw);
            this.form.banner_url = res;
        },
        handleAvatarSuccess1(res, file) {
            this.form.sessions.banner_url = URL.createObjectURL(file.raw);
            this.form.sessions.banner_url = res;
        },
        handleAvatarSuccess2(res, file) {
            this.form.booths.banner_url = URL.createObjectURL(file.raw);
            this.form.booths.banner_url = res;
        },
        beforeAvatarUpload(file) {
            const isJPEG = file.type === 'image/jpeg';
            const isPNG = file.type === 'image/png';
            const isJPG = file.type === 'image/jpg';

            const isLt10M = file.size / 1024 / 1024 < 10;

            if (!isJPEG && !isPNG && !isJPG) {
                this.$message.error('Chọn ảnh định dạng JPG,PNG,JPEG!');
                return false
            }
            if (!isLt10M) {
                this.$message.error('Avatar picture size can not exceed 2MB!')
                return false
            }
            return isLt10M;
        },
        handleCreate() {
            this.form = {
                banner_url : '',
                name : '',
                lat : '',
                lng : '',
                address : '',
                description : '',
                start_at : '',
                end_at : '',
                order : '',
                type : 1,
                task_galleries: [],
                sessions: {
                    name:'',
                    max_job:'',
                    banner_url:'',
                    description:'',
                    type:0,
                    detail:[
                        {
                            name: '',
                            description: ''
                        }
                    ]
                },
                booths: {
                    name:'',
                    max_job:'',
                    banner_url:'',
                    description:'',
                    type:1,
                    detail:[
                        {
                            name: '',
                            description: ''
                        }
                    ]
                },
                task_event_socials: {
                    url:'',
                    text:'',
                    is_comment:false,
                    is_like:false,
                    is_retweet:false,
                    is_tweet:false,
                    type:0,
                }
            }

            this.quiz =[
                {
                    name: '',
                    time_quiz: '',
                    order: '',
                    status: true,
                    detail:[
                        {
                            key:0,
                            name:'',
                            status:true
                        },
                        {
                            key:1,
                            name:'',
                            status:false
                        },
                        {
                            key:2,
                            name:'',
                            status:false
                        },
                        {
                            key:3,
                            name:'',
                            status:false
                        }
                    ]
                }
            ],
            this.drawerCreate = true
        },

        list_data(val = 1, type = true) {
            var self = this;
            let rawData =
                {
                    'name': this.formSearch.name,
                    'description': this.formSearch.description,
                    'status': this.formSearch.status
                }
            if (!type) {
                rawData['size'] = val;
            } else {
                this.page = val;
                rawData['page'] = val;
            }
            rawData['page'] = val;
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            let url = '/api/cws/events'
            axios.get(url, {
                params: rawData
            }).then(e => {
                this.tableData = e.data.data;
                this.totalNumber = e.data.meta.total;
                self.totalItem = e.data.meta.total;
                loading.close();

            }).catch((_) => {
                loading.close();
            })
        },
        changeStatus(status,id){
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            let rawData =
                {
                    'status': status,
                    'id': id,
                }
            axios.post('/api/cws/events/change-status', rawData).then(e => {
                Notification.success({
                    title: ' Thành công',
                    message: ' Thành công',
                    type: 'success',
                });
                this.list_data()
                loading.close();
            }).catch(error => {
                this.errors = error.response.data.message; // this should be errors.
                Notification.error({
                    title: 'Error',
                    message: this.errors,
                    type: 'error',
                });

                loading.close();
            });
        },
        submitForm(form){
            this.$refs[form].validate((valid) => {
                if (valid) {
                    const loading = this.$loading({
                        lock: true,
                        text: 'Loading',
                        spinner: 'el-icon-loading',
                        background: 'rgba(0, 0, 0, 0.7)'
                    });
                    if (this.form.task_event_socials.is_tweet == false){
                        this.form.task_event_socials.text = null
                    }
                    if (this.form.task_event_socials.is_like == false && this.form.task_event_socials.is_comment == false && this.form.task_event_socials.is_retweet == false ){
                        this.form.task_event_socials.url = null
                    }
                    axios.post('/api/cws/events', this.form).then(e => {
                        Notification.success({
                            title: ' Thành công',
                            message: ' Thành công',
                            type: 'success',
                        });
                        this.list_data()
                        loading.close();
                        this.drawerCreate = false
                        this.drawerEdit = false
                    }).catch(error => {
                        this.errors = error.response.data.message; // this should be errors.
                        Notification.error({
                            title: 'Error',
                            message: this.errors,
                            type: 'error',
                        });

                        loading.close();
                    });
                } else {
                    console.log('error submit!!');
                    return false;
                }
            });
        },
        handleEdit(scope, row) {
            this.form = row
            this.drawerEdit = true
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            let url = '/api/tasks-cws/edit/'+ row.id;
            axios.get(url).then(e => {
                this.form = e.data.data.message;
                this.quiz = e.data.data.message.quiz
                if (e.data.data.message.task_event_socials == null){
                    this.form.task_event_socials = {
                            url:'',
                            text:'',
                            is_comment:false,
                            is_like:false,
                            is_retweet:false,
                            is_tweet:false,
                            type:0,
                    }
                }
                loading.close();

            }).catch((_) => {
                loading.close();
            })
        },
        handleDelete(scope, row){
            this.$confirm('Bạn có muốn xóa không ?', 'Warning', {
                confirmButtonText: 'OK',
                cancelButtonText: 'Hủy',
                type: 'warning'
            }).then(() => {
                axios.delete('/api/cws/events/'+row.id, ).then(e => {
                    this.list_data()
                    Notification.success({
                        title: ' Thành công',
                        message: ' Block Thành công',
                        type: 'success',
                    });
                }).catch((_) => {
                })
            }).catch(() => {
            });
        },
    },
    mounted: function () {
        this.list_data()
    },
}
</script>

<style scoped>
    .form-style{
        padding: 10px;
        border: 1px solid #DCDFE6 ;
    }

    #el-drawer__title {
        margin-bottom: 0;
        background-color: #083777!important;
        color: #fff;

        span {
            color: #fff;
        }
    }

    .formCreate {
        padding: 20px 30px;
    }
</style>
