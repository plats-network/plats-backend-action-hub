<template>
    <div >
        <el-carousel direction="vertical"  :autoplay="false">
            <el-carousel-item v-for="item in slider">
                <div class="block">
                    <el-image  :src="item" class="w-100"></el-image>
                </div>
            </el-carousel-item>
        </el-carousel>
        <div class="container">
            <div class="mt-3" style="font-weight: 800;font-size: 20px;color: #545454;">Events
            </div>
            <el-row>
                <el-col :md="6" :sm="12" :xs="12" :lg="6" :xl="6" class="p-2" v-for="(o, index) in 7" :key="o" >
                    <el-card shadow="hover" :body-style="{ padding: '5px' }">
                        <img src="https://shadow.elemecdn.com/app/element/hamburger.9cf7b091-55e9-11e9-a976-7f4d0b07eef6.png" class="image w-100">
                        <button type="button" class="btn btn-outline-primary" style="padding: 10px 10px;border-radius: 20px;position: relative;top:-16px;float: right;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01L8 2.748zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143c.06.055.119.112.176.171a3.12 3.12 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15z"></path>
                            </svg>
                        </button>
                        <div style="padding: 22px 5px;">
                            <span style="font-weight: 800;font-size: 16px"><a href="/events/123" style="color:black;">ĐÁNH THỨC SỰ GIÀU CÓ 55 - Hà Nội</a></span>
                            <div class="bottom clearfix">
                                <el-button type="text" class="button"><i class="el-icon-time"></i> Thu, Feb 23, 10:00 PM + 189</el-button>
                                <span class="d-block">Trung tâm Tiệc cưới Louis Palace</span>
                            </div>
                        </div>
                    </el-card>
                </el-col>
            </el-row>
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
    name: "home",
    components: {
        'el-tiptap': ElementTiptap,
    },
    data() {
        return {
            slider:[
                'https://www.linkpicture.com/q/pexels-marcin-dampc-1684187-1-1.png','https://jssors8.azureedge.net/demos/img/gallery/980x380/045.jpg'
            ],
            currentDate: new Date()
        }
    }
}
</script>

<style >
.btn-outline-primary{
    background: white;
}
@media (max-width: 480px) {
    .el-carousel__container { height: 230px;background-position: center;
        background-size: cover; }
}

@media (max-width: 768px) {
    .el-carousel__container { height: 230px; background-position: center;
        background-size: cover;}
}

@media (min-width: 992px) {
    .el-carousel__container { height: 530px; background-position: center;
        background-size: cover;}
}
</style>
