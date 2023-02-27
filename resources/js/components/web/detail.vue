<template>
    <div>
        <div class="demo-image">
            <div class="block">
                <el-image
                    style="width: 100%; height: auto ;border-radius: 20px"
                    :src="url"
                    fit="contain"></el-image>
            </div>
        </div>
        <div class="mt-3">
            <el-row :gutter="10">
                <el-col :xs="24" :sm="24" :md="16" :lg="16" :xl="16">
                    <div>
                        <span class="title-event-detail"> ĐÁNH THỨC SỰ GIÀU CÓ 55 - Hà Nội</span>
                    </div>
                    <div v-show='toggle'>
                        <div class="mt-3 mb-3">
                            <el-row :gutter="10">
                                <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                                    <div class="mb-2"><i class="el-icon-date" style="color: #409EFF"></i> Date and time
                                    </div>
                                    <div>
                                        <span class="d-block">Fri, Mar 3, 2023, 8:00 AM – Sun, Mar 5, 2023, 10:00 PM Indochina Time Vietnam Time</span>
                                    </div>
                                </el-col>
                                <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                                    <div class="mb-2"><i class="el-icon-location-information"
                                                         style="color: #409EFF"></i> Location
                                    </div>
                                    <div>Trung tâm Tiệc cưới Louis Palace (đối diện Công viên Thiên Đường Bảo Sơn) Trung
                                        tâm Tiệc cưới Louis Palace (Km 5+200 Lê Trọng Tấn kéo dài), An Khánh, Hoài Đức,
                                        Hà Nội Hà Nội Hanoi, Hanoi 100000
                                    </div>
                                </el-col>
                            </el-row>
                        </div>
                        <div class="mb-3">
                            <gmap-map
                                :zoom="14"
                                :center="center"
                                style="width:100%;  height: 300px;"
                            >
                                <gmap-marker
                                    :key="index"
                                    v-for="(m, index) in locationMarkers"
                                    :position="m.position"
                                    @click="center=m.position"
                                ></gmap-marker>
                            </gmap-map>
                        </div>
                        <div class="">
                            E﻿vent overview

                            At this event, we will explain all about our top-ranked MBA programs, both on-campus in
                            Tokyo and online, and create an opportunity to experience a free MBA trial class on
                            leadership.

                            COVID-19 and technological advancements have brought us to the age of disruptions, an era
                            that will change how we live, work, and do business. The role of leadership has shifted from
                            control to motivation. Those who know how to effectively build sustainable and resilient
                            organizations are today's successful leaders.

                            Join this session to learn the Japanese management way and how leaders not only explore and
                            analyze operating conditions but also understand how to cope with business crises through
                            empowering and motivating teams to foster a long-lasting organization

                            GLOBIS lecturer and Dean of the English MBA Program, Satoshi Hirose, will teach you
                            leadership management techniques that you can apply the next day through real business cases
                            seen in Vietnam.

                            At this event, you will also:

                            Learn about Japan’s No.1 MBA program and have your questions answered by our admissions
                            advisors
                            Explore your career opportunities through our partnerships with over 144 companies
                            Find out how you can apply and get tips for a strong application
                            Discover our scholarships and loan options for overseas students
                            A﻿genda

                            15:30 Reception and Individual Q&A

                            16:00 Introduction to GLOBIS

                            16:15 “Japanese Leadership Strategies” MBA Trial class

                            17:25 Program information

                            17:40 Q&A
                        </div>
                        <div class=" mt-3 mb-3">
                            <div class="mb-2"><span class="fw-bold">Share with friends</span></div>
                            <div>
                                <ShareNetwork style="margin-right: 25px"
                                              network="facebook"
                                              url="https://news.vuejs.org/issues/180"
                                              title="Say hi to Vite! A brand new, extremely fast development setup for Vue."
                                              description="This week, I’d like to introduce you to 'Vite', which means 'Fast'. It’s a brand new development setup created by Evan You."
                                              quote="The hot reload is so fast it\'s near instant. - Evan You"
                                              hashtags="vuejs,vite"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                         class="bi bi-facebook" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                    </svg>
                                </ShareNetwork>
                                <ShareNetwork style="margin-right: 25px"
                                              network="email"
                                              url="https://news.vuejs.org/issues/180"
                                              title="Say hi to Vite! A brand new, extremely fast development setup for Vue."
                                              description="This week, I’d like to introduce you to 'Vite', which means 'Fast'. It’s a brand new development setup created by Evan You."
                                              quote="The hot reload is so fast it\'s near instant. - Evan You"
                                              hashtags="vuejs,vite"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                         class="bi bi-envelope" viewBox="0 0 16 16">
                                        <path
                                            d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4Zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2Zm13 2.383-4.708 2.825L15 11.105V5.383Zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741ZM1 11.105l4.708-2.897L1 5.383v5.722Z"/>
                                    </svg>
                                </ShareNetwork>
                                <ShareNetwork
                                    network="twitter"
                                    url="https://news.vuejs.org/issues/180"
                                    title="Say hi to Vite! A brand new, extremely fast development setup for Vue."
                                    description="This week, I’d like to introduce you to 'Vite', which means 'Fast'. It’s a brand new development setup created by Evan You."
                                    quote="The hot reload is so fast it\'s near instant. - Evan You"
                                    hashtags="vuejs,vite"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                         class="bi bi-twitter" viewBox="0 0 16 16">
                                        <path
                                            d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z"/>
                                    </svg>
                                </ShareNetwork>
                            </div>
                        </div>
                    </div>
                    <el-button style="display: block;margin: auto;padding: 10px 100px;" type="primary"
                               @click='toggle = !toggle'>Hide
                    </el-button>
                    <div>
                        <el-tabs v-model="activeName" @tab-click="handleClick">
                            <el-tab-pane label="User" name="first">User</el-tab-pane>
                            <el-tab-pane label="Config" name="second">Config</el-tab-pane>
                            <el-tab-pane label="Role" name="third">Role</el-tab-pane>
                            <el-tab-pane label="Task" name="fourth">Task</el-tab-pane>
                        </el-tabs>
                    </div>
                    <div class="mb-5">
                        <div class="">
                            <div class="mt-3" style="font-weight: 800;font-size: 20px;color: #545454;">Events
                            </div>
                            <el-row>
                                <el-col :md="6" :sm="12" :xs="12" :lg="6" :xl="6" class="p-1" v-for="(o, index) in 4"
                                        :key="o">
                                    <el-card shadow="hover" :body-style="{ padding: '3px' }">
                                        <img
                                            src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png"
                                            class="image w-100">
                                        <div style="padding: 10px 5px;">
                                            <span style="font-weight: 800;font-size: 16px"><a href="/events/123/123"
                                                                                              style="color:black;">ĐÁNH THỨC SỰ GIÀU CÓ 55 - Hà Nội</a></span>
                                            <div class="bottom clearfix">
                                                <el-button type="text" class="button"><i class="el-icon-time"></i> <span
                                                    style="font-size: 12px">Thu, Feb 23, 10:00 PM + 189</span>
                                                </el-button>
                                                <span class="d-block">Trung tâm Tiệc cưới Louis Palace</span>
                                            </div>
                                        </div>
                                    </el-card>
                                </el-col>
                            </el-row>
                        </div>
                    </div>
                </el-col>
                <el-col :xs="24" :sm="24" :md="8" :lg="8" :xl="8">
                    <el-card class="box-card fixed" shadow="hover" style="border-radius: 20px">
                        <span style="display: block;text-align: center" class="mb-2">$0 - $79</span>
                        <el-button @click="dialogFormVisible = true" style="display:block;margin: auto;padding: 12px 80px" type="primary">Get tickets
                        </el-button>
                    </el-card>
                </el-col>
            </el-row>
            <el-dialog title="Title" :visible.sync="dialogFormVisible">
                <el-form :model="form" label-position="top" style="width: 100%">
                    <el-form-item label="Tên" :label-width="formLabelWidth">
                        <el-input v-model="form.name" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Email" :label-width="formLabelWidth">
                        <el-input v-model="form.email" autocomplete="off"></el-input>
                    </el-form-item>
                    <el-form-item label="Số điện thoại" :label-width="formLabelWidth">
                        <el-input v-model="form.phone" autocomplete="off"></el-input>
                    </el-form-item>
                </el-form>
                <span slot="footer" class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Hủy</el-button>
                <el-button type="primary" @click="dialogFormVisible = false">Xác nhận</el-button>
                </span>
            </el-dialog>
        </div>
    </div>
