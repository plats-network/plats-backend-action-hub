<template>
    <div>
        <div class="mb-2">
            <el-button type="primary" @click="handleEditEvent">Edit</el-button>
            <a href="/events" ><el-button type="primary" icon="el-icon-back"></el-button></a>
        </div>
        <el-row :gutter="20">
            <el-col :span="12"  >
                <div  class="p-2" style="border: 1px solid #EBEEF5">
                    <div v-show="form.task_galleries.length > 0">
                        <span>Slider</span>
                        <el-carousel indicator-position="outside">
                            <el-carousel-item  v-for="(event, index) in form.task_galleries" >
                                <div>
                                    <el-image :src="event.url" class=""></el-image>
                                </div>
                            </el-carousel-item>
                        </el-carousel>
                    </div>
                    <div class="demo-image">
                        <span>Image</span>
                        <div class="block">
                            <img class="w-100"
                                style="height: auto ;border-radius: 20px"
                                :src="form.banner_url"
                            >
                        </div>
                    </div>
                    <div class="mt-3">
                        <el-row :gutter="10">
                            <el-col>
                                <div>
                                    <span class=""> Title :  {{form.name}}</span>
                                </div>
                                <div>
                                    <div class="mt-3 mb-3">
                                        <el-row :gutter="10">
                                            <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                                                <div class="mb-2"> Time : {{form.start_at | moment}} - {{form.end_at | moment}}
                                                </div>
                                            </el-col>
                                            <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                                                <div class="mb-2"> Location : {{form.address}}
                                                </div>
                                            </el-col>
                                            <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                                                <div class="mb-2"> Order : {{form.order}}
                                                </div>
                                            </el-col>
                                            <el-col :xs="24" :sm="24" :md="12" :lg="12" :xl="12">
                                                <div class="mb-2"> Lat : {{form.lat}}  Long : {{form.lng}}
                                                </div>

                                            </el-col>
                                        </el-row>
                                    </div>
                                    <div> Description :
                                        <div class="" v-html="form.description"></div>
                                    </div>
                                </div>
                            </el-col>
                        </el-row>
                    </div>
                </div>
            </el-col>
            <el-col  :span="12" >
                <div class="p-2" style="border: 1px solid #EBEEF5">
                    <div v-if="form.sessions !== null">
                        <span>Sessions</span>
                        <el-card shadow="hover"  class="box-card mb-2" >
                            <div slot="header" class="clearfix">
                                <el-image :src="form.sessions.banner_url"></el-image>
                                <br>
                                <span><strong>Title :</strong>   {{form.sessions.name}}</span>
                                <br>
                                <span><strong>Max Job :</strong> {{form.sessions.max_job}}</span>
                                <br>
                                <span><strong>Description:</strong> <div v-html="form.sessions.description"></div></span>
                            </div>
                            <div v-for="detail in form.sessions.detail" class="text item mb-1">
                                <el-alert
                                    :closable="false"
                                    :title="detail.name"
                                    type="success"
                                    show-icon>
                                </el-alert>
                            </div>
                        </el-card>
                    </div>
                    <div  v-if="form.booths !== null">
                        <span>Booths</span>
                        <el-card shadow="hover" class="box-card mb-2" >
                            <div slot="header" class="clearfix">
                                <el-image :src="form.booths.banner_url"></el-image>
                                <br>
                                <span><strong>Title :</strong> {{form.booths.name}}</span>
                                <br>
                                <span><strong>Max Job :</strong> {{form.booths.max_job}}</span>
                                <br>
                                <span><strong>Description:</strong> <div v-html="form.booths.description"></div></span>
                            </div>
                            <div v-for="detail in form.booths.detail" class="text item mb-1">
                                <el-alert
                                    :closable="false"
                                    :title="detail.name"
                                    type="success"
                                    show-icon>
                                </el-alert>
                            </div>
                        </el-card>
                    </div>
                    <div v-if="form.quiz.length > 0">
                        <span>Quiz</span>
                        <el-card shadow="hover" v-for="detail in form.quiz"  class="box-card mb-2" >
                            <div slot="header" class="clearfix">
                                <span> Name : {{ detail.name}}</span>
                                <span>Order : {{ detail.order}}</span>
                                <span>Time : {{ detail.time_quiz}}</span>
                                <span>Status : {{ detail.status}}</span>
                            </div>
                            <div v-for="detail in detail.detail" class="text item mb-1">
                                <el-alert
                                    :closable="false"
                                    v-if="detail.status == true"
                                    :title="detail.name"
                                    type="success"
                                    show-icon>
                                </el-alert>
                                <el-alert
                                    :closable="false"
                                    v-if="detail.status == false"
                                    :title="detail.name"
                                    type="info"
                                    show-icon>
                                </el-alert>
                            </div>
                        </el-card>
                    </div>
                    <div v-if="form.task_event_socials !== null">
                        <span>Social</span>
                        <el-card shadow="hover"  class="box-card mb-2" >
                            <div slot="header" class="clearfix">
                                <el-row :gutter="20" class="p-5">
                                    <el-col >
                                        <el-checkbox  v-model="form.task_event_socials.is_comment">Comment</el-checkbox>
                                        <el-checkbox v-model="form.task_event_socials.is_like">Like</el-checkbox>
                                        <el-checkbox v-model="form.task_event_socials.is_retweet">Retweet</el-checkbox>
                                        <el-checkbox v-model="form.task_event_socials.is_tweet">Tweet</el-checkbox>
                                    </el-col>
                                    <el-col >
                                        <div >
                                            <span> URL</span>
                                            <el-input class="mb-2 mt-2" maxlength="255" show-word-limit  placeholder="https://twitter.com/elonmusk/status/1638381090368012289" v-model="form.task_event_socials.url"></el-input>
                                        </div>
                                        <div >
                                            <span> Text</span>
                                            <el-input class="mb-2 mt-2" maxlength="255" show-word-limit  placeholder="Text ..." v-model="form.task_event_socials.text"></el-input>
                                        </div>
                                    </el-col>
                                </el-row>
                            </div>
                        </el-card>
                    </div>
                </div>
            </el-col>
        </el-row>
    </div>
