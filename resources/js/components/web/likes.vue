<template>
    <div class="container">
        <span class="title-like">LIKES</span>
        <div class="p-5">
            <el-row>
                <el-col  class="p-2" v-for="(o, index) in 7" :key="o" >
                    <el-card shadow="hover" class="box-card">
                        <div class="row mb-2">
                            <div class="col-md-7">
                                <div class="title-item-like mb-2">
                                    <span>ĐÁNH THỨC SỰ GIÀU CÓ 55 - Hà Nội</span>
                                </div>
                                <div class="mb-2">
                                    <el-button type="text" class="button"><i class="el-icon-time"></i> Thu, Feb 23, 10:00 PM + 189</el-button>
                                </div>
                                <div class="mb-2">
                                    <span class="d-block">Trung tâm Tiệc cưới Louis Palace (đối diện Công viên Thiên Đường Bảo Sơn) Trung tâm Tiệc cưới Louis Palace (Km 5+200 Lê Trọng Tấn kéo dài)</span>
                                </div>
                            </div>
                            <div class="col-md-1">
                            </div>
                            <div class="col-md-4">
                                <img src="https://cdn.pixabay.com/photo/2015/04/23/22/00/tree-736885__480.jpg" class="image w-100">
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
    name: "likes",
    data() {
        return {

        }
    },
    mounted() {

    },
    methods: {

    }
}
</script>

<style scoped>
    .title-item-like{
        font-size: 20px;
        color: #545454;
        font-weight: 800;
    }
    .title-like{
        font-size: 45px;
        color: #545454;
        font-weight: 800;
    }
</style>