</template>

<script>
import 'element-tiptap/lib/index.css';
import {Notification} from 'element-ui';
import {ElementTiptap} from 'element-tiptap';
import {
    // necessary extensions
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
    name: "detail",
    data() {
        return {
            url: 'https://www.linkpicture.com/q/pexels-marcin-dampc-1684187-1-1.png',
            center: {
                lat: 39.7837304,
                lng: -100.4458825
            },
            dialogFormVisible: false,
            toggle: true,
            activeName: 'first',
            locationMarkers: [],
            locPlaces: [],
            existingPlace: null,
            form: {
                name: '',
                email: '',
                phone: '',

            },
            formLabelWidth: '120px'
        }
    },
    mounted() {
        this.locateGeoLocation();
    },
    methods: {
        handleClick(tab, event) {
            console.log(tab, event);
        },
        initMarker(loc) {
            this.existingPlace = loc;
        },
        locateGeoLocation: function () {
            navigator.geolocation.getCurrentPosition(res => {
                this.center = {
                    lat: res.coords.latitude,
                    lng: res.coords.longitude
                };
            });
        }
    }
}
</script>

<style>
@media (max-width: 480px) {
    .fixed {
        position: fixed;
        bottom: 0;
        width: 90%;
        z-index: 1;
        padding: 0;
    }
    .el-dialog{
        width: 100%;
    }
}


@media (max-width: 992px) {
    .fixed {
        position: fixed;
        bottom: 0;
        width: 90%;
        z-index: 1;
    }
    .el-dialog{
        width: 100%;
    }
}

.title-event-detail {
    font-weight: 800;
    font-size: 35px;
}

.el-col {
    border-radius: 4px;
}

.bg-purple-dark {
    background: #99a9bf;
}

.bg-purple {
    background: #d3dce6;
}

.bg-purple-light {
    background: #e5e9f2;
}

.grid-content {
    border-radius: 4px;
    min-height: 36px;
}
</style>