</template>

<script>
import { ref } from 'vue'
import 'element-tiptap/lib/index.css';
import {Notification} from 'element-ui';
import {ElementTiptap} from 'element-tiptap';
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
import moment from "moment";
export default {
    name: "preview",
    props: ['task_id','link_cws'],
    components: {
        'el-tiptap': ElementTiptap,
    },
    data() {
        return {
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
            },
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
            task_event_socials:{
                url:'',
                text:'',
                is_comment:false,
                is_like:false,
                is_retweet:false,
                is_tweet:false,
                type:0,
            },
        }
    },
    methods: {
        handleEditEvent(){
            window.location.href = '/events/edit/'+ this.task_id;
        },
        listData() {
            this.drawerEdit = true
            const loading = this.$loading({
                lock: true,
                text: 'Loading',
                spinner: 'el-icon-loading',
                background: 'rgba(0, 0, 0, 0.7)'
            });
            let url = this.link_cws+'/api/tasks-cws/edit/'+ this.task_id;
            axios.get(url).then(e => {
                this.form = e.data.data.message;
                this.quiz = e.data.data.message.quiz
                this.sessions = e.data.data.message.sessions
                this.task_event_socials = e.data.data.message.task_event_socials
                this.booths = e.data.data.message.booths
                loading.close();

            }).catch((_) => {
                loading.close();
            })
        },
    },
    mounted: function () {
        this.listData()
    },
    filters: {
        moment: function (date) {
            return moment(date).format(' YYYY-MM-DD HH:mm:ss ');
        },
    }
}
</script>

<style scoped>

</style>
